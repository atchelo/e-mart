<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;
use Yajra\DataTables\Facades\DataTables;
use Zip;
use ZipArchive;

class AddOnManagerController extends Controller
{
    public function index(){

        $modules = Module::toCollection();

        $modules = $modules->map(function($module){
            
            $json = @file_get_contents(base_path().'/Modules/'.$module.'/module.json');

            $module = json_decode($json, true);

            $module['status'] = Module::find($module['name'])->isEnabled() ? 1 : 0;

            return $module;

        });

        if(request()->ajax()){
            return DataTables::of($modules)
                  ->addIndexColumn()
                  ->addColumn('image',function($row){
                        return '<img class="pull-left" src="'.Module::asset($row['alias'].':logo/'.$row['alias'].'.png').'"/>';
                  })
                  ->addColumn('name',function($row){
                      $html = '<b>'.$row['name'].'</b>';
                      $html .= '<p>'.$row['description'].'</p>';
                      return $html;
                  })
                  ->addColumn('status','admindesk.addonmanager.status')
                  ->addColumn('version',function($row){
                        return $row['version'];
                  })
                  ->addColumn('action','admindesk.addonmanager.action')
                  ->rawColumns(['image','name', 'status', 'version','action'])
                  ->make(true);
        }
        
        return view('admindesk.addonmanager.index',compact('modules'));

    }

    public function toggle(Request $request){  

        if($request->ajax()){

            $module = Module::find($request->modulename);

            if(!isset($module)){
                return response()->json(['msg' => 'Module not found','status' => 'fail']);
            }

            if(env('DEMO_LOCK') == 1){
                return response()->json(['msg' => 'This action is disabled in demo !','status' => 'fail']);
            }

            if($request->status == 0){
                $module->disable();
                return response()->json(['msg' => $request->modulename.' Module disabled !','status' => 'success']);
            }else{
                $module->enable();
                return response()->json(['msg' => $request->modulename.' Module enabled !','status' => 'success']);
            }

        }

    }

    public function install(Request $request){

        $validator = Validator::make(
            [
                'file' => $request->addon_file,
                'extension' => strtolower($request->addon_file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:zip,7zip,gzip',
            ]

        );

        if ($validator->fails()) {
            return back()->withErrors('File should be a valid add-on zip file !');
        }

        ini_set('max_execution_time', 300);

        $filename = $request->addon_file;

        $modulename = str_replace('.'.$filename->getClientOriginalExtension(),'',$filename->getClientOriginalName());

        $zip = new ZipArchive;

        $zipped = $zip->open($filename,ZipArchive::CREATE);

        if($zipped){

            // $zip->getFromName($modulename.'/module.json');
        
            $extract = $zip->extractTo(base_path().'/Modules/');

            if($extract){

                $module = Module::find($modulename);

                $module->enable();

                Artisan::call('module:publish');

                notify()->success($modulename.' Module Installed Successfully','Installed');

                return back();

            }
        }

        $zip->close();  
         

    }

    public function delete(Request $request){

        if(env('DEMO_LOCK') == 1){
            notify()->error('This function is disabled in demo !');
            return back();
        }

        $module = Module::find($request->modulename);

        if(!isset($module)){
            notify()->error('Module not found !','404');
            return back();
        }

        $module->delete();

        notify()->success('Module deleted !','Success');

        return back();

    }
}
