<?php
namespace App\Http\Controllers;

use App\Models\PaymentDetail;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;

use Google_Client;

use DB;

class HomeController extends Controller
{

    public function dynamicDelete(Request $request,$modal,$id){
        $image=$request->image;
        try{
            $model="App\\Models\\".$modal;
            $user=new $model();
            $row = $user->find( $id );
            $row->delete();

            if($image!='')
                @unlink(public_path().'/'.$image);

            return Redirect::back()->with('danger','Record Deleted Successfully');

        }catch (\Exception $e){
            $res="fail";
        }
        return Response()->json($res);
    }
    public function getNextChild(Request $request){

        $model="App\\Models\\".$request->model;
        $obj=new $model();
        $list=$obj->orderBy($request->display_field,'ASC')->get()->where($request->condition_field,$request->id)->toArray();


        return Response()->json($list);
    }


    public function ajaxOtp(Request $request){
        $users=new User();
        // $res=$users->deleteRecord(1);
        $user = $users->where('mobile', $request->mobile)->first();
        if(empty($user)){
            $generate_otp = rand(100000,999999);
            //$type='Dear Student, OTP is '.$generate_otp.' for Registration. Thank you GURIAS';
            $type='<#> GuruDev Registration/Forgot Password code is : '.$generate_otp.' '.'.';
            $result = $this->sendSmsGurudev($type, $request->mobile);
            $result = ['status'=>'success'];
            if($result['status']=='success'){
                return Response()->json(["success",$generate_otp]);
            }
            return Response()->json(["fail","Please Check Mobile Number"]);

        }else{
            return Response()->json(["fail","Mobile Number Exist"]);
        }

    }
    public function ajaxForgotPwdOtp(Request $request){
        $users=new User();
        // $res=$users->deleteRecord(1);
        $user = $users->where('mobile', $request->mobile)->first();
        if(!empty($user)){
            $generate_otp = rand(100000,999999);
            //$type='Dear Student, OTP is '.$generate_otp.' for reset-password. Thank you GURIAS';
            $type='<#> GuruDev Registration/Forgot Password code is : '.$generate_otp.' '.'.';
            $result = $this->sendSmsGurudev($type, $request->mobile);
            //$result = $this->sendSms($type, $generate_otp, $request->mobile);
            $result = ['status'=>'success'];
            if($result['status']=='success'){
                return Response()->json(["success",$generate_otp]);
            }
            return Response()->json(["fail","Please Check Mobile Number"]);

        }else{
            return Response()->json(["fail","Please Check Mobile Number"]);
        }

    }
    public function checkEmailAvailable(Request $request){
        $users=new User();
        // $res=$users->deleteRecord(1);
        $user = $users->where('email', $request->email)->first();
        if(!empty($user)){

            return Response()->json("exist");

        }else{
            return Response()->json("not exist");
        }

    }
    public function adminDashboard(Request $request){

        
        $totUsers=User::count();
        $totCourse=App\Models\Course::count();
        $totAmtCollect=App\Models\PaymentDetail::where('status','Success')->sum('amount');
        $currentAffairs=App\Models\CurrentAffair::count();

        // $list = DB::table('demos')->get();
        // foreach($list as $item){
        //     echo "('".$item->text."',0,0,NULL),";echo '<br/>';
        // }
        // dd($list);
        
        return view('Home/adminDashboard')
            ->with(['totUsers'=>$totUsers,'totCourse'=>$totCourse,'totAmtCollect'=>$totAmtCollect,'currentAffairs'=>$currentAffairs]);
    }
    public function generatePayment(Request $request)
    {
        $requestData=$request->except('_token');
        //if($request->type=='Chapter'){
            $requestData['user_id']=Auth::user()->id;
            $requestData['payment_date']=date('Y-m-d H:i:s',strtotime($requestData['payment_date']));
            $res = PaymentDetail::create($requestData);

        //}
        return Response()->json($res);
    }
        public function adminPasswordChange(Request $request)
    {

        $users = new Admin();
        if ($request->isMethod('post')) {
            $password_update = $users->where('id',Auth::guard('admin')->user()->id)
                ->update(['password' => $request->confirm_password]);
            if ($password_update) {
                return redirect('/admin/dashboard')->with("success","Password Changed Successfully");
            }
        }
        $users = $users->where(["id" =>Auth::guard('admin')->user()->id])->first();
        return view('Home/change_password', ["password" => $users['password']]);
    }






    function googleAuthenticationLogin(Request $request){
        //dd($request->input());
        $client = new Google_Client(['client_id' => '526100922535-mhsce1avcd4vi7cptoetd2gcndl317mp.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($request->credential);
          
        $user = User::where(['email' => $payload['email'],'status' =>'Active'])->first();
        
        if($user){
            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        }else{
            return redirect(RouteServiceProvider::LOGIN)->with([
               'error-code'=>5,
               'email' => $payload['email'].'-'.$payload['name'],
            ]);
        }
    }

}
