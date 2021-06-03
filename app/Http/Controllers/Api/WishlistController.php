<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Wishlist;
use App\WishlistCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function createCollection(Request $request)
    {

        if (Auth::check()) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
            
                if($errors->first('name')){
                    return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
                }
            }

            /** Find if he already created that wishlist with that name */

            $ifExist = WishlistCollection::where('name',$request->name)->where('user_id',Auth::user()->id)->first();

            if(isset($ifExist)){
                
                return response()->json(['msg' => 'Collection with this name already exist !','status' => 'fail']);

            }

            $c = WishlistCollection::create([
                'name' => $request->name,
                'user_id' => Auth::user()->id,
            ]);

            return response()->json(['msg' => $request->name . ' collection created successfully !','status' => 'success','collection_id' => $c->id ]);

        } else {
            return response()->json(['msg' => 'You\re not logged in !','status' => 'fail']);
        }

    }

    public function listCollection()
    {

        if (!Auth::guard('api')->check()) {
            return response()->json(['msg' => 'You\re not logged in !','status' => 'fail']);
        }

        $collection = WishlistCollection::where('user_id', '=', Auth::user()->id)->get();

        $result[] = array(
            'id' => 0,
            'collectionname' => 'Favorites',
            'url' => url('api/wishlist'),
            'iteminlist' => Auth::user()->wishlist()->where('collection_id','=',NULL)->count(),
            'imagepath' => url('variantimages/thumbnails/'),
            'topImages' => $this->topCollectionItemImages(0) != '' ? $this->topCollectionItemImages(0) : null,
        );

        foreach ($collection as $coll) {

            $result[] = array(
                'id' => $coll->id,
                'collectionname' => $coll->name,
                'url' => url('api/collection/' . $coll->id),
                'iteminlist' => $coll->items()->count(),
                'imagepath' => url('variantimages/thumbnails/'),
                'topImages' => $this->topCollectionItemImages($coll) != '' ? $this->topCollectionItemImages($coll) : null,
            );

        }

        return response()->json(['collection' => $result,'status' => 'success']);

    }

    public function topCollectionItemImages($coll)
    {

        $images = array();

        if ($coll != '0') {

            foreach ($coll->items->take(8) as $item) {

                if (isset($item->variant)) {

                    if (isset($item->variant->variantimages)) {

                        array_push($images, $item->variant->variantimages['main_image']);

                    }

                }

            }
        } else {

            foreach (Auth::user()->wishlist as $item) {

                if (isset($item->variant)) {

                    if (isset($item->variant->variantimages)) {

                        array_push($images, $item->variant->variantimages['main_image']);

                    }

                }

            }

        }

        shuffle($images);

        return $images;

    }

    public function listCollectionItemsByID(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'currency' => 'required|max:3|min:3',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            
			if($errors->first('currency')){
				return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
			}
        }

        if (!Auth::guard('api')->check()) {

            return response()->json(['msg' => 'You\re not logged in !','status' => 'fail']);

        }

        $collection = WishlistCollection::find($id);

        if (!$collection) {
            return response()->json(['msg' => 'Collection not found !', 'status' => 'fail']);
        }

        $result = array(
            'id' => $collection->id,
            'name' => $collection->name,
            'items' => count($this->collectionItem($collection, $request->currency)) > 0 ? $this->collectionItem($collection, $request->currency) : 'No items in this collection !',
        );

        return response()->json(['data' => $result,'status' => 'success']);

    }

    public function collectionItem($collection, $currency)
    {

        $wishlistItem = array();

        foreach ($collection->items as $item) {

            $productData = new ProductController;

            $price = $productData->getprice($item->variant->products, $item->variant)->getData();

            $rating = $productData->getproductrating($item->variant->products);

            $rates = new CurrencyController;

            $rate = $rates->fetchRates($currency)->getData();

            $getvariant = new CartController;

            // Pushing value in main result

            $wishlistItem[] = array(
                'wishlistid' => $item->id,
                'productid' => $item->variant->products->id,
                'variantid' => $item->variant->id,
                'productname' => $item->variant->products->name,
                'variant' => $getvariant->variantDetail($item->variant),
                'thumpath' => url('variantimages/thumbnails/'),
                'thumbnail' => $item->variant->variantimages->main_image,
                'price' => (double) sprintf('%.2f', $price->mainprice * $rate->exchange_rate),
                'offerprice' => (double) sprintf("%.2f", $price->offerprice * $rate->exchange_rate),
                'stock' => $item->variant->stock != 0 ? "In Stock" : "Out of Stock",
                'rating' => (double) $rating,
                'symbol' => $rate->symbol,
            );

        }

        rsort($wishlistItem);

        return $wishlistItem;

    }

    public function isItemInWishlist($variant){

        

        if(Auth::guard('api')->check()){

            $result = Wishlist::where('user_id',Auth::guard('api')->user()->id)->where('pro_id',$variant->id)->first();

           if(isset($result)){
                return 1;
           }else{
               return 0;
           }

        }else{

            return 0;

        }

    }
}
