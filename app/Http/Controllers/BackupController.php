<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Svg\Tag\Rect;
use App\Http\Controllers\GenralController;
use DotenvEditor;

class BackupController extends Controller
{
    public function get(){

        Artisan::call('backup:list');
        
        $html  =   '<pre>';
        $html .=    Artisan::output();
        $html .=   '</pre>';
        
        return view('admindesk.backup.index',compact('html'));

    }

    public function updatedumpPath(Request $request){

       

        $env_keys_save = DotenvEditor::setKeys([
            'SQL_DUMP_PATH' => $request->SQL_DUMP_PATH
        ]);

        $env_keys_save->save();

        notify()->success('SQL dump path updated !');
        return back();

    }

    public function process(Request $request){

        if(env('DEMO_LOCK') == 1){
            notify()->error("This action is disabled in demo !");
            return back();
        }
       
        try{
            
            set_time_limit(0);

            if($request->type == 'all'){
                Artisan::call('backup:run');
            }

            if($request->type == 'onlyfiles'){

                Artisan::call('backup:run --only-files');

            }

            if($request->type == 'onlydb'){

                Artisan::call('backup:run --only-db');

            }

        }catch(\Exception $e){
            notify()->error($e->getMessage());
            return back();
        }

        notify()->success('Backup completed !','Done !');

        return back();

    }

    public function download(Request $request, $filename){

        if(env('DEMO_LOCK') == 1){
            notify()->error("This action is disabled in demo !");
            return back();
        }

        if (! $request->hasValidSignature()) {
            notify()->error('Download Link is invalid or expired !');
            return redirect(route('admindesk.backup.settings'));
        }

        $filePath = storage_path().'/app/'.config('app.name').'/'.$filename;

        $fileContent = file_get_contents($filePath);

        $response = response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);

        return $response;

    }
}
