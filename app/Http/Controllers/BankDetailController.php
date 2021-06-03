<?php
namespace App\Http\Controllers;

use App\BankDetail;
use Illuminate\Http\Request;
use DotenvEditor;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class BankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank = BankDetail::first();
        return view("admindesk.bankDetail.edit", compact("bank"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cat = BankDetail::first();
        $input = $request->all();
        
        $env_keys_save = DotenvEditor::setKeys([
            'BANK_TRANSFER' => $request->BANK_TRANSFER ? "1" : "0"
        ]);

        $env_keys_save->save();
        
        if (empty($cat))
        {
            $data = $this->validate($request, ["bankname" => "required", 'branchname' => 'required|not_in:0', 'ifsc' => 'required|not_in:0', "account" => "required", "acountname" => "required", ], [

            "bankname.required" => "Bank Name Fild is required", "branchname.required" => "Branch Name Fild is required", "ifsc.required" => "Ifsc Fild is required",

            ]);

            $input = $request->all();

            $data = BankDetail::create($input);

            
            

            $data->save();
            notify()->success('Bank details has been updated !');
            return back();
        }
        else
        {
            $cat->update($input);
            notify()->success('Bank details has been updated !');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function show(BankDetail $bankDetail)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = BankDetail::findOrFail($id);
        return view("admindesk.bankDetail.edit", compact("bank"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $data = $this->validate($request, ["bankname" => "required", 'branchname' => 'required|not_in:0', 'ifsc' => 'required|not_in:0', "account" => "required", "acountname" => "required", ], [

        "bankname.required" => "Bank Name Fild is required", "branchname.required" => "Branch Name Fild is required", "ifsc.required" => "Ifsc Fild is required",

        ]);

        $slider = BankDetail::find($id);
        $input = $request->all();
        $slider->update($input);
        return redirect('admindesk/bank_details')->with('updated', 'Bank Details has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = BankDetail::find($id);
        $value = $cat->delete();
        if ($value)
        {
            session()->flash("deleted", "Bank Details Has Been Deleted");
            return redirect("admindesk/bank_details");
        }
    }
}

