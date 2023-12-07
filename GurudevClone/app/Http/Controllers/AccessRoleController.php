<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ModuleDetail;
use App\Models\SubModule;
use App\Models\UserRole;
use App\Models\UserRoleDetail;
use App\Models\Designation;
use DB;
use Input;
use File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class AccessRoleController extends Controller{
    public function mainMenu(Request $request ,$id = null)
    {
        $table = new ModuleDetail();
        $requestData = $request->except(['_token']);
        if ($request->isMethod('post'))
        {
            $chk_mm = $table->where("module_name",$requestData['module_name'])->where("id","!=",$requestData['id'])->exists();
            if(empty($chk_mm))
            {
                if($requestData['id']=='') {
                    $res = $table->saveData($requestData);
                    return redirect('/accessRole/mainMenu')->with($res[0], $res[1]);
                }
                else{
                    $table->where(["id"=>$requestData['id']])->Update($requestData);
                    return redirect('/accessRole/mainMenu')->with('success','Main Menu Updated Successfully');
                }
            }
            else
            {
                return redirect('/accessRole/mainMenu')->with('warning','Existing Record');
            }
        }
        $getmm_data = $table->get();
        if($id != '')
        {
            $getmm_edata = $table->where('id',$id)->first();
            return view('AccessRole/main_menu',['getmm_data'=>$getmm_data,'getmm_edata'=>$getmm_edata]);
        }
        else
        {
            return view('AccessRole/main_menu',['getmm_data'=>$getmm_data]);
        }
    }

    public function mainMenuDelete($id = null){
        $table = new ModuleDetail();
        $table->where(["id"=>$id])->delete();
        return redirect('/accessRole/mainMenu')->with('danger','Main Menu Deleted Successfully');
    }
    public function subMenu(Request $request , $id =null){
        $table = new SubModule();
        $requestData = $request->except(['_token']);
        if ($request->isMethod('post'))
        {
            $chk_sm = $table->where("sub_module_name",$requestData['sub_module_name'])->where("module_detail_id",$requestData['module_detail_id'])->where("id","!=",$requestData['id'])->exists();
            if(empty($chk_sm))
            {
                if($requestData['level']=='Level1')
                {
                    $requestData['under'] = '';
                }
                if($requestData['id']=='')
                {
                    $res = $table->saveData($requestData);
                    return redirect('/accessRole/subMenu')->with($res[0],$res[1]);
                }
                else
                {
                    $table->where(["id"=>$requestData['id']])->Update($requestData);
                    return redirect('/accessRole/subMenu')->with('success','Sub Menu Updated Successfully');
                }
            }
            else
            {
                return redirect('/accessRole/subMenu')->with('warning','Existing Record');
            }
        }
        $get_sm = $table::with(['MainMenu','SubMenuUnder'])->orderBy('id','DESC')->get();
        // print_r($get_sm);
        if($id == '')
        {
            return view('AccessRole/sub_menu',['mainmenu'=>$this->getMainMenu(),'get_sm'=>$get_sm]);
        }
        else
        {
            $get_sme = $table->find($id);
            return view('AccessRole/sub_menu',['mainmenu'=>$this->getMainMenu(),'get_sm'=>$get_sm,'get_sme'=>$get_sme]);
        }
    }
    public function subMenuDelete($id = null){
        $table = new SubModule();
        $table->where(["id"=>$id])->delete();
        return redirect('/accessRole/subMenu')->with('danger','Sub Menu Deleted Successfully');
    }
    public function userRole (Request $request,$id=null)
    {
        if ($request->isMethod('post')) {
            $requestData=$request->input();

            $secondData=[];
            $ids = explode(",", $requestData['rowIds']);
            $resDelete=UserRole::whereIn('id',$ids)->delete();
            $resDelete=UserRoleDetail::whereIn('user_role_id',$ids)->delete();

           // dd($resDelete);
            foreach ($requestData['module_details'] as $key=>$arr){
                $firstData=[];

                $firstData['staff_id']=$requestData['staff_id'];
                $firstData['module_detail_id']=$key;
                //dd($arr);
               $id=UserRole::create($firstData)->id;

                foreach ($arr as $key2=>$submodule) {
                    $secondData[$key2]['user_role_id'] = $id;
                    $secondData[$key2]['sub_module_id'] = $key2;

                    $secondData[$key2]['action_add']=($submodule['action_add']=="on")?1:0;
                    $secondData[$key2]['action_edit']=($submodule['action_edit']=="on")?1:0;
                    $secondData[$key2]['action_delete']=($submodule['action_delete']=="on")?1:0;

                }

            }
            $res=UserRoleDetail::insert($secondData);
            if($res){
                return redirect('accessRole/userRole')->with('success', "Role Assigned Successfully");
            }



        }
        $admins=Admin::orderBy('id', 'asc')->pluck('name', 'id');;
        $result=ModuleDetail::with(['subModule'=>function ($q){
            $q->where('is_default',0);
        }])
            ->where('status','Active')
            ->orderBy('module_name')->get()->toArray();
        $finalArray=[];
        $mainMenu=[];
        $userRoleDetail=optional(UserRoleDetail::with('userRole')->whereHas('userRole',function ($q)use($id){
            $q->where('staff_id',$id);
        })->get())->toArray();

        foreach ($result as $module){

            if(sizeof($module['sub_module'])>0)
                $mainMenu[$module['id']]=$module['module_name'];
            foreach ($module['sub_module'] as $subModule){
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['name']=$subModule['sub_module_name'];
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['add']=0;
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['edit']=0;
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['delete']=0;
            }

        }
        $rowIds=[];
        foreach ($userRoleDetail as $details){
            $rowIds[$details['user_role']['id']]=$details['user_role']['id'];
            $finalArray[$details['user_role']['module_detail_id']]['sub_module'][$details['sub_module_id']]['add']=$details['action_add'];
            $finalArray[$details['user_role']['module_detail_id']]['sub_module'][$details['sub_module_id']]['edit']=$details['action_edit'];
            $finalArray[$details['user_role']['module_detail_id']]['sub_module'][$details['sub_module_id']]['delete']=$details['action_delete'];

        }
        //dd($finalArray);
        $rowIds=implode(',',$rowIds);

        return view('AccessRole/user_role')->with(['rowIds'=>$rowIds,'admins'=>$admins,'staff_id'=>$id,'mainMenu'=>$mainMenu,'finalArray'=>$finalArray]);
    }
    public function userRoleBulk (Request $request,$deptId=null,$id=null)
    {
        if ($request->isMethod('post')) {
            $requestData=$request->input();


            // dd($requestData);
            $staff_id=explode(",",$requestData['staff_id']);
            foreach ($staff_id as $staff) {
                if ($staff != '') {
                    $secondData = [];
                    foreach ($requestData['module_details'] as $key => $arr) {
                        $firstData = [];

                        $firstData['staff_id'] = $staff;
                        $firstData['module_detail_id'] = $key;
                        //dd($arr);
                        $id = UserRole::create($firstData)->id;

                        foreach ($arr as $key2 => $submodule) {
                            $secondData[$key2]['user_role_id'] = $id;
                            $secondData[$key2]['sub_module_id'] = $key2;

                            $secondData[$key2]['action_add'] = ($submodule['action_add'] == "on") ? 1 : 0;
                            $secondData[$key2]['action_edit'] = ($submodule['action_edit'] == "on") ? 1 : 0;
                            $secondData[$key2]['action_delete'] = ($submodule['action_delete'] == "on") ? 1 : 0;

                        }

                    }
                    $res = UserRoleDetail::insert($secondData);
                }
            }
            if($res){
                return redirect('accessRole/userRole')->with('success', "Role Assigned Successfully");
            }



        }
        $dept=$this->getAllDepartment();
        $desg=$this->getDesignation();
        $result=ModuleDetail::with(['subModule'=>function ($q){
            $q->where('is_default',0);
        }])
            ->where('status','Active')
            ->orderBy('module_name')->get()->toArray();
        $finalArray=[];
        $mainMenu=[];


        foreach ($result as $module){

            if(sizeof($module['sub_module'])>0)
                $mainMenu[$module['id']]=$module['module_name'];
            foreach ($module['sub_module'] as $subModule){
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['name']=$subModule['sub_module_name'];
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['add']=0;
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['edit']=0;
                $finalArray[$module['id']]['sub_module'][$subModule['id']]['delete']=0;
            }

        }
        $rowIds=[];
        //dd($finalArray);
        $rowIds=implode(',',$rowIds);

        return view('AccessRole/user_role_bulk')->with(['rowIds'=>$rowIds,'dept'=>$dept,'desg'=>$desg,'staff_id'=>$id,'mainMenu'=>$mainMenu,'finalArray'=>$finalArray]);
    }
}
