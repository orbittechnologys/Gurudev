<?php

namespace App\Http\Controllers;
use App\Models\Batch;
use App\Models\Course;
use App\Models\ModuleDetail;
use App\Models\SpecialTestCourse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMainMenu()
    {
        $mainmenu = ModuleDetail::orderBy('position', 'ASC')
            ->pluck('module_name', 'id');
        return $mainmenu;
    }

    public function fileUpload($destinationPath, $file, $newFileName)
    {
        if ($file->getClientOriginalName() != '') {
            $newFileName = preg_replace("/[^a-zA-Z]/", "", $newFileName);
            $newFileName = $newFileName . rand(10, 100) . date('Y-m-d_H-i-s') . '.' . $file->getClientOriginalExtension();
           // $file->move('' . $destinationPath, $newFileName);
           $s3 = Storage::disk('azure'); 
           //$path = 'Uploads/'.$newFileName;
           //dd($destinationPath);
          $res= $s3->put($destinationPath . '/' . $newFileName,file_get_contents($file),'public');
          //dd($res);
            return $destinationPath . '/' . $newFileName;
        }
    }

    public function getCourse($courseType=null)
    {
        return Course::where(function($q) use($courseType){
            if($courseType!='')
                $q->where('course_type',$courseType);
        })->orderBy('course', 'asc')->pluck('course', 'id');
    }

    public function getQuizTime()
    {
        // $time = [
        //     '00:15' => '00:15', '00:30' => '00:30', '00:45' => '00:45', '01:00' => '01:00',
        //     '01:15' => '01:15', '01:30' => '01:30', '01:45' => '01:45', '02:00' => '02:00',
        //     '02:15' => '02:15', '02:30' => '02:30', '02:45' => '02:45', '03:00' => '03:00',
        //     '03:15' => '03:15', '03:30' => '03:30', '03:45' => '03:45', '04:00' => '04:00'];
        //added change
        $time = [
            '00:05' => '00:05', '00:10' => '00:10', '00:15' => '00:15', '00:20' => '00:20',
            '00:25' => '00:25', '00:30' => '00:30', '00:35' => '00:35', '00:40' => '00:40',
            '00:45' => '00:45', '00:50' => '00:50', '00:55' => '00:55', '01:00' => '01:00',
            '01:05' => '01:05', '01:10' => '01:10', '01:15' => '01:15', '01:20' => '01:20',
            '01:25' => '01:25', '01:30' => '01:30', '01:35' => '01:35', '01:40' => '01:40',
            '01:45' => '01:45', '01:50' => '01:50', '01:55' => '01:55', '02:00' => '02:00',
            '02:05' => '02:05', '02:10' => '02:10', '02:15' => '02:15', '02:20' => '02:20',
            '02:25' => '02:25', '02:30' => '02:30', '02:35' => '02:35', '02:40' => '02:40',
            '02:45' => '02:45', '02:50' => '02:50', '02:55' => '02:55', '03:00' => '03:00',
            '03:05' => '03:05', '03:10' => '03:10', '03:15' => '03:15', '03:20' => '03:20',
            '03:25' => '03:25', '03:30' => '03:30', '03:35' => '03:35', '03:40' => '03:40',
            '03:45' => '03:45', '03:50' => '03:50', '03:55' => '03:55', '04:00' => '04:00'
        ];
        return $time;
    }

    public function getTags()
    {
        return Course::orderBy('course', 'asc')->pluck('course', 'id');
    }

    public function sendSms($type, $messageBody, $mbl_no)
    {

        $message = "Dear Students, For your information " . $type . ' ' . $messageBody . " Thank You.";
        $numbers = "91" . $mbl_no;
        //$numbers = array($numbers);
        // Prepare data for POST request

        $data = array('username' => env('TEXT_LOCAL_USER'), 'hash' => env('TEXT_LOCAL_HASH'), 'numbers' => $numbers, "sender" => env('TEXT_LOCAL_SENDER'), "message" => $message);
        //dd($data);
        // Send the POST request with cURL
        $ch = curl_init('http://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        return $sms_status = json_decode($response, true);

    }
     public function sendSmsGurudev($message, $mbl_no)
    {
        
        $numbers = "91" . $mbl_no;
        //$numbers = array($numbers);
        // Prepare data for POST request

        $data = array('username' => env('TEXT_LOCAL_GUR_USER'), 'hash' => env('TEXT_LOCAL_GUR_HASH'), 'numbers' => $numbers, "sender" => env('TEXT_LOCAL_GUR_SENDER'), "message" => $message);
        //dd($data);
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // Process your response here
        return $sms_status = json_decode($response, true);

    }
    function getTypes(){
        return ['Mock Test','MCQ','Special Test'];
    }

    public function getSpecialTestCourses()
    {
        return SpecialTestCourse::orderBy('course', 'asc')->pluck('course', 'id');
    }
    public function getBatches(){
        return Batch::orderBy('batch', 'asc')->pluck('batch', 'id');
    }
}
