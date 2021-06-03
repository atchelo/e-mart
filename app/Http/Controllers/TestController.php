<?php

namespace App\Http\Controllers;

use App\Category;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Image;
use PaytmWallet;
use Session;

/** Development Purpose Only ONLY DEVELOEPER SEE WHATS GOING ON HERE */
/** IF YOU ARE DEVELOPER DO SOME FUN HERE */

class TestController extends Controller
{
    public $api_user = "sb-tlvyu24541_api1.business.example.com";
    public $api_pass = "NXWTEVM4MFSY4QTY";
    public $api_sig = "AfjCiReQHjxgQ75D20ymyCratYHDA4HmJVm1.isRpy9HWPKzAIOdWMor";
    public $app_id = "APP-80W284485P519543T";
    public $apiUrl = 'https://svcs.sandbox.paypal.com/AdaptivePayments/';
    public $paypalUrl = "https://www.sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=";
    public $headers;

    public function sendalexpayment(Request $request){

        

        $image_path = $request->attachment->getPathname();
        // $image_mime = $request->attachment->getmimeType('image');
        $image_org  = $request->attachment->getClientOriginalName();

        $photo = fopen( $image_path, 'r' );
        
        $pay_data = [
            'amount' => $request->amount,
            'quantity' => $request->quantity,
            'type' => $request->type,
            'pay_method' => $request->pay_method,
            'reference' => $request->reference
        ];

        $photo = fopen($image_path, 'r');

        $response = Http::attach(
            'attachment', $photo, $image_org
        )->post('http://aludashboard.co.bw/api/customer/payment-save',[
            'username' => $request->username,
            'pay_data' => json_encode($pay_data)
        ]);

        return $response->json();

    }

    public function __construct()
    {
        $this->headers = array(
            "X-PAYPAL-SECURITY-USERID: " . $this->api_user,
            "X-PAYPAL-SECURITY-PASSWORD: " . $this->api_pass,
            "X-PAYPAL-SECURITY-SIGNATURE: " . $this->api_sig,
            "X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
            "X-PAYPAL-RESPONSE-DATA-FORMAT: JSON",
            "X-PAYPAL-APPLICATION-ID: " . $this->app_id,
        );

        $this->envelope = array(
            "errorLanguage" => "en_US",
            "detailLevel" => "ReturnAll",
        );
    }

    public function test()
    {
        
        
       
    }

    public function transTest()
    {
        $l = Session::get('changed_language');
        $r = 'Fashion';
        $x = Category::whereRaw(\DB::raw("JSON_EXTRACT(title, '$.$l') = '$r'"))->first();
        return $x->title;
    }

    public function helloworld(Request $request)
    {

        $image = $request->file('image');
        $input['image'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/test');
        $img = Image::make($image->getRealPath());

        $img->save($destinationPath . '/' . $input['image'], 80, 'jpg');

        $destinationPath = public_path('/test');
        $image->move($destinationPath, $input['image']);
        return $img->response('jpg', 70);
        return 'Uploaded';
    }

    public function sendotp()
    {

        $curl = curl_init();

        $username = 'thegr8dev';
        $password = 'zan7yGdz';
        $senderId = 'SMSGAT';
        $sendMethod = 'generate';
        $msgType = 'text';
        $mobile = '918239206952'; //on this no. otp will be sent

        //Msg must have $otp$ value inside it.
        $msg = 'Your Otp code is $otp$ and valid for 1 minute only - ' . config('app.name');
        $codeExpiry = 60; //code expire after given seconds | max 1800 @nkit
        $codeLength = 4; //otp code length | max 10
        $codeType = 'num';
        $retryExpiry = 60; //return after given seconds | max 1800
        $renew = false; //regenreate otp and txn token
        $medium = 'sms'; //sms | email

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.smsgateway.center/OTPApi/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userId=$username&password=$password&senderId=$senderId&sendMethod=$sendMethod&msgType=$msgType&mobile=$mobile&msg=$msg&codeExpiry=$codeExpiry&codeLength=$codeLength&codeType=$codeType&retryExpiry=$retryExpiry&renew=$renew&medium=$medium&format=json",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Cookie: SERVERID=webC1",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        if ($response['statusCode'] == 900) {
            //do whatever you want
        } else {
            return $response['reason'];
        }
    }

    public function verify(Request $request)
    {

        $curl = curl_init();

        $username = 'thegr8dev';
        $password = 'zan7yGdz';
        $senderId = 'SMSGAT';
        $sendMethod = 'verify';
        $msgType = 'text';
        $mobile = '918239206952'; //on this no. otp will be sent
        $otp = $request->otp;
        $callback = 'http%3A%2F%2Fwww.example.com%2FgetOTPResponse.php'; //optional

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://enterprise.smsgatewaycenter.com/OTPApi/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false),
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userId=$username&password=$password&mobile=$mobile&otp=1234&sendMethod=$sendMethod&callback=$callback&format=json",
            CURLOPT_HTTPHEADER => array(
                "Cookie: SERVERID=webC1",
                "Content-Type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response['statusCode'] == 900) {
            //do whatever you want
        } else {
            return $response['reason'];
        }
    }

    public function getPaymentOptions($payKey)
    {

        $packet = array(
            "requestEnvelope" => $this->envelope,
            "payKey" => $payKey,
        );

        $res = $this->_paypalSend($packet, "GetPaymentOptions");

        return $res;
    }

    public function setPaymentOptions()
    {
    }

    public function _paypalSend($data, $call)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $call);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        $response = json_decode(curl_exec($ch), true);

        return $response;
    }

    public function splitPay()
    {

        $returnurl = url('admindesk/completed/payouts');

        // create the pay request
        $createPacket = array(
            "actionType" => "PAY",
            "currencyCode" => "USD",
            "receiverList" => array(
                "receiver" => array(
                    array(
                        "amount" => "1.00",
                        "email" => "ankitswonders@gmail.com",
                    ),
                ),
            ),
            "returnUrl" => "$returnurl",
            "cancelUrl" => "http://test.local/payments/cancel",
            "requestEnvelope" => $this->envelope,
        );

        $response = $this->_paypalSend($createPacket, "Pay");
        $payKey = $response['payKey'];

        //Set Payment Detail
        $detailsPacket = array(

            "requestEnvelope" => $this->envelope,

            "payKey" => $payKey,
            "receiverOptions" => array(
                "receiver" => array("email" => "ankitswonders@gmail.com"),
                "invoiceData" => array(
                    "item" => array(
                        array(
                            "name" => 'product 1',
                            "price" => '1.00',
                            "identifier" => 'p1',
                        ),
                    ),
                ),
            ),

        );

        $response = $this->_paypalSend($detailsPacket, "SetPaymentOptions");

        $dets = $this->getPaymentOptions($payKey);

        //head over to paypal
        return redirect($this->paypalUrl . $payKey);
    }

    public function stripe()
    {

        $stripe = Stripe::make(env('STRIPE_SECRET'));

        $charge = $stripe->charges()->create([
            "amount" => 10,
            "currency" => "usd",
            "source" => "tok_visa",
            "transfer_data" => [
                "destination" => "ac_123456789",
            ],
        ]);

        return $charge;
    }

    public function paytm()
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => '587456',
            'user' => '1',
            'mobile_number' => '7777777777',
            'email' => 'test@demo.com',
            'amount' => 100,
            'callback_url' => url('/paytm-callback'),
        ]);
        return $payment->receive();
    }

    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm

        if ($transaction->isSuccessful()) {
            //Transaction Successful
        } else if ($transaction->isFailed()) {
            //Transaction Failed
        } else if ($transaction->isOpen()) {
            //Transaction Open/Processing
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id

        dd($response);
    }
}
