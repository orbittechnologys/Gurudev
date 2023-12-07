<?php
# Copy the code from below to that controller file located at app/Http/Controllers/RazorpayController.php
namespace App\Http\Controllers;

use App;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponser;
use App\Models\MarketingTeam;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayController extends Controller {

    use ApiResponser;
    public function generatePaymentOrder(Request $request) {
      
        $currentUrl = array_reverse(explode("/",$request->url()))[1];
       
          $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
          $RECEIPT_NO = array(); //remember to declare $pass as an array
          $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
          for ($i = 0; $i < 10; $i++) {
              $n = rand(0, $alphaLength);
              $RECEIPT_NO[] = $alphabet[$n];
          }
          $RECEIPT_NO = implode($RECEIPT_NO);
          $client = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
       
     
          $orderData = [
                    'receipt'  => $RECEIPT_NO,
                    'amount'   => ($request->input('amount') * 100), 
                    'currency' => 'INR'
                ];

               
        $razorpayOrder = $client->order->create($orderData);
        $data = $razorpayOrder->toArray();

        if($currentUrl == "api"){
            $data['email'] = Auth::user()->email;
            $data['mobile'] = Auth::user()->mobile;
            return $this->success($data);
        }else{
            return response()->json($data['id']);
        }
    }

  
    public function generatePayment(Request $request) {
        $currentUrl = array_reverse(explode("/",$request->url()))[1];
        $client=new Api(env('RAZORPAY_KEY_ID'),env('RAZORPAY_KEY_SECRET'));
      
        if($request->razorpay_signature == '' || $request->razorpay_order_id == '' ||  $request->razorpay_payment_id == '' ||  $request->order_id == ''){
            $error = 'Invalid Input Fields..';
        }else{
                try{
                    $attributes = array('razorpay_signature'  => $request->razorpay_signature,  'razorpay_payment_id'  =>  $request->razorpay_payment_id ,  'razorpay_order_id' => $request->razorpay_order_id);
                    $client->utility->verifyPaymentSignature($attributes);
                    $success = true;
                }
                catch(SignatureVerificationError $e)
                {
                    $success = false;
                    $error = 'Razorpay Error : ' . $e->getMessage();
                }

            if ($success) {
                $payment = $client->payment->fetch($request->razorpay_payment_id);
                $payment_date=date('Y-m-d H:i:s',$payment->created_at);
                $payment->amount=$payment->amount/100;
        
                if($payment->status=="captured"){
                    $payment->status="Success";
                }

                $data=[
                        'user_id' => Auth::user()->id,
                        'order_id' => $payment->order_id,
                        'type_id' => $request->course_id,
                        'payment_id'=>$payment->id,
                        'amount'=>$payment->amount,
                        'type'=>$request->type,
                        'status'=>$payment->status,
                        'payment_method'=>$payment->method,
                        'error_description'=>$payment->error_description,
                        'payment_date'=>$payment_date
                    ];

                $payment_detail=new PaymentDetail();
                $payment_detail=$payment_detail->create($data);
                $payment_detail->payment_date=date('d-M-Y h:i A',strtotime($payment_detail->payment_date));
            }else{
                $error = 'Signature Validation Failed..';
            }

        }
            if($error == ''){
                if($currentUrl == "api"){
                    return $this->success($payment_detail);
                }else{
                    return response()->json($payment_detail);
                }
            }else{
                if($currentUrl == "api"){
                    return $this->error($error,200);
                }else{
                    return response()->json($error);
                }
            }
       
    }

}
