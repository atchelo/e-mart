<?php

namespace App\Helpers;

use App\AddSubVariant;
use App\ProductAttributes;

class ProductUrl
{

    public static function getUrl($id)
    {

        $pro = AddSubVariant::find($id);

        if (isset($pro)) {
            $var_name_count = count($pro['main_attr_id']);

            $name = array();

            $var_name = array();

            for ($i = 0; $i < $var_name_count; $i++) {

                $var_id = $pro['main_attr_id'][$i];
                $var_name[$i] = $pro['main_attr_value'][$var_id];
                $name[$i] = ProductAttributes::where('id', $var_id)->first();

            }

            try {
                return url('details') . '/' . $pro->products->id . '?' . $name[0]['attr_name'] . '=' . $var_name[0] . '&' . $name[1]['attr_name'] . '=' . $var_name[1];
            } catch (\Exception $e) {
                return url('details') . '/' . $pro->products->id . '?' . $name[0]['attr_name'] . '=' . $var_name[0];
            }

        } else {
            return '#';
        }

    }
}
