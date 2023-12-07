<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App;
use App\Models\LiveClass;

class InteractiveClassController extends Controller
{
    function create(Request $request,$id=null) {
        $meeting=new LiveClass();
        $model='';
        if ($request->isMethod('post')) {

            $data= $request->input();
            $data['duration']= $request->duration_hr.":".$request->duration_min;
            $data['start_time']= $request->start_time;
            $data['class_date']=date('Y-m-d',strtotime($data['class_date']));
            $data['meeting_id']=date('YmdHis').'C'.$data['add_class_id'].'S'.$data['school_subject_allocation_detail_id'];
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $password = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 10; $i++) {
                $n = rand(0, $alphaLength);
                $password[] = $alphabet[$n];
            }
            $data['password']=implode($password);
            unset($data['_token']);unset($data['duration_min']);
            unset($data['duration_hr']);
            $res=$meeting->saveData($data);
            return redirect('admin/liveClass/list')->with($res[0],$res[1]);
        }$model=[];
        if(!empty($id)){
            
            $model=$meeting->edit($id);
            $duration=explode(':',$model['duration']);
            $model['duration_hr']=trim($duration[0]);
            $model['duration_min']=trim($duration[1]);
            $model['class_date']=date('d-m-Y',strtotime( $model['class_date']));
        }
        return view('InteractiveClass/create')
            ->with([ 'model'=>$model,
                    'batch'=>$this->getBatches()

                ]
            );
    }
    function list(Request $request) {
        $res=LiveClass::with(['batch']) ->orderByDesc('id')->get()->toArray();
        return view('InteractiveClass/list')
            ->with([ 'meeting_list'=>$res]
            );
    }
    function liveClass(Request $request, $id=null) {
        $user_id=auth()->user()->id;
        $userName=auth()->user()->name;

        $res=App\Models\LiveClass::with('batch')
            ->where('id',$id)
            ->whereHas('batch',function($q) use($user_id){
                $q->whereRaw("find_in_set($user_id,user_id)");
            })->first();

        if(empty($res)){
            return redirect('liveClass');
        }
        $table=new App\Models\LiveClassAttendedUsers();
        $table->saveData([
            'user_id'=>$user_id,
            'live_class_id'=>$id,
            'login'=>date('Y-m-d H:i:s')
        ]);


        return view('InteractiveClass/goLive')->with(['meeting'=>$res,'url'=>'liveClass','userName'=>$userName]);
    }
    function adminGoLive(Request $request, $id=null){
        $res=LiveClass::with(['batch'])
            ->orderByDesc('start_time')
            ->where('id',$id)->first();

        if(empty($res)){
            return redirect('admin/liveClass/list');
        }

        $userName='Admin';
        $url='admin/liveClass/list';
        return view('InteractiveClass/goLive')
            ->with(['meeting'=>$res,'url'=>$url,'userName'=>$userName]);

    }
    function  attendedStudent(Request $request, $id){
        $res=App\Models\LiveClassAttendedUsers::with(['user'])->where('live_class_id',$id)->orderByDesc('id')->get()->toArray();

        return view('InteractiveClass/attended_stud')
            ->with([ 'stud_list'=>$res]);
    }
}