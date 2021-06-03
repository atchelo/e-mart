<?php

namespace App\Http\Controllers;

use App\VariantImages;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class UpdaterScriptController extends Controller
{
    public function convert()
    {
    	# ==========================================================
    	# =           Until you not see Hurray run it :D           =
    	# ==========================================================
        
        if(is_dir('../public/variantimages/hoverthumbnail') && is_dir('../public/variantimages/thumbnails')){

            alert()->basic("Don't run if you already done ! ",'Image conversion already done !')->persistent('Close')->autoclose(8000);
            return redirect('/');
            
        }
    	
        $data = VariantImages::all();

        $path = '../public/variantimages';

        $thumbpath = '../public/variantimages/thumbnails';

        $hoverthumbpath = '../public/variantimages/hoverthumbnail';

        File::makeDirectory($thumbpath, $mode = 0777, true, true);

        File::makeDirectory($hoverthumbpath, $mode = 0777, true, true);

        ini_set('max_execution_time', '0'); // for infinite time of execution

        foreach ($data as $key => $value) {

            if (!strstr($value->main_image, '.png') && $value->main_image != null) {

                try {
                    $img = Image::make(@file_get_contents(public_path() . '/variantimages/' . $value->image1));

                    /** Making Main Image and Saving it on Thumbnail */

                    if (isset($img)) {
                        $img->resize(300, 300, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->save($thumbpath . '/' . $value->main_image . '.png', 95);

                        VariantImages::where('id', '=', $value->id)->update(['main_image' => $value->main_image . '.png']);
                    }
                } catch (\Exception $e) {

                }

            }

            if (!strstr($value->image2, '.png') && $value->image2 != null) {

                try {
                    $img = Image::make(@file_get_contents(public_path() . '/variantimages/' . $value->image2));
                    $img->save($path . '/' . $value->image2 . '.png', 95);

                    /** Saving Image 2 for Hover Thumbnail */
                    $img->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($hoverthumbpath . '/' . $value->image2 . '.png', 95);
                    VariantImages::where('id', '=', $value->id)->update(['image2' => $value->image2 . '.png']);
                } catch (\Exception $e) {
                    //return $e;
                }
                /**End */
            }

        }
        
        alert()->basic('Image conversion successfully !', "Hurray you're done :D")->persistent('Close')->autoclose(8000);
        return redirect('/');
    }
}
