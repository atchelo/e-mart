<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class LoadMoreController extends Controller
{
    

    function load_data(Request $request)
    {
        if ($request->ajax())
        {
            if ($request->id > 0)
            {
                $data = DB::table('products')->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data = DB::table('products')->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            $output = '';
            $last_id = '';

            if (!$data->isEmpty())
            {
                foreach ($data as $row)
                {
                    $output .= '
        <div class="row">
         <div class="col-md-12">
          <h3 class="text-info"><b>' . $row->name . '</b></h3>
          <p>' . $row->price . '</p>
          <br />
          <div class="col-md-6">
           <p><b>Publish Date - ' . $row->offer_price . '</b></p>
          </div>
          <div class="col-md-6" align="right">
           <p><b><i>By - ' . $row->des . '</i></b></p>
          </div>
          <br />
          <hr />
         </div>         
        </div>
        ';
                    $last_id = $row->id;
                }
                $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="' . $last_id . '" id="load_more_button">Load More</button>
       </div>
       ';
            }
            else
            {
                $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
       </div>
       ';
            }
            echo $output;
        }
    }
}

