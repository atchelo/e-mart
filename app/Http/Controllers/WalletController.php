<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddSubVariant;
use App\Cart;
use App\Config as AppConfig;
use App\Coupan;
use App\FailedTranscations;
use App\Genral;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderMail;
use App\Mail\WalletMail;
use App\multiCurrency;
use App\Notifications\OrderNotification;
use App\Notifications\SellerNotification;
use App\Notifications\SMSNotifcations;
use App\Notifications\UserOrderNotification;
use App\Order;
use App\OrderWalletLogs;
use App\User;
use App\UserWallet;
use App\UserWalletHistory;
use Auth;
use Braintree;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Str;
use Crypt;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Mail;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PaytmWallet;
use Razorpay\Api\Api;
use Redirect;
use Session;
use Twilosms;
use URL;
use Validator;

class WalletController extends Controller
{

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Developer: @nkit              =
=            Copyright (c) 2020            =
==========================================*/

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this
            ->_api_context
            ->setConfig($paypal_conf['settings']);

        $this->gateway = $this->brainConfig();
        $this->wallet = Genral::first();
        $this->defaultCurrency = multiCurrency::where('default_currency', '=', 1)->first()->currency_symbol;
    }

    public function adminWalletSettings(Request $request)
    {

        $activeuser = UserWallet::query();

        $wallettxn = UserWalletHistory::count();

        $overallwalletbalance = $activeuser->sum('balance');
        
        $walletorders = Order::where('status', '=', '1')->where('payment_method', '=', 'wallet')->count();
        $states = [
            'activeuser' => $activeuser->where('status', '=', '1')->count(),
            'totaluser' => $activeuser->count(),
            'wallettxn' => $wallettxn,
            'overallwalletbalance' => $overallwalletbalance,
            'walletorders' => $walletorders,
        ];

        $orderwalletlogs = OrderWalletLogs::all();

        if ($request->ajax()) {
            return DataTables::of($orderwalletlogs)

                ->addIndexColumn()
                ->editColumn('wallet_txn_id', function ($row) {
                    return '<b>' . $row->wallet_txn_id . '</b>';
                })
                ->editColumn('note', function ($row) {
                    return "<b>$row->note</b>";
                })
                ->editColumn('type', function ($row) {
                    if ($row->type == 'Credit') {
                        return '<p class="text-green"><b>' . $row->type . '</b></p>';
                    } else {
                        return '<p class="text-red"><b>' . $row->type . '</b></p>';
                    }
                })
                ->editColumn('amount', function ($row) {
                    if ($row->type == 'Credit') {
                        return "<p class='text-green'><b> + <i class='$this->defaultCurrency'></i> $row->amount </b></p>";
                    } else {
                        return "<p class='text-red'><b> - <i class='$this->defaultCurrency'></i> $row->amount </b></p>";
                    }
                })
                ->editColumn('balance', function ($row) {
                    return "<p class='text-info'><b><i class='$this->defaultCurrency'></i> $row->balance </b></p>";
                })
                ->addColumn('txndate', function ($row) {
                    return '<b>' . date('d/m/Y', strtotime($row->created_at)) . '</b>';
                })
                ->addColumn('txntime', function ($row) {
                    return '<b>' . date('h:i A', strtotime($row->created_at)) . '</b>';
                })
                ->rawColumns(['wallet_txn_id', 'note', 'type', 'amount', 'balance', 'txndate', 'txntime'])
                ->make(true);
        }

        return view('admindesk.wallet.setting', compact('states'))->withWallet($this->wallet->wallet_enable);
    }

    public function updateWalletSettings(Request $request)
    {

        $this->wallet->wallet_enable = $request->wallet_enable;

        $q = $this->wallet->save();

        if ($q) {
            return response()->json(['msg' => 'Wallet Settings Updated !', 'code' => 200]);
        } else {
            return response()->json(['msg' => 'Something Went Wrong !', 'code' => 400]);
        }
    }

    public function showWallet(Request $request)
    {

        require_once 'price.php';

        if (isset(Auth::user()->wallet)) {

            if (Auth::user()->wallet->status == 1) {
                if (isset(Auth::user()->wallet->wallethistory)) {
                    $currentPage = LengthAwarePaginator::resolveCurrentPage();

                    $itemCollection = collect(Auth::user()->wallet->wallethistory);

                    $itemCollection = $itemCollection->sortByDesc('id');

                    // Define how many items we want to be visible in each page
                    $perPage = 7;

                    // Slice the collection to get the items to display in current page
                    $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

                    // Create our paginator and pass it to the view
                    $wallethistory = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);

                    // set url path for generted links
                    $wallethistory->setPath($request->url());

                    return view('user.wallet', compact('conversion_rate', 'wallethistory'));
                } else {
                    return view('user.wallet', compact('conversion_rate'));
                }
            } else {
                notify()->error('Sorry your wallet is not active !');
                return back();
            }

        } else {

            return view('user.wallet', compact('conversion_rate'));
        }
    }

    public function choosepaymentmethod(Request $request)
    {
        require_once 'price.php';
        $amount = $request->amount;
        return view('user.walletpay', compact('amount', 'conversion_rate'));
    }

    public function addMoneyViaPayPal(Request $request)
    {

        $defcurrency = multiCurrency::where('default_currency', '=', 1)->first();
        $setcurrency = $defcurrency->currency->code; //USD
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1')
        /** item name **/
            ->setCurrency($setcurrency)->setQuantity(1)
            ->setPrice($request->amount);
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array(
            $item_1,
        ));
        $amount = new Amount();
        $amount->setCurrency($setcurrency)->setTotal($request->amount);
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Adding money in wallet');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('wallet/success/using/paypal'))
            ->setCancelUrl(URL::to('/userwallet'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array(
            $transaction,
        ));

        try
        {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {

                notify()->error('Connection timeout !');
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = null;
                $failedTranscations->txn_id = 'PAYPAL_FAILED_' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();

                return redirect()->route('user.wallet.show');
            } else {

                notify()->error('Some error occur, Sorry for inconvenient');
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = null;
                $failedTranscations->txn_id = 'PAYPAL_FAILED_' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();

                return redirect()->route('user.wallet.show');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        notify()->error('Unknown error occurred !');
        return redirect()->route('user.wallet.show');

    }

    public function paypalSuccess(Request $request)
    {

        $wallet = UserWallet::where('user_id', Auth::user()->id)->first();
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = null;
            $failedTranscations->txn_id = 'PAYPAL_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            $sentfromlastpage = 0;
            notify()->error('Payment failed !');
            return redirect()->route('user.wallet.show');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /**Execute the payment **/
        $response = $payment->execute($execution, $this->_api_context);

        if ($response->getState() == 'approved') {
            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            $saleId = $sale->getId();

            if (isset($wallet)) {

                // update money if already wallet exist
                if ($wallet->status == 1) {

                    $wallet->balance = $wallet->balance + $sale->amount->total;
                    $wallet->save();

                    //adding log in history

                    $walletlog = new UserWalletHistory;
                    $walletlog->wallet_id = $wallet->id;
                    $walletlog->type = 'Credit';
                    $walletlog->log = 'Added Amount via ' . ucfirst('paypal');
                    $walletlog->amount = $sale->amount->total;
                    $walletlog->txn_id = $payment_id;

                    //adding expire date
                    $days = 365;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    $walletlog->expire_at = $expireDate;
                    $walletlog->save();

                    try {

                        $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                        $currency = $getcurrency->currency->code;
                        $msg1 = 'amount added via Paypal successfully !';
                        $txnid = $payment_id;
                        $amount = $sale->amount->total;
                        $msg2 = 'Updated wallet balance is:';
                        $balance = $wallet->balance;

                        Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                    } catch (\Swift_TransportException $e) {

                    }

                    notify()->success('Amount added successfully !');
                    return redirect()->route('user.wallet.show');

                } else {
                    notify()->error('Your wallet is not active yet ! contact support system !');
                    return back();
                }

            } else {

                // add money
                $wallet = new UserWallet;
                $wallet->user_id = Auth::user()->id;
                $wallet->balance = $sale->amount->total;
                $wallet->status = 1;
                $wallet->save();

                //adding log in history

                $walletlog = new UserWalletHistory;
                $walletlog->wallet_id = $wallet->id;
                $walletlog->type = 'Credit';
                $walletlog->log = 'Added Amount via ' . ucfirst('paypal');
                $walletlog->amount = $sale->amount->total;
                $walletlog->txn_id = $payment_id;

                //adding expire date
                $days = 365;
                $todayDate = date('Y-m-d');
                $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                $walletlog->expire_at = $expireDate;
                $walletlog->save();

                $walletlog->save();

                try {

                    $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                    $currency = $getcurrency->currency->code;
                    $msg1 = 'amount added via Paypal successfully !';
                    $txnid = $payment_id;
                    $amount = $sale->amount->total;
                    $msg2 = 'Updated wallet balance is:';
                    $balance = $wallet->balance;

                    Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                } catch (\Swift_TransportException $e) {

                }

                notify()->success('Amount added successfully !');
                return redirect()->route('user.wallet.show');
            }

        }

    }

    public function addMoneyViaRazorPay(Request $request)
    {

        //Detect wallet
        $wallet = UserWallet::where('user_id', Auth::user()->id)->first();
        //Input items of form
        $input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try
            {

                $response = $api
                    ->payment
                    ->fetch($input['razorpay_payment_id'])->capture(array(
                    'amount' => $payment['amount'],
                ));

                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $payment_id = $payment->id;
                if (isset($wallet)) {

                    // update money if already wallet exist
                    if ($wallet->status == 1) {

                        $wallet->balance = $wallet->balance + ($payment['amount'] / 100);
                        $wallet->save();

                        //adding log in history

                        $walletlog = new UserWalletHistory;
                        $walletlog->wallet_id = $wallet->id;
                        $walletlog->type = 'Credit';
                        $walletlog->log = 'Added Amount via ' . ucfirst('razorpay');
                        $walletlog->amount = $payment['amount'] / 100;
                        $walletlog->txn_id = $payment_id;

                        //adding expire date
                        $days = 365;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        $walletlog->expire_at = $expireDate;

                        $walletlog->save();

                        try {

                            $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                            $currency = $getcurrency->currency->code;
                            $msg1 = 'amount added via Razorpay successfully !';
                            $txnid = $payment_id;
                            $amount = $payment['amount'] / 100;
                            $msg2 = 'Updated wallet balance is:';
                            $balance = $wallet->balance;

                            Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                        } catch (\Swift_TransportException $e) {

                        }

                        notify()->success('Amount added successfully !');
                        return redirect()->route('user.wallet.show');

                    } else {
                        notify()->error('Your wallet is not active yet ! contact support system !');
                        return back();
                    }

                } else {

                    // add money
                    $wallet = new UserWallet;
                    $wallet->user_id = Auth::user()->id;
                    $wallet->balance = $payment['amount'] / 100;
                    $wallet->status = 1;
                    $wallet->save();

                    //adding log in history

                    $walletlog = new UserWalletHistory;
                    $walletlog->wallet_id = $wallet->id;
                    $walletlog->type = 'Credit';
                    $walletlog->log = 'Added Amount via ' . ucfirst('instamojo');
                    $walletlog->amount = $payment['amount'] / 100;
                    $walletlog->txn_id = $payment_id;

                    //adding expire date
                    $days = 365;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    $walletlog->expire_at = $expireDate;

                    $walletlog->save();

                    try {

                        $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                        $currency = $getcurrency->currency->code;
                        $msg1 = 'amount added via Razorpay successfully !';
                        $txnid = $payment_id;
                        $amount = $payment['amount'] / 100;
                        $msg2 = 'Updated wallet balance is:';
                        $balance = $wallet->balance;

                        Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                    } catch (\Swift_TransportException $e) {

                    }

                    notify()->success('Amount added successfully !');
                    return redirect()->route('user.wallet.show');
                }

            } catch (Exception $e) {
                notify()->error($e->getMessage());
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = null;
                $failedTranscations->txn_id = $input['razorpay_payment_id'];
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect()->route('user.wallet.show');
            }

        }
    }

    public function addMoneyViaInstamojo(Request $request)
    {

        $api = new \Instamojo\Instamojo(config('services.instamojo.api_key'), config('services.instamojo.auth_token'), config('services.instamojo.url'));

        try
        {

            $url = url('/wallet/success/using/instamojo');
            $response = $api->paymentRequestCreate(array(
                "purpose" => "Adding Money in wallet",
                "amount" => $request->amount,
                "buyer_name" => Auth::user()->name,
                "send_email" => true,
                "send_sms" => true,
                "email" => Auth::user()->email,
                "phone" => Auth::user()->mobile,
                "redirect_url" => $url,
            ));

            header('Location: ' . $response['longurl']);

            exit();
        } catch (Exception $e) {
            print('Error: ' . $e->getMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = null;
            $failedTranscations->txn_id = 'INSTAMOJO_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->error("Payment Failed ! Try Again");
            return redirect()->route('user.wallet.show');
        }

    }

    public function instaSuccess(Request $request)
    {
        try
        {

            $api = new \Instamojo\Instamojo(config('services.instamojo.api_key'), config('services.instamojo.auth_token'), config('services.instamojo.url'));

            $response = $api->paymentRequestStatus(request('payment_request_id'));

            $payment_id = $response['payments'][0]['payment_id'];

            if (!isset($response['payments'][0]['status'])) {
                dd('payment failed');
            } else if ($response['payments'][0]['status'] != 'Credit') {
                dd('payment failed');
            } else {

                $wallet = UserWallet::where('user_id', Auth::user()->id)->first();

                if (isset($wallet)) {

                    // update money if already wallet exist
                    if ($wallet->status == 1) {

                        $wallet->balance = $wallet->balance + $response['payments'][0]['amount'];
                        $wallet->save();

                        //adding log in history

                        $walletlog = new UserWalletHistory;
                        $walletlog->wallet_id = $wallet->id;
                        $walletlog->type = 'Credit';
                        $walletlog->log = 'Added Amount via ' . ucfirst('instamojo');
                        $walletlog->amount = $response['payments'][0]['amount'];
                        $walletlog->txn_id = $payment_id;

                        //adding expire date
                        $days = 365;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        $walletlog->expire_at = $expireDate;

                        $walletlog->save();

                        try {

                            $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                            $currency = $getcurrency->currency->code;
                            $msg1 = 'Amount added via Instamojo successfully !';
                            $txnid = $payment_id;
                            $amount = $response['payments'][0]['amount'];
                            $msg2 = 'Updated wallet balance is:';
                            $balance = $wallet->balance;

                            Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                        } catch (\Swift_TransportException $e) {

                        }

                        notify()->success('Amount added successfully !');
                        return redirect()->route('user.wallet.show');

                    } else {
                        notify()->error('Your wallet is not active yet ! contact support system !');
                        return back();
                    }

                } else {

                    // add money
                    $wallet = new UserWallet;
                    $wallet->user_id = Auth::user()->id;
                    $wallet->balance = $response['payments'][0]['amount'];
                    $wallet->status = 1;
                    $wallet->save();

                    //adding log in history

                    $walletlog = new UserWalletHistory;
                    $walletlog->wallet_id = $wallet->id;
                    $walletlog->type = 'Credit';
                    $walletlog->log = 'Added Amount via ' . ucfirst('instamojo');
                    $walletlog->amount = $response['payments'][0]['amount'];
                    $walletlog->txn_id = $payment_id;

                    //adding expire date
                    $days = 365;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    $walletlog->expire_at = $expireDate;

                    $walletlog->save();

                    try {

                        $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                        $currency = $getcurrency->currency->code;
                        $msg1 = 'amount added via Instamojo successfully !';
                        $txnid = $payment_id;
                        $amount = $response['payments'][0]['amount'];
                        $msg2 = 'Updated wallet balance is:';
                        $balance = $wallet->balance;

                        Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                    } catch (\Swift_TransportException $e) {

                    }

                    notify()->success('Amount added successfully !');
                    return redirect()->route('user.wallet.show');
                }

            }
        } catch (\Exception $e) {

            notify()->error("Payment Failed ! Try Again");
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'INSTAMOJO_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->error("Payment Failed ! Try Again");
            return redirect()->route('user.wallet.show');
        }
    }

    public function addMoneyViaStripe(Request $request)
    {
        $expiry = explode('/', $request->expiry);
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'expiry' => 'required',
            'cvc' => 'required|max:3',
            'amount' => 'required',
        ]);

        $input = $request->all();

        if ($validator->passes()) {

            $input = array_except($input, array('_token'));

            $stripe = Stripe::make(env('STRIPE_SECRET'));

            if ($stripe == '' || $stripe == null) {
                notify()->error("Stripe Key Not Found Please Contact your Site Admin !");
                return redirect()->route('user.wallet.show');
            }

            try {

                $month = (int) $expiry[0];
                $year = (int) $expiry[1];

                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $request->get('number'),
                        'exp_month' => $month,
                        'exp_year' => $year,
                        'cvc' => $request->get('cvc'),
                    ],
                ]);

                if (!isset($token['id'])) {
                    notify()->error('The Stripe Token was not generated correctly !');
                    return redirect()->route('user.wallet.show');
                }

                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => $request->amount,
                    'description' => "Add Money in wallet",
                ]);

                if ($charge['status'] == 'succeeded') {

                    $payment_id = $charge['id'];

                    $wallet = UserWallet::where('user_id', Auth::user()->id)->first();

                    if (isset($wallet)) {

                        // update money if already wallet exist
                        if ($wallet->status == 1) {

                            $wallet->balance = $wallet->balance + ($charge['amount'] / 100);
                            $wallet->save();

                            //adding log in history

                            $walletlog = new UserWalletHistory;
                            $walletlog->wallet_id = $wallet->id;
                            $walletlog->type = 'Credit';
                            $walletlog->log = 'Added Amount via ' . ucfirst('stripe');
                            $walletlog->amount = $charge['amount'] / 100;
                            $walletlog->txn_id = $payment_id;

                            //adding expire date
                            $days = 365;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                            $walletlog->expire_at = $expireDate;

                            $walletlog->save();

                            try {

                                $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                                $currency = $getcurrency->currency->code;
                                $msg1 = 'amount added via Stripe successfully !';
                                $txnid = $payment_id;
                                $amount = $charge['amount'] / 100;
                                $msg2 = 'Updated wallet balance is:';
                                $balance = $wallet->balance;

                                Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                            } catch (\Swift_TransportException $e) {

                            }

                            notify()->success('Amount added successfully !');
                            return redirect()->route('user.wallet.show');

                        } else {
                            notify()->error('Your wallet is not active yet ! contact support system !');
                            return back();
                        }

                    } else {

                        // add money
                        $wallet = new UserWallet;
                        $wallet->user_id = Auth::user()->id;
                        $wallet->balance = $charge['amount'] / 100;
                        $wallet->status = 1;
                        $wallet->save();

                        //adding log in history

                        $walletlog = new UserWalletHistory;
                        $walletlog->wallet_id = $wallet->id;
                        $walletlog->type = 'Credit';
                        $walletlog->log = 'Added Amount via ' . ucfirst('stripe');
                        $walletlog->amount = $charge['amount'] / 100;
                        $walletlog->txn_id = $payment_id;

                        //adding expire date
                        $days = 365;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        $walletlog->expire_at = $expireDate;

                        $walletlog->save();

                        try {

                            $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                            $currency = $getcurrency->currency->code;
                            $msg1 = 'amount added via Stripe successfully !';
                            $txnid = $payment_id;
                            $amount = $charge['amount'] / 100;
                            $msg2 = 'Updated wallet balance is:';
                            $balance = $wallet->balance;

                            Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                        } catch (\Swift_TransportException $e) {

                        }

                        notify()->success('Amount added successfully !');
                        return redirect()->route('user.wallet.show');
                    }

                } else {
                    notify()->error('Payment failed !');

                    $failedTranscations = new FailedTranscations;
                    $failedTranscations->txn_id = 'Stripe_FAILED' . str_random(5);
                    $failedTranscations->user_id = Auth::user()->id;
                    $failedTranscations->save();
                    return redirect()->route('user.wallet.show');
                }

            } catch (Exception $e) {

                notify()->error($e->getMessage());

                $failedTranscations = new FailedTranscations;
                $failedTranscations->txn_id = 'Stripe_FAILED' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();

                return redirect()->route('user.wallet.show');
            } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
                notify()->error($e->getMessage());

                $failedTranscations = new FailedTranscations;
                $failedTranscations->txn_id = 'Stripe_FAILED' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect()->route('user.wallet.show');
            } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                notify()->error($e->getMessage());

                $failedTranscations = new FailedTranscations;
                $failedTranscations->txn_id = 'Stripe_FAILED' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect()->route('user.wallet.show');
            }

        } else {
            notify()->error("All fields are required !");
            return redirect()->route('user.wallet.show');
        }
    }

    public function addMoneyViaPaytm(Request $request)
    {

        $orderID = uniqid();
        $amount = round($request->amount, 2);
        $payment = PaytmWallet::with('receive');

        $payment->prepare([
            'order' => $orderID,
            'user' => Auth::user()->id,
            'mobile_number' => Auth::user()->mobile,
            'email' => Auth::user()->email,
            'amount' => $amount,
            'callback_url' => url('/wallet/success/using/paytm'),
        ]);

        return $payment->receive();
    }

    public function paytmsuccess()
    {

        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();

        if ($transaction->isSuccessful()) {

            $wallet = UserWallet::where('user_id', Auth::user()->id)->first();

            if (isset($wallet)) {

                // update money if already wallet exist
                if ($wallet->status == 1) {

                    $wallet->balance = $wallet->balance + $response['TXNAMOUNT'];
                    $wallet->save();

                    //adding log in history

                    $walletlog = new UserWalletHistory;
                    $walletlog->wallet_id = $wallet->id;
                    $walletlog->type = 'Credit';
                    $walletlog->log = 'Added Amount via ' . ucfirst('paytm');
                    $walletlog->amount = $response['TXNAMOUNT'];
                    $walletlog->txn_id = $transaction->getTransactionId();

                    //adding expire date
                    $days = 365;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    $walletlog->expire_at = $expireDate;

                    $walletlog->save();

                    try {

                        $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                        $currency = $getcurrency->currency->code;
                        $msg1 = 'amount added via Paytm successfully !';
                        $txnid = $transaction->getTransactionId();
                        $amount = $response['TXNAMOUNT'];
                        $msg2 = 'Updated wallet balance is:';
                        $balance = $wallet->balance;

                        Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                    } catch (\Swift_TransportException $e) {

                    }

                    notify()->success('Amount added successfully !');
                    return redirect()->route('user.wallet.show');

                } else {
                    notify()->error('Your wallet is not active yet ! contact support system !');
                    return redirect('/');
                }

            } else {

                // add money
                $wallet = new UserWallet;
                $wallet->user_id = Auth::user()->id;
                $wallet->balance = $response['TXNAMOUNT'];
                $wallet->status = 1;
                $wallet->save();

                //adding log in history

                $walletlog = new UserWalletHistory;
                $walletlog->wallet_id = $wallet->id;
                $walletlog->type = 'Credit';
                $walletlog->log = 'Added Amount via ' . ucfirst('paytm');
                $walletlog->amount = $response['TXNAMOUNT'];
                $walletlog->txn_id = $transaction->getTransactionId();

                //adding expire date
                $days = 365;
                $todayDate = date('Y-m-d');
                $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                $walletlog->expire_at = $expireDate;

                $walletlog->save();

                try {

                    $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                    $currency = $getcurrency->currency->code;
                    $msg1 = 'amount added via Paytm successfully !';
                    $txnid = $transaction->getTransactionId();
                    $amount = $response['TXNAMOUNT'];
                    $msg2 = 'Updated wallet balance is:';
                    $balance = $wallet->balance;

                    Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

                } catch (\Swift_TransportException $e) {

                }

                notify()->success('Amount added successfully !');
                return redirect()->route('user.wallet.show');
            }

        } elseif ($transaction->isFailed()) {

            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYTM_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->error($transaction->getResponseMessage());
            return redirect()->route('user.wallet.show');

        } elseif ($transaction->isOpen()) {
            //Transaction Open/Processing

        } else {

            notify()->error("Payment Failed ! Try Again");
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYTM_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->error($transaction->getResponseMessage());
            return redirect()->route('user.wallet.show');
        }
    }

    public function addMoneyViaBraintree(Request $request)
    {

        $amount = round($request->amount, 2);
        $user = User::find(Auth::user()->id);
        $response = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $request->payment_method_nonce,
            'customerId' => $this->createCustomer(),
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        if ($response->success == true) {

            $txnID = $response->transaction->id;

            if (isset($user->wallet)) {

                if ($user->wallet->status == 1) {

                    $user->wallet()->update([
                        'balance' => ($user->wallet->balance) + ($response->transaction->amount),
                    ]);

                } else {
                    notify()->error('Your wallet is not active yet ! contact support system !');
                    return redirect('/');
                }

            } else {

                $wallet = $user->wallet()->create([
                    'balance' => $response->transaction->amount,
                    'user_id' => Auth::user()->id,
                    'status' => 1,
                ]);

            }

            //adding log in history

            $walletlog = new UserWalletHistory();
            $walletlog->wallet_id = isset($user->wallet) ? $user->wallet->id : $wallet->id;
            $walletlog->type = 'Credit';
            $walletlog->log = 'Added Amount via ' . ucfirst('Braintree');
            $walletlog->amount = $response->transaction->amount;
            $walletlog->txn_id = $txnID;

            //adding expire date
            $days = 365;
            $todayDate = date('Y-m-d');
            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
            $walletlog->expire_at = $expireDate;

            $walletlog->save();

            try {

                $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
                $currency = $getcurrency->currency->code;
                $msg1 = 'amount added via Braintree successfully !';
                $txnid = $txnID;
                $amount = $response->transaction->amount;
                $msg2 = 'Updated wallet balance is:';
                $balance = Auth::user()->wallet->balance;

                Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $currency));

            } catch (\Swift_TransportException $e) {

            }

            notify()->success('Amount added successfully !');

            return redirect()->route('user.wallet.show');

        } else {
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'BT_WALLET_FAILED' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->error($response->message);
            return redirect()->route('user.wallet.show');
        }
    }

    public function walletaccesstokenBT()
    {
        $clientToken = $this->gateway->clientToken()->generate();
        return response()->json(array('client' => $clientToken));
    }

    public function createCustomer()
    {

        if (!Auth::user()->braintree_id) {

            $result = $this->gateway->customer()->create([
                'firstName' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]);

            if ($result->success) {
                User::where('id', Auth::user()->id)->update(['braintree_id' => $result->customer->id]);
                return $result->customer->id;
            }

        } else {
            return Auth::user()->braintree_id;
        }

    }

    /* Config function to get the braintree config data to process all the apis on braintree gateway */
    public function brainConfig()
    {

        return new Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

    }

    /* Wallet checkout for order */
    public function checkout(Request $request)
    {
        require_once 'price.php';
        $order_id = Session::get('order_id');
        $amount = round(Crypt::decrypt($request->amount), 2);

        $cart_table = Auth::user()->cart;
        $total = 0;

        foreach ($cart_table as $cart) {

            if ($cart->product->tax_r != null && $cart->product->tax == 0) {

                if ($cart->ori_offer_price != 0) {
                    //get per product tax amount
                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->offer_price / $vp * $taxrate_db;
                    $taxAmnt = sprintf("%.2f", $taxAmnt);
                    $price = ($cart->ori_offer_price - $taxAmnt) * $cart->qty;

                } else {

                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->price / $vp * $taxrate_db;

                    $taxAmnt = sprintf("%.2f", $taxAmnt);

                    $price = ($cart->ori_price - $taxAmnt) * $cart->qty;
                }

            } else {

                if ($cart->semi_total != 0) {

                    $price = $cart->semi_total;

                } else {

                    $price = $cart->price_total;

                }
            }

            $total = $total + $price;

        }

        $total = sprintf("%.2f", $total * $conversion_rate);

        if (round($request->actualtotal, 2) != round($total, 2)) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }

        try {

            $hc = decrypt(Session::get('handlingcharge'));

            $billing = Session::get('billing');
            $user = Auth::user();
            $invno = 0;
            $venderarray = array();
            $qty_total = 0;
            $pro_id = array();
            $mainproid = array();
            $total_tax = 0;
            $total_shipping = 0;
            $cart_table = Cart::where('user_id', $user->id)
                ->get();

            $lastid = Session::get('lastid');

            $payble = 0;

            $payment_id = 'WALLET_PAYMENT_' . uniqid();

            foreach ($cart_table as $key => $cart) {

                array_push($venderarray, $cart->vender_id);

                $qty_total = $qty_total + $cart->qty;

                array_push($pro_id, $cart->variant_id);

                array_push($mainproid, $cart->pro_id);

                $total_tax = $total_tax + $cart->tax_amount;

                $total_shipping = $total_shipping + $cart->shipping;

            }

            $total_shipping = sprintf("%.2f", $total_shipping * $conversion_rate);

            if (Session::has('coupanapplied')) {

                $discount = Session::get('coupanapplied')['discount'];

            } else {

                $discount = 0;
            }

            $venderarray = array_unique($venderarray);
            $hc = round($hc, 2);
            $neworder = new Order();
            $neworder->order_id = $order_id;
            $neworder->qty_total = $qty_total;
            $neworder->user_id = Auth::user()->id;
            $neworder->delivery_address = Session::get('address');
            $neworder->billing_address = Session::get('billing');
            $neworder->order_total = round($amount - $hc, 2);
            $neworder->tax_amount = round($total_tax, 2);
            $neworder->shipping = round($total_shipping, 2);
            $neworder->status = '1';
            $neworder->paid_in = session()->get('currency')['value'];
            $neworder->vender_ids = $venderarray;
            $neworder->transaction_id = $payment_id;
            $neworder->payment_receive = 'yes';
            $neworder->payment_method = 'Wallet';
            $neworder->pro_id = $pro_id;
            $neworder->paid_in_currency = Session::get('currency')['id'];
            $neworder->main_pro_id = $mainproid;
            $neworder->handlingcharge = $hc;
            $neworder->created_at = date('Y-m-d H:i:s');
            $neworder->coupon = Session::get('coupanapplied')['code'];
            $neworder->discount = $discount * $conversion_rate;
            $neworder->distype = Session::get('coupanapplied')['appliedOn'];
            $neworder->save();

            #Getting Invoice Prefix
            $invStart = Invoice::first()->inv_start;
            #end
            #Count order
            $ifanyorder = count(Order::all());
            $cart_table2 = Cart::where('user_id', Auth::user()->id)
                ->orderBy('vender_id', 'ASC')
                ->get();

            /*Handling charge per item count*/
            $hcsetting = Genral::first();

            if ($hcsetting->chargeterm == 'pi') {
                $perhc = $hc / count($cart_table2);

            } else {
                $perhc = $hc;
            }
            /*END*/

            #Creating Invoice
            foreach ($cart_table2 as $key => $invcart) {

                $lastinvoices = InvoiceDownload::where('order_id', $neworder->id)
                    ->get();
                $lastinvoicerow = InvoiceDownload::orderBy('id', 'desc')->first();

                if (count($lastinvoices) > 0) {

                    foreach ($lastinvoices as $last) {
                        if ($invcart->vender_id == $last->vender_id) {
                            $invno = $last->inv_no;

                        } else {
                            $invno = $last->inv_no;
                            $invno = $invno + 1;
                        }
                    }

                } else {
                    if ($lastinvoicerow) {
                        $invno = $lastinvoicerow->inv_no + 1;
                    } else {
                        $invno = $invStart;
                    }

                }

                $findvariant = AddSubVariant::find($invcart->variant_id);
                $price = 0;

                /*Handling charge per item count*/
                $hcsetting = Genral::first();

                if ($hcsetting->chargeterm == 'pi') {

                    $perhc = $hc / count($cart_table2);

                } else {

                    $perhc = $hc / count($cart_table2);

                }
                /*END*/

                if ($invcart->semi_total != 0) {

                    if ($findvariant->products->tax_r != '') {

                        $p = 100;
                        $taxrate_db = $findvariant->products->tax_r;
                        $vp = $p + $taxrate_db;
                        $tam = $findvariant->products->offer_price / $vp * $taxrate_db;
                        $tam = sprintf("%.2f", $tam);

                        $price = sprintf("%.2f", ($invcart->ori_offer_price - $tam) * $conversion_rate);
                    } else {
                        $price = $invcart->ori_offer_price * $conversion_rate;
                        $price = sprintf("%.2f", $price);
                    }

                } else {

                    if ($findvariant->products->tax_r != '') {

                        $p = 100;

                        $taxrate_db = $findvariant->products->tax_r;

                        $vp = $p + $taxrate_db;

                        $tam = $findvariant->products->vender_price / $vp * $taxrate_db;

                        $tam = sprintf("%.2f", $tam);

                        $price = sprintf("%.2f", ($invcart->ori_price - $tam) * $conversion_rate);

                    } else {
                        $price = $invcart->ori_price * $conversion_rate;
                        $price = sprintf("%.2f", $price);

                    }
                }

                $newInvoice = new InvoiceDownload();
                $newInvoice->order_id = $neworder->id;
                $newInvoice->inv_no = $invno;
                $newInvoice->qty = $invcart->qty;
                $newInvoice->status = 'pending';
                $newInvoice->local_pick = $invcart->ship_type;
                $newInvoice->variant_id = $invcart->variant_id;
                $newInvoice->vender_id = $invcart->vender_id;
                $newInvoice->price = $price;
                $newInvoice->tax_amount = $invcart->tax_amount;
                $newInvoice->igst = session()->has('igst') ? session()->get('igst')[$key] : null;
                $newInvoice->sgst = session()->has('indiantax') ? session()->get('indiantax')[$key]['sgst'] : null;
                $newInvoice->cgst = session()->has('indiantax') ? session()->get('indiantax')[$key]['cgst'] : null;
                $newInvoice->shipping = round($invcart->shipping * $conversion_rate, 2);
                $newInvoice->discount = round($invcart->disamount * $conversion_rate, 2);
                $newInvoice->handlingcharge = $perhc;
                $newInvoice->tracking_id = InvoiceDownload::createTrackingID();

                if ($invcart->product->vender->role_id == 'v') {
                    $newInvoice->paid_to_seller = 'NO';
                }

                $newInvoice->save();

            }
            #end

            // Coupon applied //
            $c = Coupan::find(Session::get('coupanapplied')['cpnid']);

            if (isset($c)) {
                $c->maxusage = $c->maxusage - 1;
                $c->save();
            }

            //end //

            foreach ($cart_table as $carts) {

                $id = $carts->variant_id;
                $variant = AddSubVariant::findorfail($id);

                if (isset($variant)) {

                    $used = $variant->stock - $carts->qty;
                    DB::table('add_sub_variants')->where('id', $id)->update(['stock' => $used]);

                }

            }

            $inv_cus = Invoice::first();
            $orderiddb = $inv_cus->order_prefix . $order_id;
            $paidcurrency = Session::get('currency')['id'];
            $user->notify(new UserOrderNotification($order_id, $orderiddb));
            $get_admins = User::where('role_id', '=', 'a')->get();

            /*Sending notifcation to all admindesk*/
            \Notification::send($get_admins, new OrderNotification($order_id, $orderiddb));

            /*Send notifcation to vender*/
            $vender_system = Genral::first()->vendor_enable;

            /*if vender system enable and user role is not admindesk*/
            if ($vender_system == 1) {

                $msg = "New Order $orderiddb Received !";
                $url = route('seller.view.order', $order_id);

                foreach ($venderarray as $key => $vender) {
                    $v = User::find($vender);
                    if ($v->role_id == 'v') {
                        $v->notify(new SellerNotification($url, $msg));
                    }
                }

            }
            /*end*/

            Session::forget('page-reloaded');
            /*Send Mail to User*/

            $getcurrency = multiCurrency::where('default_currency', '=', 1)->first();
            $defcurrency = $getcurrency->currency->code;
            $conv = currency($amount, $from = session()->get('currency')['id'], $to = $defcurrency, $format = false);
            $conv_wallet_amount = sprintf("%.2f", $conv);
            $wallet = UserWallet::where('user_id', Auth::user()->id)->first();

            if (isset($wallet)) {

                $wallet->balance = $wallet->balance - $conv_wallet_amount;
                $wallet->save();

                //adding log in history

                $walletlog = new UserWalletHistory;
                $walletlog->wallet_id = $wallet->id;
                $walletlog->type = 'Debit';
                $walletlog->log = 'Payment for order ' . $order_id;
                $walletlog->amount = $conv_wallet_amount;
                $walletlog->txn_id = $payment_id;
                $walletlog->save();

                // Putting order log in admindesk wallet logs

                $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                $adminwalletlog = new OrderWalletLogs;
                $adminwalletlog->wallet_txn_id = $payment_id;
                $adminwalletlog->note = 'Payment for order #' . $order_id;
                $adminwalletlog->type = 'Credit';
                $adminwalletlog->amount = $conv_wallet_amount;
                $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance + $conv_wallet_amount : $conv_wallet_amount;

                $adminwalletlog->save();

                try {

                    $msg1 = 'paid successfully from your wallet !';
                    $txnid = $payment_id;
                    $amount = $amount;
                    $msg2 = 'Updated wallet balance is:';
                    $balance = $wallet->balance;

                    Mail::to(Auth::user()->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $defcurrency));

                } catch (\Swift_TransportException $e) {

                }

            }

            try {

                $e = Address::find($neworder->delivery_address);
                if (isset($e) && $e->email) {
                    Mail::to($e->email)->send(new OrderMail($neworder, $inv_cus, $paidcurrency));
                }

            } catch (\Exception $e) {

            }

            $config = AppConfig::first();

            if($config->sms_channel == '1'){

                $smsmsg = 'Your order #'.$orderiddb.' placed successfully ! You can view your order by visiting here:%0a';

                $smsurl = route('user.view.order',$neworder->order_id);
        
                $smsmsg .= $smsurl.'%0a%0a';
        
                $smsmsg .= 'Thanks for shopping with us - '.config('app.name');

                if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $config->msg91_enable == '1'){

                    try{
                        
                        $user->notify(new SMSNotifcations($smsmsg));

                    }catch(\Exception $e){

                        \Log::error('Error: '.$e->getMessage());

                    }

                }

                if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){

                    try{
                        Twilosms::sendMessage($smsmsg, '+'.Auth::user()->phonecode.Auth::user()->mobile);
                    }catch(\Exception $e){
                        \Log::error('Twillo Error: '.$e->getMessage());
                    }

                }
            }

            Session::forget('cart');
            Session::forget('coupan');
            Session::forget('billing');
            Session::forget('coupanapplied');
            Session::forget('lastid');
            Session::forget('address');
            Session::forget('payout');

            Cart::where('user_id', $user->id)->delete();

            $wallet = UserWallet::where('user_id', Auth::user()->id)->first();

            $newmsg = "Order #$inv_cus->order_prefix $neworder->order_id placed successfully !";
            notify()->success("$newmsg");
            return redirect()->route('order.done',['orderid' => $neworder->order_id]);

        } catch (\Exception $e) {
            //Return Exception
            notify()->error($e->getMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = $order_id;
            $failedTranscations->txn_id = 'WALLET_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(route('order.review'));
        }

    }

    // public function giftPoint(Request $request, $id)
    // {

    //     $wallet = UserWallet::where('user_id', '=', $id)->first();
    //     $payment_id = 'WALLET_' . uniqid();

    //     if (isset($wallet)) {

    //         $wallet->balance = $wallet->balance + $request->point;
    //         $wallet->save();

    //         //add history in wallet log

    //         $walletlog = new UserWalletHistory;
    //         $walletlog->wallet_id = $wallet->id;
    //         $walletlog->type = 'Credit';
    //         $walletlog->log = 'Point gifted from admindesk';
    //         $walletlog->amount = $request->point;
    //         $walletlog->txn_id = $payment_id;

    //         //adding expire date
    //         $days = 365;
    //         $todayDate = date('Y-m-d');
    //         $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
    //         $walletlog->expire_at = $expireDate;

    //         $walletlog->save();

    //     } else {

    //         // add point and creating wallet if not found //
    //         $wallet = new UserWallet;
    //         $wallet->user_id = $id;
    //         $wallet->balance = $request->point;
    //         $wallet->status = 1;
    //         $wallet->save();

    //         //add history in wallet log

    //         $walletlog = new UserWalletHistory;
    //         $walletlog->wallet_id = $wallet->id;
    //         $walletlog->type = 'Credit';
    //         $walletlog->log = 'Point gifted from admindesk';
    //         $walletlog->amount = $request->point;
    //         $walletlog->txn_id = $payment_id;

    //         //adding expire date
    //         $days = 365;
    //         $todayDate = date('Y-m-d');
    //         $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
    //         $walletlog->expire_at = $expireDate;

    //         $walletlog->save();
    //     }

    //     return back()->with('added', 'Points gifted successfully !');
    // }

}
