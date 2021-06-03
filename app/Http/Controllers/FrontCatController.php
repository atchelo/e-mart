<?php
namespace App\Http\Controllers;

use App\FrontCat;
use Illuminate\Http\Request;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class FrontCatController extends Controller
{

    public function store(Request $request)
    {
        $NewProCat = FrontCat::first();
        $input = $request->all();

        if (empty($NewProCat)) {

            if ($request->name) {
                $name = implode(",", $request->name);

                $input['name'] = $name;

            } else {
                $input['name'] = null;
            }

            $data = FrontCat::create($input);

            $data->save();

            return back()
                ->with("added", "New Product Category Has Been Added");
        } else {
            if ($request->name) {
                $name = implode(",", $request->name);

                $input['name'] = $name;

            } else {
                $input['name'] = null;
            }

            $NewProCat->update($input);

            return back()->with("updated", "New Product Category Has Been Update");

        }
    }

}
