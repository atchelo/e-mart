<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use Session;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class LanguageController extends Controller
{
    public function index()
    {   
        
        $allLang = Language::where('status', '=', 1)->get();
        return view('admindesk.language.index', compact('allLang'));
    }

    public function editStaticTrans($langCode)
    {
        $findlang = Language::where('lang_code', '=', $langCode)->first();

        if (isset($findlang))
        {

            if (file_exists(base_path().'/resources/lang/' . $findlang->lang_code . '/staticwords.php'))
            {
                $file = file_get_contents(base_path().'/resources/lang/'.$findlang->lang_code.'/staticwords.php');
                return view('admindesk.language.staticword', compact('findlang', 'file'));
            }
            else
            {

                if (is_dir(base_path().'/resources/lang/' . $findlang->lang_code))
                {
                    copy(base_path().'/resources/lang/en/staticwords.php', base_path().'/resources/lang/' . $findlang->lang_code . '/staticwords.php');
                    $file = file_get_contents(base_path().'/resources/lang/'.$findlang->lang_code.'/staticwords.php');
                    return view('admindesk.language.staticword', compact('findlang', 'file'));
                }
                else
                {
                    mkdir(base_path().'/resources/lang/' . $findlang->lang_code);
                    copy(base_path().'/resources/lang/en/staticwords.php', base_path().'/resources/lang/' . $findlang->lang_code . '/staticwords.php');
                    $file = file_get_contents("../resources/lang/$findlang->lang_code/staticwords.php");
                    return view('admindesk.language.staticword', compact('findlang', 'file'));
                }

            }

        }
        else
        {
            return back()
                ->with('warning', '404 Language Not found !');
        }
    }

    public function updateStaticTrans(Request $request, $langCode)
    {
        $findlang = Language::where('lang_code', '=', $langCode)->first();
        if (isset($findlang))
        {

            $transfile = $request->transfile;
            file_put_contents('../resources/lang/' . $findlang->lang_code . '/staticwords.php', $transfile . PHP_EOL);
            notify()->success('Language Translations Updated !');
            return back();

        }
        else
        {
            notify()->error('404 | Language not found!');
            return back();
        }
    }

    public function store(Request $request)
    {

        

        if (isset($request->name))
        {

            try{

                $ifalready = Language::where('lang_code',$request->lang_code)->first();

            if(isset($ifalready)){

                $ifalready->status = 1;

                if(isset($request->def)){
                    $findlang = Language::where('def', '=', 1)->first();
                    
                    if (isset($findlang))
                    {
                        $findlang->def = 0;
                        $findlang->save();
                    }

                     $ifalready->def = 1;
                     
                     Session::put('changed_language', $ifalready->lang_code);
                }


                $ifalready->rtl_available = isset($request->rtl_available) ? 1 : 0;
                $ifalready->save();


            }else{

                $newlan = new Language;
                $newlan->lang_code = $request->lang_code;
                $newlan->status = 1;
                $newlan->name = $request->name;
                $newlan->rtl_available = isset($request->rtl_available) ? 1 : 0;

                if (isset($newlan))
                {

                    if (isset($request->def))
                    {
                        $newlan->def = 1;
                        $findlang = Language::where('def', '=', 1)->first();
                        if (isset($findlang))
                        {
                            $findlang->def = 0;
                            $findlang->save();
                        }
                        Session::put('changed_language', $newlan->lang_code);
                    }
                    else
                    {
                        $newlan->def = 0;

                    }

                    $newlan->save();

                } 
            }

            notify()->success('Language added !');
            return back();

        }catch(\Exception $e){
                notify()->warning($e->getMessage());
                return back();
        }

        }
        else
        {
            notify()->error('Oops ! Something went wrong !');
            return back();
        }
        notify()->success('Language has been added !');
        return back();

    }

    public function update(Request $request, $id)
    {
        $findlang = Language::find($id);
        $input = $request->all();

        if (isset($findlang))
        {

            if (isset($request->def))
            {
                    
               
                    $deflang = Language::where('def', '=', 1)->first();

                    if($deflang->id != $findlang->id){

                        $deflang->def = 0;
                        $deflang->save();
                    
                        $input['def'] = 1;
                        
                    }else{
                        $input['def'] = 1;
                    }
                    
                    $input['rtl_available'] = isset($request->rtl_available) ? 1 : 0;
                    $findlang->update($input);
                
                
                    Session::put('changed_language', $findlang->lang_code);
                

            }
            else
            {

                if($findlang->def == 1){
                    $input['def'] = 1;
                }else{
                    $input['def'] = 0;
                }

                $input['rtl_available'] = isset($request->rtl_available) ? 1 : 0;
                $findlang->update($input);
            }

            notify()->success('Language Details Updated !');
            return back();
        }
        else
        {
            notify()->error('404 | Language Not found !');
            return back();
        }

    }

    public function delete($id)
    {

        $lang = Language::find($id);

        if (isset($lang))
        {

            if ($lang->def == 1)
            {
                notify()->warning('Default language cannot be deleted !');
                return back();
            }
            else
            {
                $lang->status = 0;
                $lang->save();
                notify()->info('Language Deleted !');
                return back();
            }

        }
        else
        {
            notify()->error('404 Language Not found !');
            return back();
        }
    }
}

