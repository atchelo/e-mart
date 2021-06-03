<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VariantImages;
use Intervention\Image\ImageManagerStatic as Image;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class DeleteImageController extends Controller
{
    public function deleteimg1(Request $request, $id)
    {
        
        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image1 = NULL;

        $del->save();

        return "Success";

    }

    public function deleteimg2(Request $request, $id)
    {

        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        if (file_exists('../public/variantimages/hoverthumbnail' . $request->getval)) {
            unlink( public_path() .'/variantimages/hoverthumbnail/' . $request->getval);
        }

        $del->image2 = NULL;

        $del->save();

        return "Success";

    }

    public function deleteimg3(Request $request, $id)
    {

        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image3 = NULL;

        $del->save();

        return "Success";

    }

    public function deleteimg4(Request $request, $id)
    {

        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image4 = NULL;

        $del->save();

        return "Success";

    }

    public function deleteimg5(Request $request, $id)
    {

        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image5 = NULL;

        $del->save();

        return "Success";

    }

    public function deleteimg6(Request $request, $id)
    {

        $del = VariantImages::findorfail($id);
        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image6 = NULL;

        $del->save();

        return "Success";

    }

    public function setdef(Request $request, $id)
    {
        
        //if($request->ajax()){
            $findrow = VariantImages::where('var_id', $id)->first();

            $thumbpath = public_path() . '/variantimages/thumbnails';

            if (file_exists($thumbpath . '/' . $findrow->main_image)) {
                unlink($thumbpath . '/' . $findrow->main_image);
            }

            /** Get requested image and convert it to thumbnails */

            $img = Image::make(@file_get_contents('../public/variantimages/'.$request->defimage));

            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbpath . '/' . $request->defimage);

            $findrow->main_image = $request->defimage;

            $findrow->save();

            return "Success";
        //}
        

    }

}

