<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReportProduct;
use DataTables;

class ReportProductController extends Controller
{
    public function post(Request $request,$id)
    {
    	$input = $request->all();
    	$newreport = new ReportProduct;
      $input['des'] = clean($request->des);
    	$input['pro_id'] = $id;
    	$newreport->create($input);
      notify()->success('Report submitted and its under review');
    	return redirect('/');
    }

    public function get(Request $request){
    	

        $data = \DB::table('report_products')->join('products','report_products.pro_id','=','products.id')->select('products.name as proname','report_products.*')->get();

        if($request->ajax()){

            return DataTables::of($data)
               ->addIndexColumn()
               ->addColumn('info','admindesk.reportproduct.report')
               ->addColumn('rdtl',function($row){
                    return $row->des;
               })
               ->addColumn('rpon',function($row){
                    return $date = date('d-m-Y h:i A',strtotime($row->created_at));
               })
               ->rawColumns(['info','rdtl','rpon'])
               ->make(true);

        }

        return view('admindesk.reportproduct.index');
    }
}
