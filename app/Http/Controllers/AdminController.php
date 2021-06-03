<?php
namespace App\Http\Controllers;

use App\CanceledOrders;
use App\Category;
use App\Charts\AdminUserChart;
use App\Charts\AdminUserPieChart;
use App\Charts\OrderChart;
use App\Coupan;
use App\DashboardSetting;
use App\Faq;
use App\FullOrderCancelLog;
use App\Genral;
use App\Hotdeal;
use App\Invoice;
use App\Order;
use App\PendingPayout;
use App\Product;
use App\SellerPayout;
use App\SpecialOffer;
use App\Store;
use App\Testimonial;
use App\User;
use App\VisitorChart;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDF;


class AdminController extends Controller
{

    public function user_read()
    {
        auth()->user()
            ->unreadNotifications
            ->where('n_type', '=', 'user')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function order_read()
    {
        auth()
            ->user()
            ->unreadNotifications
            ->where('n_type', '=', 'order_v')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function ticket_read()
    {
        auth()
            ->user()
            ->unreadNotifications
            ->where('n_type', '=', 'ticket')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function all_read()
    {
        auth()
            ->user()
            ->unreadNotifications
            ->where('n_type', '!=', 'order_v')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function index()
    {
        $lang = Session::get('changed_language');

        $totalproducts = Product::whereHas('category')->whereHas('subvariants')->whereHas('subcategory')->whereHas('brand')->whereHas('store')->whereHas('vender')->count();

        $order = Order::with(['user','invoices'])->whereHas('invoices')->whereHas('user')->where('status', '=', '1')->count();

        $usersquery = User::query();

        $user = $usersquery->count();

        $store = Store::count();

        $coupan = Coupan::count();

        $faqs = Faq::count();

        $category = Category::count();

        $cancelorder = CanceledOrders::whereHas('user')->whereHas('order')->whereHas('singleOrder')->count();

        $fcanorder = FullOrderCancelLog::whereHas('user')->whereHas('getorderinfo')->count();

        $totalcancelorder = $fcanorder + $cancelorder;

        $total_testinonials = Testimonial::where('status', '=', '1')->count();


        $total_hotdeals = Hotdeal::whereHas('pro',function($query){
            return $query->where('status','1');
        })->where('status', '=', '1')->count();

        $total_specialoffer = SpecialOffer::whereHas('pro',function($query){
            return $query->where('status','1');
        })->where('status', '=', '1')->count();

        
        $inv_cus = Invoice::first();
        $setting = Genral::first();
        $totalsellers = $usersquery->where('role_id', '=', 'v')->where('status', '=', '1')->count();
        $dashsetting = DashboardSetting::first();

        $products = Product::whereHas('category')->whereHas('subvariants')->whereHas('subcategory')->whereHas('brand')->whereHas('store')->whereHas('vender')->latest()->take($dashsetting->max_item_pro)->get();

        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)",
        ];

        /*Creating Userbarchart*/

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $userdata = collect();

        $users = User::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'))->where('status','1')
        ->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get()
        ->map(function($item) use($months,$userdata) {
              
          
            if(in_array($item->month,$months)){
                $userdata->push($item->count);
            }else{
                $userdata->push(0);
            }
            

            return $item;

        });
       

        $userchart = new AdminUserChart;

        $userchart->labels($months);

        $userchart->title('Monthly Registered Users in ' . date('Y'))->dataset('Monthly Registered Users', 'bar', $userdata)->options([
            'fill' => 'true',
            'shadow' => 'true',
            'borderWidth' => '1',
        ])->backgroundColor($fillColors)->color($fillColors);

        /*END*/

        /*Creating order chart*/

        $orderdata = collect();

        $totalorder = Order::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'))->where('status','1')
                      ->whereYear('created_at',date('Y'))
                      ->groupBy(DB::raw("MONTH(created_at)"))
                      ->groupBy(DB::raw("YEAR(created_at)"))
                      ->get()
                      ->map(function($item) use($months,$orderdata) {
                            
                            foreach($months as $month){
                                if($month == $item->month){
                                    $orderdata->push($item->count);
                                }else{
                                    $orderdata->push(0);
                                }
                            }

                            return $item;

                      });

       
        $orderchart = new OrderChart;

        $orderchart->labels($months);

        $orderchart->title('Total Orders in ' . date('Y'))->label('Sales')->dataset('Total Sale', 'area', $orderdata)->options([
            'fill' => 'true',
            'fillColor' => 'rgba(77, 150, 218, 0.8)',
            'color' => '#4d96da',
            'shadow' => true,
        ]);

        /*END*/

        /*Creating Piechart of user */

        $fillColors2 = ['#ff3300', '#7158e2', '#3ae374'];

        $admins = User::where('role_id', '=', 'a')->count();
        $sellers = User::where('role_id', '=', 'v')->count();
        $customers = User::where('role_id', '=', 'u')->count();

        $piechart = new AdminUserPieChart;

        $piechart->labels(['Admin', 'Seller', 'Customers']);

        $piechart->minimalist(true);

        $data = [$admins, $sellers, $customers];

        $piechart->title('User Distribution')->dataset('User Distribution', 'pie', $data)->options([
            'fill' => 'true',
            'shadow' => true,
        ])->color($fillColors2);

        /*End Piechart for user*/


        if ($setting->vendor_enable == 1) {

         $pendingPayout = SellerPayout::join('invoice_downloads','sellerpayouts.orderid','=','invoice_downloads.id')->join('orders','orders.id','=','invoice_downloads.order_id')->join('users','users.id','=','invoice_downloads.vender_id')->join('stores','stores.user_id','=','users.id')->select('users.name as sellername','stores.name as storename','sellerpayouts.*','orders.order_id as orderid','invoice_downloads.inv_no as invid')->get();

         $pendingPayout = SellerPayout::with(['singleorder','vender'])
                          ->whereHas('singleorder')
                          ->whereHas('vender', function($query){

                            return $query->where('status','1');

                           })->whereHas('singleorder.order')->whereHas('vender.store',function($q){
                            
                            return $q->where('apply_vender','!=','0')->where('status','!=','0');

                           })->get();

        $filterpayout = $pendingPayout->map(function($q){

            if ($q->singleorder->variant->products->return_avbl == 1) {

                $days = $q->singleorder->variant->products->returnPolicy->days;
                $endOn = date("Y-m-d", strtotime("$q->updated_at +$days days"));
                $today = date('Y-m-d');

                if ($today >= $endOn) {
                    return $q;
                }


            }   

        });

        }else{
            $filterpayout = 0;
        }

        $latestorders = Order::whereHas('invoices')->whereHas('user')->with(['user' => function($q){
                return $q->select('id','name');
        }])->latest()->take($dashsetting->max_item_ord)->get();

        $storerequest = Store::with(['user' => function($q){
            return $q->select('id','name as owner','email as useremail');
        }])->whereHas('user',function($q){
            return $q->where('status','1');
        })->where('stores.apply_vender', '=', '0')->select('stores.email as email', 'stores.name as name')->take($dashsetting->max_item_str)->get();

        $registerTodayUsers = User::whereDate('created_at',date('Y-m-d'))->count();

        return view("admindesk.dashbord.index", compact('total_hotdeals', 'total_specialoffer', 'total_testinonials', 'totalsellers', 'latestorders', 'filterpayout', 'products', 'order', 'user', 'store', 'coupan', 'category', 'totalcancelorder', 'faqs', 'inv_cus', 'userchart', 'piechart', 'orderchart', 'storerequest','registerTodayUsers','totalproducts'));
    }

    public function user()
    {
        $users = User::all();

        return view("admindesk.user.show", compact("users"));
    }

    public function order_print($id)
    {
        $invpre = Invoice::first();
        $order = order::where('id', $id)->first();

        $pdf = PDF::loadView('admindesk.print.pdfView', compact('order', 'invpre'));

        return $pdf->setPaper('a4', 'landscape')
            ->download('invoice.pdf');
    }

    public function single(Request $request)
    {
        $a = isset($request['id1']) ? $request['id1'] : 'not yet';

        $userUnreadNotification = auth()->user()
            ->unreadNotifications
            ->where('id', $a)->first();

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return response()->json(['status' => 'success']);
        }

    }

    public function visitorData(Request $request)
    {

        if($request->ajax()){
            $data = VisitorChart::select(\DB::raw('SUM(visit_count) as count'), 'country_code')
            ->groupBy('country_code')
            ->get();

            $result = array();

            foreach ($data as $key => $value) {
                $result[$value->country_code] = $value->count;
            }

            return response()->json($result);
        }
       

    }

}
