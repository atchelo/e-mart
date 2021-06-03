<?php
namespace App\Http\Controllers;

use App\AddProductVariant;
use App\AddSubVariant;
use App\admin_return_product;
use App\Brand;
use App\Cart;
use App\Category;
use App\Commission;
use App\CommissionSetting;
use App\FaqProduct;
use App\Genral;
use App\Grandcategory;
use App\Jobs\CartPriceChange;
use App\Jobs\GuestCartPriceChange;
use App\Product;
use App\ProductSpecifications;
use App\RealatedProduct;
use App\Related_setting;
use App\Shipping;
use App\Store;
use App\Subcategory;
use App\TaxClass;
use App\UserReview;
use Auth;
use Avatar;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use Rap2hpoutre\FastExcel\FastExcel;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allvariants($id)
    {
        $pro = Product::with(['category' => function ($q) {

            return $q->where('status', '=', '1')->select('id', 'title');

        }, 'subcategory' => function ($q) {

            return $q->where('status', '1')->select('id', 'title');

        }, 'childcat' => function ($q) {

            return $q->where('status', '=', '1')->select('id', 'title');

        },'store' =>  function ($q) {

            $q->select('id', 'name','status');

        }])->whereHas('store',function($q){

            return $q->where('status','=','1');

        })->with(['vender' => function ($q) {

            return $q->select('id', 'name');

        }])->whereHas('vender', function ($query) {

            return $query->where('status', '=', '1')->where('is_verified', '1');

        })->with('subvariants')->with('subvariants.variantimages')->findOrFail($id);

        return view('admindesk.product.allvar', compact('pro'));
    }

    public function storeSpecs(Request $request, $id)
    {

        $product = Product::find($id);

        if (isset($product)) {
            foreach ($request->prokeys as $key => $value) {

                $newspec = new ProductSpecifications;
                $newspec->pro_id = $product->id;
                $newspec->prokeys = $value;
                $newspec->provalues = $request->provalues[$key];
                $newspec->save();
            }
        }

        notify()->success('Product Specification created !');
        return back();

    }

    public function deleteSpecs(Request $request, $id)
    {

        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {

            notify()->warning('Please select one of them to delete');
            return back();
        }

        foreach ($request->checked as $key => $check) {
            $specs = ProductSpecifications::find($check);

            if (isset($specs)) {

                $specs->delete();

            }
        }

        notify()->success('Selected specifications has been deleted !');
        return back();

    }

    public function updateSpecs(Request $request, $id)
    {
        $spec = ProductSpecifications::findOrFail($id);

        $spec->prokeys = $request->pro_key;
        $spec->provalues = $request->pro_val;

        $spec->save();
        notify()->success('Specification has been Updated !');
        return back();
    }

    public function bulk_delete(Request $request)
    {
    

        $validator = Validator::make($request->all(), ['action' => 'required', 'checked' => 'required']);

        if ($validator->fails()) {


            $errors = $validator->errors();
            
            if($errors->first('action')){
                notify()->error('Please select action from action list !');
            }
            
            if($errors->first('checked')){
                notify()->error('Atleast one item is required to be checked !');
            }

            return back();
            
        }

        $products = Product::whereIn('id',$request->checked)->get();

        if($request->action == 'deleted'){
            $products->each(function($product){
                $product->subvariants()->delete();
                $product->delete();
            });
        }

        if($request->action == 'deactivated'){
            $products->each(function($product){
                $product->status = '0';
                $product->save();
            });
        }

        if($request->action == 'activated'){
            
            $products->each(function($product){
                $product->status = '1';
                $product->save();
            });
        }


        notify()->success('Selected products has been '.$request->action);
        return back();
    }

    public function allreviews($id)
    {

        require_once 'price.php';

        $product = Product::find($id);

        $allreviews = UserReview::orderBy('id', 'DESC')->where('status', '=', '1')->where('pro_id', $id)->paginate(10);

        $reviewcount = UserReview::where('pro_id', $id)->where('status', "1")->WhereNotNull('review')->count();

        $mainproreviews = UserReview::orderBy('id', 'DESC')->where('status', '=', '1')->where('pro_id', $id)->get();
        $review_t = 0;
        $price_t = 0;
        $value_t = 0;
        $sub_total = 0;
        $count = count($mainproreviews);

        foreach ($mainproreviews as $review) {
            $review_t = $review->qty * 5;
            $price_t = $review->price * 5;
            $value_t = $review->value * 5;
            $sub_total = $sub_total + $review_t + $price_t + $value_t;
        }

        $count = ($count * 3) * 5;

        if (!isset($overallrating)) {
            $overallrating = 0;
            $ratings_var = 0;
        }

        if ($count != "") {
            $rat = $sub_total / $count;

            $ratings_var = ($rat * 100) / 5;

            $overallrating = ($ratings_var / 2) / 10;
        }

        $overallrating = round($overallrating, 1);

        $qualityprogress = 0;
        $quality = 0;
        $tq = 0;

        $priceprogress = 0;
        $price = 0;
        $tp = 0;

        $valueprogress = 0;
        $value = 0;
        $vp = 0;

        if (!empty($mainproreviews[0])) {

            $count = count($mainproreviews);

            foreach ($mainproreviews as $key => $r) {
                $quality = $tq + $r->qty * 5;
            }

            $countq = ($count * 1) * 5;
            $ratq = $quality / $countq;
            $qualityprogress = ($ratq * 100) / 5;

            foreach ($mainproreviews as $key => $r) {
                $price = $tp + $r->price * 5;
            }

            $countp = ($count * 1) * 5;
            $ratp = $price / $countp;
            $priceprogress = ($ratp * 100) / 5;

            foreach ($mainproreviews as $key => $r) {
                $value = $vp + $r->value * 5;
            }

            $countv = ($count * 1) * 5;
            $ratv = $value / $countv;
            $valueprogress = ($ratv * 100) / 5;

        }

        if (isset($product)) {
            return view('front.allreviews', compact('conversion_rate', 'product', 'ratings_var', 'allreviews', 'overallrating', 'mainproreviews', 'qualityprogress', 'priceprogress', 'valueprogress', 'reviewcount'));
        } else {
            notify()->error('404 | Product reviews not found !');
            return back();
        }

    }

    public function importPage()
    {
        return view('admindesk.product.importindex');
    }

    public function import(Request $request)
    {
        $validator = Validator::make(
            [
                'file' => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls,csv',
            ]

        );

        if ($validator->fails()) {
            return back()->withErrors('Invalid file !');
        }

        if (!$request->has('file')) {
            notify()->warning('Please choose a file !');
            return back();
        }

        $fileName = time() . '.' . $request->file->getClientOriginalExtension();

        if (!is_dir(public_path() . '/excel')) {
            mkdir(public_path() . '/excel');
        }

        $request->file->move(public_path('excel'), $fileName);

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);

        $productfile = (new FastExcel)->import(public_path() . '/excel/' . $fileName);
        $lang = Session::get('changed_language');

        if (count($productfile) > 0) {

            foreach ($productfile as $key => $line) {

                $rowno = $key + 1;
                $sellPrice = 0;
                $sellofferPrice = 0;
                $commissionRate = 0;

                $catname = $line['category_name'];

                $catid = Category::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$catname'")->first();

                if (!isset($catid)) {
                    $catid = new Category;
                    $catid->title = $line['category_name'];
                    $catid->status = '1';
                    $catid->featured = '1';
                    $catid->position = (Category::count() + 1);
                    $catid->save();
                }

                $subcatname = $line['subcategory_name'];
                $subcatid = Subcategory::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$subcatname'")->first();

                if (!isset($subcatid)) {

                    $subcatid = new Subcategory;
                    $subcatid->title = $line['subcategory_name'];
                    $subcatid->status = '1';
                    $subcatid->position = (Subcategory::count() + 1);
                    $subcatid->featured = '0';
                    $subcatid->parent_cat = $catid->id;
                    $subcatid->save();
                }

                $brandnid = Brand::where('name', $line['brand_name'])->first();

                if (!isset($brandnid)) {

                    $brandnid = new Brand;
                    $brandnid->name = $line['brand_name'];
                    $brandnid->status = '1';
                    $brandnid->show_image = '1';
                    $brandnid->is_requested = '0';
                    $brandnid->save();

                }

                if ($line['store_name'] != '') {

                    $store = Store::where('name', $line['store_name'])->first();

                    if (!isset($store)) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error("Invalid Store name at Row no $rowno Store not found ! Please create it and than try to import this file again !");

                        return back();
                        break;
                    }
                }

                if ($line['return_available'] != '0') {

                    $p = admin_return_product::where('name', $line['return_policy'])->first();

                    if (!isset($p)) {

                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error("Invalid Return Policy name at Row no $rowno Return Policy not found ! Please create it and than try to import this file again !");

                        return back();
                        break;
                    }

                    $policy = $p->id;

                } else {

                    $policy = 0;

                }

                if ($line['tax'] != '0') {

                    $tc = TaxClass::where('title', $line['tax'])->first();

                    if (!isset($tc)) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error("Invalid TaxClass name at Row no $rowno TaxClass not found ! Please create it and than try to import this file again !");

                        return back();
                        break;
                    }

                    $taxClass = $tc->id;

                } else {

                    $taxClass = 0;

                }

                if ($line['free_shipping'] != '1') {

                    $freeShipping = 1;
                    $ship = Shipping::where('default_status', '1')->first();

                    if (!isset($ship)) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error("Invalid Shipping name at Row no $rowno Childcategory not found ! Please create it and than try to import this file again !");

                        return back();
                        break;
                    }

                    $shippingID = $ship->id;

                } else {

                    $freeShipping = 0;
                    $shippingID = null;

                }

                if ($line['childcategory'] != '') {
                    $childcatname = $line['childcategory'];
                    $c = Grandcategory::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$childcatname'")->first();

                    if (!isset($c)) {

                        $child = new Grandcategory;
                        $child->title = $line['childcategory'];
                        $child->status = '1';
                        $child->position = (Grandcategory::count() + 1);
                        $child->featured = '0';
                        $child->parent_id = $catid->id;
                        $child->subcat_id = $subcatid->id;
                        $child->save();

                        $childid = $child->id;

                    } else {
                        $childid = $c->id;
                    }

                } else {
                    $childid = '0';
                }

                /*Commission Price*/
                $sellofferPrice = 0;
                $commissions = CommissionSetting::all();
                foreach ($commissions as $commission) {
                    if ($commission->type == "flat") {
                        if ($commission->p_type == "f") {

                            if ($line['tax_rate'] != '') {

                                $cit = $commission->rate * $line['tax_rate'] / 100;
                                $price = $line['price'] + $commission->rate + $cit;

                                if ($line['offer_price'] != '' && $line['offer_price'] != '0') {
                                    $offer = $line['offer_price'] + $commission->rate + $cit;
                                }

                            } else {
                                $price = $line['price'] + $commission->rate;

                                if ($line['offer_price'] != '' && $line['offer_price'] != '0') {
                                    $offer = $line['offer_price'] + $commission->rate;
                                }

                            }

                            $sellPrice = $price;
                            $sellofferPrice = $offer;
                            $commissionRate = $commission->rate;

                        } else {

                            $taxrate = $commission->rate;
                            $price1 = $line['price'];

                            if ($line['offer_price'] != '') {
                                $price2 = $line['offer_price'];
                                $tax2 = ($price2 * (($taxrate / 100)));
                                $sellofferPrice = $price2 + $tax2;
                            }

                            $tax1 = ($price1 * (($taxrate / 100)));

                            $sellPrice = $price1 + $tax1;

                            if ($line['offer_price'] != '' && $line['offer_price'] != '0') {
                                $commissionRate = $tax2;
                            } else {
                                $commissionRate = $tax1;
                            }

                        }
                    } else {

                        $comm = Commission::where('category_id', $catid)->first();

                        if (isset($comm)) {
                            if ($comm->type == 'f') {

                                if ($line['tax_rate'] != '') {

                                    $cit = $comm->rate * $line['tax_rate'] / 100;
                                    $price = $line['price'] + $comm->rate + $cit;

                                    if ($line['offer_price'] != '' && $line['offer_price'] != '0') {
                                        $offer = $line['offer_price'] + $comm->rate + $cit;
                                    }

                                } else {

                                    $price = $line['price'] + $comm->rate;

                                    if ($line['offer_price'] != '' && $line['offer_price'] != '0') {
                                        $offer = $line['offer_price'] + $comm->rate;
                                    }

                                }

                                $sellPrice = $price;
                                $sellofferPrice = $offer;
                                $commissionRate = $comm->rate;

                            } else {
                                $taxrate = $comm->rate;
                                $price1 = $line['price'];
                                $price2 = $line['offer_price'];
                                $tax1 = ($price1 * (($taxrate / 100)));
                                $tax2 = ($price2 * (($taxrate / 100)));
                                $price = $line['price'] + $tax1;
                                $offer = $line['offer_price'] + $tax2;
                                $sellPrice = $price;
                                $sellofferPrice = $offer;

                                if ($line['offer_price'] != '') {
                                    $commissionRate = $tax2;
                                } else {
                                    $commissionRate = $tax1;
                                }
                            }
                        } else {
                            $commissionRate = 0;
                            $sellPrice = $line['price'] + $commissionRate;

                            if ($line['offer_price'] != '' && $line['offer_price'] != '0') {
                                $sellofferPrice = $line['offer_price'] + $commissionRate;
                            }
                        }
                    }

                }
                /**/

                //convert for enum value
                if ($line['featured'] == 0) {
                    $featured = '0';
                } else {
                    $featured = '1';
                }

                if ($line['status'] == 0) {
                    $pstatus = '0';
                } else {
                    $pstatus = '1';
                }
                /**/

                $product = Product::create([

                    'category_id' => $catid->id,
                    'child' => $subcatid->id,
                    'grand_id' => $childid,
                    'store_id' => $store->id,
                    'vender_id' => $store->user->id,
                    'brand_id' => $brandnid->id,
                    'name' => $line['product_name'],
                    'des' => clean($line['product_description']),
                    'tags' => $line['tags'],
                    'model' => $line['model_no'],
                    'sku' => $line['sku'],
                    'price_in' => $line['price_in'],
                    'price' => $sellPrice,
                    'offer_price' => $sellofferPrice,
                    'featured' => $featured,
                    'status' => $pstatus,
                    'vender_price' => $line['price'],
                    'vender_offer_price' => $line['offer_price'],
                    'tax' => $taxClass,
                    'codcheck' => $line['cash_on_delivery'],
                    'free_shipping' => $freeShipping,
                    'selling_start_at' => $line['selling_start_at'],
                    'return_avbl' => $line['return_available'],
                    'cancel_avl' => $line['cancel_available'],
                    'w_d' => $line['warranty_in_days'],
                    'w_my' => $line['warranty_in_monthsyears'],
                    'w_type' => $line['warranty_type'],
                    'commission_rate' => $commissionRate,
                    'shipping_id' => $shippingID,
                    'return_policy' => $policy,
                    'tax_r' => $line['tax_rate'],
                    'tax_name' => $line['tax_name'],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),

                ]);

                $relsetting = new Related_setting;
                $relsetting->pro_id = $product->id;
                $relsetting->status = '0';
                $relsetting->save();

            }

            notify()->success('Products Imported Successfully !', $productfile->count() . ' Imported !');
            $file = @file_get_contents(public_path() . '/excel/' . $fileName);

            if ($file) {
                unlink(public_path() . '/excel/' . $fileName);
            }

            return back();

        } else {
            notify()->warning('Your excel file is empty !');
            $file = @file_get_contents(public_path() . '/excel/' . $fileName);

            if ($file) {
                unlink(public_path() . '/excel/' . $fileName);
            }
            return back();
        }

    }

    public function index(Request $request)
    {

        $products = Product::with(['category' => function ($q) {

            return $q->where('status', '=', '1')->select('id', 'title');

        }, 'subcategory' => function ($q) {

            return $q->where('status', '1')->select('id', 'title');

        }, 'childcat' => function ($q) {

            return $q->where('status', '=', '1')->select('id', 'title');

        }, 'subvariants' => function ($q) {

            return $q->where('def', '=', '1');

        }, 'subvariants.variantimages' => function ($q) {

            return $q->select('var_id', 'main_image');

        }, 'brand' => function ($q) {

            return $q->select('id', 'name');

        }])->with(['vender' =>  function ($q) {

            return $q->select('id', 'name');

        }])->whereHas('vender', function ($query) {

            return $query->where('status', '=', '1')->where('is_verified', '1');

        })->with(['store' =>  function ($q) {

            $q->select('id', 'name','status');

        }])->whereHas('store')->get();

        if ($request->ajax()) {

            return DataTables::of($products)
                ->editColumn('checkbox', function ($row) {

                    $chk = "<div class='inline'>
                          <input type='checkbox' form='bulk_delete_form' class='filled-in material-checkbox-input' name='checked[]'' value='$row->id' id='checkbox$row->id'>
                          <label for='checkbox$row->id' class='material-checkbox'></label>
                        </div>";

                    return $chk;
                })
                ->addIndexColumn()
                ->addColumn('image', function ($row) {

                    $image = '';

                    if (isset($row->subvariants[0]) && $row->subvariants[0]->variantimages && file_exists(public_path().'/variantimages/thumbnails/'.$row->subvariants[0]->variantimages->main_image)) {

                        $image .= "<img title='" . str_replace('"', '', $row->name) . "' class='pro-img' src='" . url('variantimages/thumbnails/' . $row->subvariants[0]->variantimages->main_image) . "' alt='" . $row->name . "'>";

                    } else {

                        $image = '<img title="Make a variant first !" src="' . Avatar::create($row->name)->toBase64() . '"/>';

                    }

                    return $image;
                })
                ->addColumn('name', function ($row) {

                    $html = '';

                    if ($row->name != null) {
                        $html .= '<p><b>' . $row->name . '</b></p>';
                    } else {
                        $html .= '<p><b>Product translation not updated in this language </b></p>';
                    }

                    $html .= '<p><b>Store:</b> ' . $row->store->name ?? "Not Store set" . ' </p>';
                    $html .= '<p><b>Brand:</b> ' . $row->brand->name ?? "Not Brand Set" . ' </p>';

                    return $html;
                })
                ->editColumn('price', 'admindesk.product.dtablecolumn.price')
                ->addColumn('catdtl', function ($row) {
                    $catdtl = '';

                    if ($row->category != null) {
                        $catdtl .= '<p><i class="fa fa-angle-double-right"></i> ' . $row->category->title . '</p>';
                    } else {
                        $catdtl .= '<p>Category not set</p>';
                    }

                    if ($row->subcategory != null) {
                        $catdtl .= '<p class="font-weight600"><i class="fa fa-angle-double-right"></i> ' . $row->subcategory->title . '</p>';
                    } else {
                        $catdtl .= "<p>Subcategory not set</p>";
                    }

                    if ($row->childcat != null) {
                        $catdtl .= '<p class="font-weight600"><i class="fa fa-angle-double-right"></i> ' . $row->childcat->title . '</p>';
                    } else {
                        $catdtl .= "<p>Child category not set</p>";
                    }

                    return $catdtl;
                })
                ->editColumn('featured', 'admindesk.product.dtablecolumn.featured')
                ->editColumn('status', 'admindesk.product.dtablecolumn.status')
                ->addColumn('created_at', 'admindesk.product.dtablecolumn.history')
                ->editColumn('action', 'admindesk.product.dtablecolumn.action')
                ->rawColumns(['checkbox', 'image', 'name', 'price', 'catdtl', 'featured', 'status', 'created_at', 'action'])
                ->make(true);
        }

        return view("admindesk.product.index");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function upload_info(Request $request)
    {

        $id = $request['catId'];

        $category = Category::find($id);

        if (isset($category)) {

            $upload = $category->subcategory->pluck('title', 'id')->all();

        }

        return response()->json($upload);
    }

    public function gcato(Request $request)
    {

        $id = $request['catId'];

        $category = Subcategory::findOrFail($id);

        $upload = $category
            ->childcategory
            ->where('subcat_id', $category->id)
            ->pluck('title', 'id')
            ->all();

        return response()
            ->json($upload);
    }

    public function create()
    {
        $categorys = Category::all();
        $brands_products = Brand::where('status', '=', '1')->get();

        $stores = \DB::table('stores')->join('users', 'stores.user_id', '=', 'users.id')->select('stores.name as storename', 'users.name as owner', 'stores.id as storeid')->get();

        $product = Product::all();
        return view("admindesk.product.create", compact("categorys", "stores", "brands_products", "product"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate($request, ["name" => "required", "price" => "required", 'brand_id' => 'required|not_in:0', 'category_id' => 'required|not_in:0', 'child' => 'required|not_in:0',

        ], [

            "name.required" => "Product Name is needed", "price.required" => "Price is needed", "brand_id.required" => "Please Choose Brand",

        ]);

        $input = $request->all();
        $currency_code = Genral::first()->currency_code;

        if (isset($request->codcheck)) {
            $input['codcheck'] = "1";
        } else {
            $input['codcheck'] = "0";
        }

        if (isset($request->featured)) {
            $input['featured'] = "1";
        } else {
            $input['featured'] = "0";
        }

        if (isset($request->tax_manual)) {

            $request->validate(['tax_r' => 'required|numeric', 'tax_name' => 'string|required|min:1']);

            $input['tax'] = 0;

        } else {

            $input['tax_r'] = null;
            $input['tax_name'] = null;

        }

        if (isset($request->free_shipping)) {

            $input['free_shipping'] = "1";
        } else {

            $sid = Shipping::where('default_status', "1")->first();
            $input['shipping_id'] = $sid->id;
            $input['free_shipping'] = "0";
        }

        $input['price_in'] = $currency_code;

        if ($request->vender_price == '') {
            $input['vender_price'] = $request->price;
            $input['vender_offer_price'] = $request->offer_price;
        }

        if (!is_dir(public_path() . '/images/videothumbnails')) {
            mkdir(public_path() . '/images/videothumbnails');
        }

        if ($request->video_thumbnail) {

            $request->validate([
                'video_thumbnail' => 'mimes:jpeg,jpg,png,webp,gif|max:512',
            ]);

            $image = $request->file('video_thumbnail');
            $input['video_thumbnail'] = 'video_thumbnail_' . uniqid() . '.webp';
            $destinationPath = public_path('/images/videothumbnails');
            $img = Image::make($image->path());

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->insert(public_path('images/play-icon.png'), 'center', 10, 10);

            $img->save($destinationPath . '/' . $input['video_thumbnail']);

        }

        if ($request->catlog) {

            $validator = Validator::make(
                [
                    'file' => $request->catlog,
                    'extension' => strtolower($request->catlog->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required|max:1024',
                    'extension' => 'required|in:pdf,doc,docx,ppt,txt',
                ]

            );

            if ($validator->fails()) {
                return back()->withErrors('Invalid file for product catlog !');
            }

            if (!is_dir(public_path() . '/productcatlog')) {
                mkdir(public_path() . '/productcatlog');
            }

            $input['catlog'] = time() . '_catlog.' . $request->catlog->getClientOriginalExtension();

            $request->catlog->move(public_path('productcatlog'), $input['catlog']);

        }

        $input['video_preview'] = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $request->video_preview);

        $commissions = CommissionSetting::all();
        foreach ($commissions as $commission) {
            if ($commission->type == "flat") {
                if ($commission->p_type == "f") {

                    if (!isset($request->tax_r)) {

                        $price = $input['price'] + $commission->rate;
                        $offer = $input['offer_price'] + $commission->rate;

                        $input['price'] = $price;
                        $input['offer_price'] = $offer;
                        $input['commission_rate'] = $commission->rate;

                    } else {

                        $cit = $commission->rate * $input['tax_r'] / 100;
                        $price = $input['price'] + $commission->rate + $cit;
                        $offer = $input['offer_price'] + $commission->rate + $cit;

                        $input['price'] = $price;
                        $input['offer_price'] = $offer;
                        $input['commission_rate'] = $commission->rate + $cit;
                    }

                } else {

                    $taxrate = $commission->rate;
                    $price1 = $input['price'];
                    $price2 = $input['offer_price'];
                    $tax1 = $price1 * (($taxrate / 100));
                    $tax2 = $price2 * (($taxrate / 100));
                    $price = $input['price'] + $tax1;
                    $offer = $input['offer_price'] + $tax2;
                    $input['price'] = $price;
                    $input['offer_price'] = $offer;
                    if (!empty($tax2)) {
                        $input['commission_rate'] = $tax2;
                    } else {
                        $input['commission_rate'] = $tax1;
                    }
                }
            } else {

                $comm = Commission::where('category_id', $request->category_id)
                    ->first();
                if (isset($comm)) {
                    if ($comm->type == 'f') {

                        if (!isset($request->tax_manual)) {

                            $price = $input['price'] + $comm->rate;
                            $offer = $input['offer_price'] + $comm->rate;
                            $input['price'] = $price;
                            $input['offer_price'] = $offer;
                            $input['commission_rate'] = $comm->rate;

                        } else {

                            $cit = $commission->rate * $input['tax_r'] / 100;
                            $price = $input['price'] + $comm->rate + $cit;
                            $offer = $input['offer_price'] + $comm->rate + $cit;
                            $input['price'] = $price;
                            $input['offer_price'] = $offer;
                            $input['commission_rate'] = $comm->rate + $cit;
                        }

                    } else {
                        $taxrate = $comm->rate;
                        $price1 = $input['price'];
                        $price2 = $input['offer_price'];
                        $tax1 = $price1 * (($taxrate / 100));
                        $tax2 = $price2 * (($taxrate / 100));
                        $price = $input['price'] + $tax1;
                        $offer = $input['offer_price'] + $tax2;
                        $input['price'] = $price;
                        $input['offer_price'] = $offer;

                        if (!empty($tax2)) {
                            $input['commission_rate'] = $tax2;
                        } else {
                            $input['commission_rate'] = $tax1;
                        }
                    }
                }
            }

        }

        if ($request->return_avbls == "1") {

            $request->validate(['return_avbls' => 'required', 'return_policy' => 'required'], ['return_policy.required' => 'Please choose return policy']);

            if ($request->return_policy === "Please choose an option") {
                notify()->warning('Please choose a return policy !');
                return back();
            }

        }

        if ($request->return_avbls == "1") {

            $input['return_avbl'] = "1";
            $input['return_policy'] = $request->return_policy;
        } else {

            $input['return_avbl'] = 0;
            $input['return_policy'] = 0;
        }

        $input['status'] = isset($request->status) ? 1 : 0;

        $input['vender_id'] = auth()->id();
        $findstore = Store::find($request->store_id);
        $input['w_d'] = $request->w_d;
        $input['w_my'] = $request->w_my;
        $input['w_type'] = $request->w_type;
        $input['key_features'] = clean($request->key_features);
        $input['des'] = clean($request->des);
        $input['grand_id'] = isset($request->grand_id) ? $request->grand_id : 0;
        $input['vender_id'] = $findstore->user->id;
        $data = Product::create($input);

        $data->save();

        $relsetting = new Related_setting;

        $relsetting->pro_id = $data->id;
        $relsetting->status = '0';
        $relsetting->save();
        notify()->success('Product created !', $data->name);
        return redirect()->route('products.index');

    }

    public function addSale(Request $request)
    {
        $salePrice = $request->salePrice;
        $pro_id = $request->pro_id;
        DB::table('products')
            ->where('id', $pro_id)->update(['offer_price' => $salePrice]);
        return "Added success";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        session()->put('faqproduct', ['id' => $id]);
        $brands_products = Brand::all();
        $products = Product::find($id);
        $categorys = Category::all();

        $stores = \DB::table('stores')->join('users', 'stores.user_id', '=', 'users.id')->select('stores.name as storename', 'users.name as owner', 'stores.id as storeid')->get();

        $faqs = FaqProduct::where('pro_id', $id)->get();
        $cat_id = Product::where('id', $id)->first();
        $child = Subcategory::where('parent_cat', $cat_id->category_id)
            ->get();
        $realateds = RealatedProduct::get();
        $rel_setting = $products->relsetting;
        $grand = Grandcategory::where('subcat_id', $cat_id->child)
            ->get();

        return view("admindesk.product.edit_tab", compact('rel_setting', "products", "categorys", "stores", "brands_products", "faqs", "child", "grand", "realateds"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product = Product::find($id);

        if (!$product) {
            notify()->error('404 | No Product found !');
            return redirect(route('products.index'));
        }

        $currency_code = Genral::first()->currency_code;
        $data = $this->validate($request, ["name" => "required", "price" => "required|numeric", "brand_id.required" => "Please Choose Brand",

        ], [

            "name.required" => "Product Name is needed", "price.required" => "Price is needed",

        ]);

        $input = $request->all();

        if (isset($request->codcheck)) {
            $input['codcheck'] = "1";
        } else {
            $input['codcheck'] = "0";
        }

        if (isset($request->featured)) {
            $input['featured'] = "1";
        } else {
            $input['featured'] = "0";
        }

        if (isset($request->tax_manual)) {

            $request->validate(['tax_r' => 'required|numeric', 'tax_name' => 'string|required|min:1']);

            $input['tax'] = 0;

        } else {

            $input['tax_r'] = null;
            $input['tax_name'] = null;
            $input['tax'] = $request->tax;
        }

        $input['vender_price'] = $request->price;
        $input['vender_offer_price'] = $request->offer_price;

        if (!is_dir(public_path() . '/images/videothumbnails')) {
            mkdir(public_path() . '/images/videothumbnails');
        }

        if ($request->video_thumbnail) {

            $request->validate([
                'video_thumbnail' => 'mimes:jpeg,jpg,png,webp,gif|max:512',
            ]);

            $image = $request->file('video_thumbnail');
            $input['video_thumbnail'] = 'video_thumbnail_' . uniqid() . '.webp';
            $destinationPath = public_path('/images/videothumbnails');
            $img = Image::make($image->path());

            if ($product->video_thumbnail != '' && file_exists(public_path() . '/images/videothumbnails/' . $product->video_thumbnail)) {
                unlink(public_path() . '/images/videothumbnails/' . $product->video_thumbnail);
            }

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->insert(public_path('images/play-icon.png'), 'center', 10, 10);

            $img->save($destinationPath . '/' . $input['video_thumbnail']);

        }

        if ($request->catlog) {

            $validator = Validator::make(
                [
                    'file' => $request->catlog,
                    'extension' => strtolower($request->catlog->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required|max:1024',
                    'extension' => 'required|in:pdf,doc,docx,ppt,txt',
                ]

            );

            if ($validator->fails()) {
                return back()->withErrors('Invalid file for product catlog !');
            }

            if (!is_dir(public_path() . '/productcatlog')) {
                mkdir(public_path() . '/productcatlog');
            }

            if ($product->catlog != '' && file_exists(public_path() . '/productcatlog/' . $product->catlog)) {
                unlink(public_path() . '/productcatlog/' . $product->catlog);
            }

            $input['catlog'] = time() . '_catlog.' . $request->catlog->getClientOriginalExtension();

            $request->catlog->move(public_path('productcatlog'), $input['catlog']);

        }

        $input['video_preview'] = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "https://youtube.com/embed/$1", $request->video_preview);

        $commissions = CommissionSetting::all();
        foreach ($commissions as $commission) {
            if ($commission->type == "flat") {
                if ($commission->p_type == "f") {

                    if (!isset($request->tax_r)) {

                        $price = $input['price'] + $commission->rate;
                        $offer = $input['offer_price'] + $commission->rate;

                        $input['price'] = $price;
                        $input['offer_price'] = $offer;
                        $input['commission_rate'] = $commission->rate;

                    } else {

                        $cit = $commission->rate * $input['tax_r'] / 100;
                        $price = $input['price'] + $commission->rate + $cit;
                        $offer = $input['offer_price'] + $commission->rate + $cit;

                        $input['price'] = $price;
                        $input['offer_price'] = $offer;
                        $input['commission_rate'] = $commission->rate + $cit;
                    }

                } else {

                    $taxrate = $commission->rate;
                    $price1 = $input['price'];
                    $price2 = $input['offer_price'];
                    $tax1 = ($price1 * (($taxrate / 100)));
                    $tax2 = ($price2 * (($taxrate / 100)));
                    $price = $input['price'] + $tax1;
                    $offer = $input['offer_price'] + $tax2;
                    $input['price'] = $price;
                    $input['offer_price'] = $offer;
                    if (!empty($tax2)) {
                        $input['commission_rate'] = $tax2;
                    } else {
                        $input['commission_rate'] = $tax1;
                    }
                }
            } else {

                $comm = Commission::where('category_id', $request->category_id)
                    ->first();
                if (isset($comm)) {
                    if ($comm->type == 'f') {

                        if (!isset($request->tax_manual)) {

                            $price = $input['price'] + $comm->rate;
                            $offer = $input['offer_price'] + $comm->rate;
                            $input['price'] = $price;
                            $input['offer_price'] = $offer;
                            $input['commission_rate'] = $comm->rate;

                        } else {

                            $cit = $commission->rate * $input['tax_r'] / 100;
                            $price = $input['price'] + $comm->rate + $cit;

                            if ($request->offer_price) {
                                $offer = $input['offer_price'] + $comm->rate + $cit;
                                $input['offer_price'] = $offer;
                            } else {
                                $input['offer_price'] = null;
                            }

                            $input['price'] = $price;

                            $input['commission_rate'] = $comm->rate + $cit;
                        }

                    } else {

                        $taxrate = $comm->rate;
                        $price1 = $input['price'];
                        $price2 = $input['offer_price'];
                        $tax1 = ($price1 * (($taxrate / 100)));
                        $tax2 = ($price2 * (($taxrate / 100)));
                        $price = $input['price'] + $tax1;
                        $offer = $input['offer_price'] + $tax2;
                        $input['price'] = $price;
                        $input['offer_price'] = $offer;

                        if (!empty($tax2)) {
                            $input['commission_rate'] = $tax2;
                        } else {
                            $input['commission_rate'] = $tax1;
                        }
                    }
                }
            }

        }

        if ($request->return_avbls == "1") {

            $request->validate(['return_avbls' => 'required', 'return_policy' => 'required'], ['return_policy.required' => 'Please choose return policy']);

            if ($request->return_policy === "Please choose an option") {

                return back()->withErrors('Please choose a return policy !')->withInput();

            }

        }

        if ($request->return_avbls == "1") {

            $input['return_avbl'] = "1";
            $input['return_policy'] = $request->return_policy;
        } else {

            $input['return_avbl'] = 0;
            $input['return_policy'] = 0;
        }

        if (isset($request->free_shipping)) {

            $input['free_shipping'] = "1";
            $input['shipping_id'] = null;

        } else {

            $sid = Shipping::where('default_status', "1")->first();
            $input['shipping_id'] = $sid->id;
            $input['free_shipping'] = '0';
        }

        $findstore = Store::find($request->store_id);

        $input['price_in'] = $currency_code;
        $input['w_d'] = $request->w_d;
        $input['w_my'] = $request->w_my;
        $input['w_type'] = $request->w_type;
        $input['key_features'] = clean($request->key_features);
        $input['des'] = clean($request->des);
        $input['grand_id'] = isset($request->grand_id) ? $request->grand_id : 0;
        $input['vender_id'] = $findstore->user->id;
        $product->update($input);

        /** Fire a job to handle cart price change if product price change */

        $cart = Cart::with('product')->whereHas('product')->with('variant')->whereHas('variant')->where('pro_id',$product->id)->get();


        CartPriceChange::dispatch($cart);

        notify()->success('Product has been updated !', $product->name);
        return back();

    }

    public function destroy($id)
    {

        $pro = Product::find($id);

        if (!$pro) {
            notify()->error('404 | Product not found !');
            return back();
        }

        $provar = AddProductVariant::where('pro_id', $pro->id)->first();

        $subvar = AddSubVariant::where('pro_id', $pro->id)->get();

        DB::table('add_sub_variants')->where('pro_id', $pro->id)->delete();

        $pro->reviews()->delete();

        if (isset($subvar)) {

            foreach ($subvar as $s) {

                if ($s->variantimages['image1'] != null && file_exists(public_path() . '/variantimages/' . $s->variantimages['image1'])) {
                    unlink('../public/variantimages/' . $s->variantimages['image1']);
                }

                if ($s->variantimages['image2'] != null && file_exists(public_path() . '/variantimages/' . $s->variantimages['image2'])) {
                    unlink('../public/variantimages/' . $s->variantimages['image2']);
                }

                if ($s->variantimages['image3'] != null && file_exists(public_path() . '/variantimages/' . $s->variantimages['image3'])) {
                    unlink('../public/variantimages/' . $s->variantimages['image3']);
                }

                if ($s->variantimages['image4'] != null && file_exists(public_path() . '/variantimages/' . $s->variantimages['image4'])) {
                    unlink('../public/variantimages/' . $s->variantimages['image3']);
                }

                if ($s->variantimages['image5'] != null && file_exists(public_path() . '/variantimages/' . $s->variantimages['image5'])) {
                    unlink('../public/variantimages/' . $s->variantimages['image5']);
                }

                if ($s->variantimages['image6'] != null && file_exists(public_path() . '/variantimages/' . $s->variantimages['image6'])) {
                    unlink('../public/variantimages/' . $s->variantimages['image6']);
                }

                DB::table('variant_images')
                    ->where('var_id', $s->id)
                    ->delete();

            }

        }

        if (isset($provar)) {
            $pro->subvariants()->delete();
        }

        $pro->delete();
        notify()->error('Product has been deleted !');
        return back();
    }

    public function prorelsetting(Request $request, $id)
    {
        $relsetting = Related_setting::where('pro_id', $id)->first();

        if (!isset($relsetting)) {

            $relsetting = new Related_setting();
            $relsetting->pro_id = $id;
            $relsetting->status = $request->status;
            $relsetting->save();

            return 'success';

        } else {

            $relsetting->status = $request->status;

            $relsetting->save();

            return 'success';

        }

    }

    public function relatedProductStore(Request $request, $id)
    {
        $input = $request->all();
        $data = RealatedProduct::where('product_id', '=', $id)->first();

        $request->validate(['related_pro' => 'required'], ['related_pro.required' => 'Please select a product !']);

        if (!isset($data)) {
            $newR = new RealatedProduct();
            $input['product_id'] = $id;
            $newR->create($input);
            notify()->success('Related products added !');
            return back();

        } else {
            $input['product_id'] = $id;
            $data->update($input);
            notify()->success('Related products updated !');
            return back();

        }
    }

    public function download(Request $request, $filename)
    {

        if (env('DEMO_LOCK') == 1) {
            notify()->error("This action is disabled in demo !");
            return back();
        }

        if (!$request->hasValidSignature()) {
            notify()->error('Download Link is invalid or expired !');
            return back();
        }

        $filePath = public_path() . '/productcatlog/' . $filename;

        $fileContent = file_get_contents($filePath);

        $response = response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);

        return $response;

    }

}
