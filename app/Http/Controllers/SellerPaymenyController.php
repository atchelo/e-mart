<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDownload;
use App\Mail\PayoutNotify;
use App\multiCurrency;
use App\Notifications\SellerNotification;
use App\OrderWalletLogs;
use App\PendingPayout;
use App\SellerPayout;
use App\Store;
use App\User;
use Auth;
use Crypt;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use PayPal\Api\Payout;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class SellerPaymenyController extends Controller
{
    private $_api_context;
    

    public function __construct()
    {
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this
            ->_api_context
            ->setConfig($paypal_conf['settings']);
    }

    public function manualPayout(Request $request, $venderid, $orderid)
    {

        $order = PendingPayout::findorfail($orderid);

        $amount = $request->amount;

        $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();

        $check = SellerPayout::where('pending_payout_id', '=', $orderid)->first();

        $inv_cus = Invoice::first();

        if (isset($check)) {
            return back()->with('warning', 'For this order payout is already done to the seller !');
            exit(1);
        } else {

            DB::beginTransaction();

            $newpayout = new SellerPayout();
            $newpayout->payoutid = str_random(6);
            $newpayout->orderid = $order->singleorder->id;
            $newpayout->sellerid = $order->sellerid;
            $newpayout->paidby = auth()->id();
            $newpayout->paid_in = $defCurrency->currency->code;
            $newpayout->orderamount = $request->amount;
            $newpayout->txn_fee = $request->txn_fee;
            $newpayout->txn_id = $request->txn_id;
            $newpayout->paidvia = $request->paidvia;
            $newpayout->txn_type = 'manual';
            $newpayout->status = 'Complete';
            $newpayout->pending_payout_id = $order->id;
            $newpayout->save();

            DB::commit();

            $item = $inv_cus->prefix . $order->singleorder->inv_no . $inv_cus->postfix;
            $msg = "You Received a new Payout for Order Item #$item";
            $currency = $defCurrency->currency->code;
            $amount = $request->amount;
            $type = 'manual';
            $url = route('vender.payout.show.complete', $newpayout->id);

            if ($order->singleorder->order->payment_method == 'Wallet') {
              $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

              $adminwalletlog = new OrderWalletLogs;
              $adminwalletlog->wallet_txn_id = $newpayout->txn_id;
              $adminwalletlog->note = "Payout to seller for invoice no. #$item";
              $adminwalletlog->type = 'Debit';
              $adminwalletlog->amount = $request->amount;
              $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $request->amount : $request->amount;

              $adminwalletlog->save();
          }

            $updateInvoice = InvoiceDownload::where('id', $order->singleorder->id)->update(['paid_to_seller' => 'YES']);

            /*Sending Notification*/
            $v = User::find($order->sellerid);

            if (isset($v)) {

                $v->notify(new SellerNotification($url, $msg));

                /*Sending Mail*/
                try {

                    Mail::to($v->email)->send(new PayoutNotify($msg, $currency, $amount, $type));

                } catch (\Swift_TransportException $e) {
                    //No Code
                }
            }

            $order->delete();

            return redirect()->route('seller.payout.complete')->with('added', 'Payout record for that order stored !');

        }
    }

    public function index(Request $request)
    {

        require_once 'price.php';

        $payouts = \DB::table('pending_payouts')
            ->join('invoice_downloads', 'pending_payouts.orderid', '=', 'invoice_downloads.id')
            ->join('orders', 'invoice_downloads.order_id', '=', 'orders.id')
            ->join('users', 'users.id', '=', 'invoice_downloads.vender_id')
            ->join('stores', 'stores.user_id', '=', 'invoice_downloads.vender_id')
            ->select('orders.payment_method as ordertype', 'orders.order_id as orderid', 'invoice_downloads.inv_no as inv_no', 'users.name as sellername', 'stores.name as storename', 'pending_payouts.orderamount as orderamount', 'pending_payouts.id as payoutid', 'pending_payouts.paid_in as currency')
            ->where('invoice_downloads.paid_to_seller', '=', 'NO')->get();

        if ($request->ajax()) {

            return Datatables::of($payouts)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    if ($row->ordertype == 'COD') {
                        $data = "<label class='label label-primary'>$row->ordertype</label>";
                    } else {
                        $data = "<label class='label label-primary'>PREPAID</label>";
                    }

                    return $data;
                })
                ->addColumn('orderid', function ($row) {
                    $inv = Invoice::first();
                    $data = "<b>#$inv->order_prefix $row->orderid</b>";
                    $data .= "<br>";
                    $data .= "<small><b>Invoice No:</b> <u>#$inv->prefix $row->inv_no $inv->postfix</u></small>";
                    return $data;
                })->addColumn('amount', function ($row) {
                return $data = $row->currency . ' ' . sprintf("%.2f",$row->orderamount);
            })
                ->addColumn('detail', function ($row) {
                    $data = "<p><b>Seller:</b> $row->sellername</p>";
                    $data .= "<p><b>Store:</b> $row->storename</p>";

                    return $data;
                })
                ->addColumn('action', 'admindesk.seller.paybtn')
                ->rawColumns(['type', 'orderid', 'amount', 'detail', 'action'])
                ->make(true);

        }

        return view('admindesk.seller.index', compact('conversion_rate'));
    }

    public function track(Request $request, $batchid)
    {
        if ($request->ajax()) {
            $response = Payout::get($batchid, $this->_api_context);
            return view('admindesk.seller.receipt', compact('response'));
        }
    }

    public function complete(Request $request)
    {

        $data = SellerPayout::join('invoice_downloads', 'sellerpayouts.orderid', '=', 'invoice_downloads.id')->join('orders', 'orders.id', '=', 'invoice_downloads.order_id')->join('users', 'users.id', '=', 'invoice_downloads.vender_id')->join('stores', 'stores.user_id', '=', 'users.id')->select('users.name as sellername', 'stores.name as storename', 'sellerpayouts.*', 'orders.order_id as orderid', 'invoice_downloads.inv_no as invid')->get();

        if ($request->ajax()) {

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('type', function ($row) {

                    if ($row->paidvia == 'Bank') {
                        return $html = '<label class="label label-success">Bank Transfer</label>';
                    } elseif ($row->paidvia == 'Paypal') {
                        return $html = '<label class="label label-primary">PayPal</label>';
                    } elseif ($row->txn_type == 'manual') {
                        return $html = '<label class="label label-primary">' . ucfirst($row->paidvia) . '</label>';
                    }

                })
                ->addColumn('orderid', 'admindesk.seller.orderid')
                ->addColumn('amount', function ($row) {
                    $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();
                    $amount = "<i class='cursym $defCurrency->currency_symbol'></i> $row->orderamount";
                    return $amount;
                })
                ->addColumn('detail', function ($row) {
                    $data = "<p><b>Seller:</b> $row->sellername<p>";
                    $data .= "<p><b>Store:</b> $row->storename</p>";
                    return $data;
                })
                ->addColumn('paidon', function ($row) {
                    $html = '<p><b>Created On:</b> ' . date("d-M-Y | h:i A", strtotime($row->created_at)) . '</p>';
                    $html .= '<p><b>Updated On:</b> ' . date('d-m-Y | h:i A', strtotime($row->updated_at)) . '</p>';
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $html = '<a href=' . route("seller.payout.show.complete", $row->id) . ' title="View payout detail" class="btn btn-flat btn-sm bg-blue">View</a>';
                    return $html;
                })
                ->rawColumns(['type', 'orderid', 'amount', 'detail', 'paidon', 'action'])->make(true);

        }

        return view('admindesk.seller.payment.index');
    }

    public function payoutprocess(Request $request, $venderid, $orderid)
    {

        $order = PendingPayout::findorfail($orderid);

        $amount = Crypt::decrypt($request->amount);

        $findstore = Store::where('user_id', '=', $venderid)->first();

        $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();

        $check = SellerPayout::where('pending_payout_id', '=', $orderid)->first();

        if (isset($check)) {
            return back()->with('warning', 'For this order payout is already done to the seller !');
            exit(1);
        }

        if ($findstore->preferd == 'paypal') {

            return $this->payoutviaPaypal($findstore, $amount, $order, $defCurrency);

        } elseif ($findstore->preferd == 'stripe') {

            return $this->payoutviaStripe();

        } else {
            return back()->with('warning', 'Seller Not updated thier payment details !');
        }

    }

    public function payoutviabank(Request $request, $venderid, $orderid)
    {

        $order = PendingPayout::findorfail($orderid);

        $amount = $request->amount;

        $findstore = Store::where('user_id', '=', $venderid)->first();

        $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();

        $check = SellerPayout::where('pending_payout_id', '=', $orderid)->first();

        $inv_cus = Invoice::first();

        if (isset($check)) {
            return back()->with('warning', 'For this order payout is already done to the seller !');
            exit(1);
        } else {

            DB::beginTransaction();

            $newpayout = new SellerPayout();
            $newpayout->payoutid = str_random(6);
            $newpayout->orderid = $order->singleorder->id;
            $newpayout->sellerid = $order->sellerid;
            $newpayout->paidby = Auth::user()->id;
            $newpayout->paid_in = $defCurrency->currency->code;
            $newpayout->orderamount = $request->amount;
            $newpayout->txn_fee = $request->txn_fee;
            $newpayout->txn_id = str_random(10);
            $newpayout->paidvia = 'Bank';
            $newpayout->status = 'Complete';
            $newpayout->txn_type = $request->transfer_type;
            $newpayout->acno = $request->acno;
            $newpayout->ifsccode = $request->ifsccode;
            $newpayout->bankname = $request->bankname;
            $newpayout->acholder = $request->acholder;
            $newpayout->pending_payout_id = $order->id;
            $newpayout->save();

            DB::commit();

            $item = $inv_cus->prefix . $order->singleorder->inv_no . $inv_cus->postfix;
            $msg = "You Received a new Payout for Order Item #$item";
            $currency = $defCurrency->currency->code;
            $amount = $request->amount;
            $type = 'bank';
            $url = route('vender.payout.show.complete', $newpayout->id);

            if ($order->singleorder->order->payment_method == 'Wallet') {
              $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

              $adminwalletlog = new OrderWalletLogs;
              $adminwalletlog->wallet_txn_id = $newpayout->txn_id ;
              $adminwalletlog->note = "Payout to seller for invoice no. #$item";
              $adminwalletlog->type = 'Debit';
              $adminwalletlog->amount = $request->amount;
              $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $request->amount : $request->amount;

              $adminwalletlog->save();
          }

            $updateInvoice = InvoiceDownload::where('id', $order->singleorder->id)->update(['paid_to_seller' => 'YES']);

            /*Sending Notification*/
            $v = User::find($order->sellerid);

            if (isset($v)) {
                $v->notify(new SellerNotification($url, $msg));

                /*Sending Mail*/
                try {
                    Mail::to($v->email)->send(new PayoutNotify($msg, $currency, $amount, $type));
                } catch (\Swift_TransportException $e) {
                    // No Code
                }
            }

            //Remove pending payout entry if payout successfull //
            $order->delete();
            return redirect()->route('seller.payout.complete')->with('added', 'Payout for that order completed successfully !');

        }

    }

    public function show($id)
    {

        $inv_cus = Invoice::first();
        $order = PendingPayout::find($id);

        if (isset($order)) {

            /*find order have return policy or not*/

            if ($order->singleorder->variant->products->return_avbl == 0) {

                return view('admindesk.seller.showdetail', compact('inv_cus', 'order'));

            } elseif ($order->singleorder->variant->products->return_avbl == 1) {

                /*find the order return policy and when its ended than show this page else throw an error*/
                $days = $order->singleorder->variant->products->returnPolicy->days;
                $endOn = date("Y-m-d", strtotime("$order->updated_at +$days days"));
                $today = date('Y-m-d');

                if ($today <= $endOn) {
                    return back()->with('warning', 'You cant pay to seller until product return policy not ended !');
                } else {

                    return view('admindesk.seller.showdetail', compact('inv_cus', 'order'));
                }

            }

        } else {
            return back()->with('warning', 'Order details not found !');
        }

    }

    public function showCompletePayout($id)
    {
        $payout = SellerPayout::whereHas('singleorder')->with('singleorder')->findorfail($id);

        $inv_cus = Invoice::first();
        if ($payout->paidvia == 'Bank' || $payout->txn_type == 'manual') {
            $status = $payout->status;
            $txnid = $payout->txn_id;
        } else {
            $response = Payout::get($payout->txn_id, $this->_api_context);
            $status = $response->batch_header->batch_status;
            $txnid = $response->items[0]->transaction_id;
        }
        return view('admindesk.seller.payment.detail', compact('payout', 'inv_cus', 'txnid', 'status'));
    }

    public function printSlip($id)
    {
        $payout = SellerPayout::findorfail($id);
        if ($payout->paidvia == 'Bank' || $payout->txn_type == 'manual') {
            $status = $payout->status;
            $txnid = $payout->txn_id;
        } else {
            $response = Payout::get($payout->txn_id, $this->_api_context);
            $status = $response->batch_header->batch_status;
            $txnid = $response->items[0]->transaction_id;
        }
        $inv_cus = Invoice::first();
        return view('admindesk.seller.payment.print', compact('payout', 'inv_cus', 'txnid', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function payoutviaPaypal($findstore, $amount, $order, $defCurrency)
    {

        $sendemail = $findstore->paypal_email;
        $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();
        $uniqid = str_random(10);
        $payouts = new Payout();
        $inv_cus = Invoice::first();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");
        $senderItem = new PayoutItem();
        $senderItem->setRecipientType('Email')
            ->setNote('Thanks for using our portal for selling your product!')
            ->setReceiver($sendemail)
            ->setSenderItemId($uniqid)
            ->setAmount(new \PayPal\Api\Currency('{
                                "value":' . $amount . ',
                                "currency":"' . $defCurrency->currency->code . '"
                            }'));

        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);

        $request = clone $payouts;

        try {

            $output = $payouts->create(array('sync_mode' => 'false'), $this->_api_context);
            $bid = $output->batch_header->payout_batch_id;
            $response = Payout::get($bid, $this->_api_context);

            DB::beginTransaction();

            $newpayout = new SellerPayout();
            $newpayout->payoutid = str_random(6);
            $newpayout->orderid = $order->singleorder->id;
            $newpayout->sellerid = $order->sellerid;
            $newpayout->paidby = Auth::user()->id;
            $newpayout->paid_in = $response->batch_header->amount->currency;
            $newpayout->orderamount = $response->batch_header->amount->value;
            $newpayout->txn_fee = $response->batch_header->fees->value;
            $newpayout->txn_id = $response->batch_header->payout_batch_id;
            $newpayout->paidvia = 'Paypal';
            $newpayout->pending_payout_id = $order->id;
            $newpayout->save();

            DB::commit();

            $item = $inv_cus->prefix . $order->singleorder->inv_no . $inv_cus->postfix;
            $msg = "You Received a new Payout for Order Item #$item";
            $currency = $response->batch_header->amount->currency;
            $amount = $response->batch_header->amount->value;
            $url = route('vender.payout.show.complete', $newpayout->id);
            $type = 'paypal';

            if ($order->singleorder->order->payment_method == 'Wallet') {
                $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                $adminwalletlog = new OrderWalletLogs;
                $adminwalletlog->wallet_txn_id = $response->batch_header->payout_batch_id;
                $adminwalletlog->note = "Payout to seller for invoice no. #$item";
                $adminwalletlog->type = 'Debit';
                $adminwalletlog->amount = $response->batch_header->amount->value;
                $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $response->batch_header->amount->value : $response->batch_header->amount->value;

                $adminwalletlog->save();
            }

            

            $updateInvoice = InvoiceDownload::where('id', $order->singleorder->id)->update(['paid_to_seller' => 'YES']);

            /*Sending Notification*/
            $v = User::find($order->sellerid);

            if (isset($v)) {
                $v->notify(new SellerNotification($url, $msg));

                /*Sending Mail*/
                try {

                    if ($sendemail) {

                        Mail::to($sendemail)->send(new PayoutNotify($msg, $currency, $amount, $type));

                    } else {

                        Mail::to($v->email)->send(new PayoutNotify($msg, $currency, $amount, $type));

                    }

                } catch (\Swift_TransportException $e) {
                    //No Code
                }

            }

            //Remove pending payout entry if payout successfull //
            $order->delete();

            return redirect()->route('seller.payout.complete')->with('added', 'Payout for that order completed successfully !');

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            return back()->with('warning', $ex->getData());
            exit(1);

        }
    }

    public function payoutviaStripe()
    {
        notify()->info('Coming soon !');
        return back();
    }

}
