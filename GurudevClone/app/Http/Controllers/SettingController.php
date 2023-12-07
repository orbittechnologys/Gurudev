<?php

namespace App\Http\Controllers;


use App\Models\Chapter;
use App\Models\CollectionDetail;
use App\Models\Course;
use App\Models\CurrentAffair;
use App\Models\Material;
use App\Models\PaymentDetail;
use App\Models\SmsDetail;
use App\Models\SpecialTestCourse;
use App\Models\Subject;
use App\Models\SpecialTestSubCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App;
use Illuminate\Support\Facades\Mail;
use App\Models\WeeklyBuzz;
use App\Models\YoutubeVideo;
use App\Models\SmsTemplate;
use App\Models\WeeklyBuzzFolder;
use Illuminate\Support\Facades\Storage;
class SettingController extends Controller
{

    public function course(Request $request, $id = null)
    {

        $table = new Course();
        if ($request->isMethod('post')) {
            /****************************************** Course Icon ******************************************************/
            
            $file = $request->file('image');
          
            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    @unlink(public_path() . '/Uploads/Course/' . $request['course_icon']);
                }
                $newFileName = $request->input('course') . '_Icon_';
                $newFileName = $this->fileUpload('Uploads/Course', $file, $newFileName);
                $request['course_icon'] = $newFileName;
            }

            /****************************************** Mentor Profile Pic ******************************************************/
            $file = $request->file('mentor_profile');
            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    @unlink(public_path() . '/Uploads/MentorProfile/' . $request['mentor_profile_pic']);
                }
                $newFileName = $request->input('mentor_name') . '_pic_';
                $newFileName = $this->fileUpload('Uploads/MentorProfile', $file, $newFileName);
                $request['mentor_profile_pic'] = $newFileName;
            }

            /****************************************** Time Table File ******************************************************/
            $file = $request->file('timetable');

            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    @unlink(public_path() . '/Uploads/CourseMaterial' . $request['timetable_file']);
                }
                $newFileName = 'timetable-';
                $newFileName = $this->fileUpload('Uploads/CourseMaterial', $file, $newFileName);
                $request['timetable_file'] = $newFileName;
            }

            /****************************************** Background Image ******************************************************/
            $file = $request->file('background');
            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    @unlink(public_path() . '/Uploads/Course/Background/' . $request['background_image']);
                }
                $newFileName = 'background-';
                $newFileName = $this->fileUpload('Uploads/Course/Background', $file, $newFileName);
                $request['background_image'] = $newFileName;
            }


            $request['batch_start'] = date('Y-m-d', strtotime($request->input('batch_start')));
            $request['batch_end'] = date('Y-m-d', strtotime($request->input('batch_end')));

            $res = $table->savedata($request->except(['_token', 'image', 'mentor_profile', 'timetable', 'background']));

            return redirect('/course_details')->with($res[0], $res[1]);
        }

        $table_list = $table->orderByRaw('id DESC')->get()->toArray();
        $course =[];
        if (!empty($id))
            $course = $table->edit($id);


        return view('Setting/course')
            ->with('table_list', $table_list)
            ->with('model', $course)
            ->with('position', $this->getPosition())
            ->with('courseType', $this->getCourseType());
    }

    /*---------------------------------- Current Affairs Add ---------------------------------------------------------*/
    public function currentAffairs(Request $request, $id = null)
    {
        $table = new CurrentAffair();
        if ($request->isMethod('post')) {
            $file = $request->file('new_image');


            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {

                    @unlink(public_path() . '/' . $request['image']);
                }
                $newFileName = substr(trim($request->input('title')), 0, 8);
                $newFileName = $this->fileUpload('Uploads/CurrentAffair', $file, $newFileName);
                $request['image'] = $newFileName;
            }

            $request['date'] = date('Y-m-d', strtotime($request->input('date')));

            $res = $table->saveData($request->except(['_token', 'new_image']));
            return redirect('/admin/currentAffairs/list')->with($res[0], $res[1]);
        }
        $current_affair = [];
        if (!empty($id)) {
            $current_affair = $table->edit($id);
        }
        $table_list = $table
            ->orderByRaw('id DESC')
            ->paginate(10)->toArray();

        return view('Setting/adminCurrentAffairs')
            ->with('table_list', $table_list)
            ->with('model', $current_affair);
    }

    function currentAffairsList(Request $request)
    {
        if ($request->isMethod('post')) {
            $table = new CurrentAffair();
            $status = $request->formType;
            if ($status == 'Delete') {
                $row = $table->find($request->id);
                @unlink(public_path() . '/' . $row->image);
                $row->delete();
                return response()->json("success");
            }

            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input();
            $table_res = $table::orderBy('id', 'DESC')
                ->where(function ($q) use ($requestData) {

                    for ($i = 0; $i < sizeof($requestData['columns']); $i++) {

                        $searchValue = $requestData['columns'][$i]['search']['value'];
                        if ($searchValue != '' && $i == 2) {
                            $q->where('title', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 3) {
                            $date = date('Y-m-d', strtotime($searchValue));
                            $q->where('date', $date);
                        }
                        if ($searchValue != '' && $i == 4) {
                            $q->where('source', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 5) {
                            $q->where('tags', 'Like', "%" . $searchValue . "%");
                        }

                    }
                });
            $table_res = $table_res->paginate($request['length'])->toArray();
            $table_list = [];
            $i = $request['start'];

            foreach ($table_res['data'] as $key => $list) {
                $src = asset($list['image']);
                $table_list[] = [++$i,
                    $list['id'],
                    $list['title'],
                    $list['date'],
                    $list['source'],
                    $list['tags'],
                   strip_tags($list['description']),
                    $list['image'],

                ];
            }

            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
        return view('Setting/adminCurrentAffairsList');
    }

    /*---------------------------------- Announcements Add ---------------------------------------------------------*/
    public function adminAnnouncements(Request $request, $id = null)
    { 
        $table = new App\Models\Announcement();
        if ($request->isMethod('post')) {
            $request['date'] = date('Y-m-d', strtotime($request->input('date')));

            $file = $request->file('new_image');
            if ($file != '' && $file->getClientOriginalName() != '') {
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    @unlink(public_path() . '/' . $request['old_image']);
                }
                $newFileName = substr(trim($request['title']), 0, 8);
                $newFileName = $this->fileUpload('Uploads/Announcement', $file, $newFileName);
                $request['attachment'] = $newFileName;
            }
            $file = $request->file('new_pdf');
            if ($file != '' && $file->getClientOriginalName() != '') {
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    @unlink(public_path() . '/' . $request['old_pdf']);
                }
                $newFileName = substr(trim($request['title']), 0, 8);
                $newFileName = $this->fileUpload('Uploads/Announcement', $file, $newFileName);
                $request['pdf'] = $newFileName;
            }

            $res = $table->saveData($request->except(['_token', 'new_image','old_image','new_pdf','old_pdf']));
            return redirect('/admin/announcements')->with($res[0], $res[1]);
        }
        $model = [];
        if (!empty($id)) {
            $model = $table->edit($id);
            $model['date'] = date('d-m-Y', strtotime($model['date']));
        }
        $table_list = $table
            ->orderByRaw('id DESC')
            ->paginate(10)->toArray();

        return view('Setting/adminAnnouncements')
            ->with('table_list', $table_list)
            ->with('model', $model);
    }

    /*---------------------------------- Course Add ---------------------------------------------------------*/
    public function adminCourse(Request $request, $id = null)
    {
        $table = new Course();
        //phpinfo();
        if ($request->isMethod('post')) {
            $file = $request->file('new_image');
            
            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                   // @unlink(public_path() . '/' . $request['image']);
                    Storage::disk('azure')->delete($request['background_image']);
                }
                
                $newFileName = 'CourseBG_' . substr(trim($request->input('course')), 0, 8);
                $newFileName = $this->fileUpload('Uploads/Course', $file, $newFileName);
                $request['background_image'] = $newFileName;
            }
            $res = $table->saveData($request->except(['_token', 'new_image']));
            return redirect('/admin/course/list')->with($res[0], $res[1]);
        }
        $model = [];
        if (!empty($id)) {
            $model = $table->edit($id);

        }
        $table_list = $table
            ->orderByRaw('id DESC')
            ->paginate(10)->toArray();

        return view('Setting/adminCourse')
            ->with('table_list', $table_list)
            ->with('model', $model);
    }

    function adminCourseList(Request $request)
    {
        if ($request->isMethod('post')) {
            $table = new Course();
            $status = $request->formType;
            if ($status == 'Delete') {
                $row = $table->find($request->id);
                //@unlink(public_path() . '/' . $row->image);
               // dd($row->background_image);
                Storage::disk('azure')->delete($row->background_image);
                $row->delete();
                return response()->json("success");
            }
            if ($status == 'Status') {
                $row = $table->where('id', $request->id)->update(['status' => $request->status]);
                return response()->json("success");
            }


            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input();
            $table_res = $table::orderBy('id', 'DESC')
                ->where(function ($q) use ($requestData) {

                    for ($i = 0; $i < sizeof($requestData['columns']); $i++) {

                        $searchValue = $requestData['columns'][$i]['search']['value'];
                        if ($searchValue != '' && $i == 3) {
                            $q->where('course', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 4) {
                            $q->where('course_type', $searchValue);
                        }


                    }
                });
            $table_res = $table_res->paginate($request['length'])->toArray();
            $table_list = [];
            $i = $request['start'];

            foreach ($table_res['data'] as $key => $list) {
                $src = asset($list['image']);
                $table_list[] = [++$i,
                    $list['id'],
                    $list['status'], $list['course'],
                    $list['course_type'],
                    $list['amount'],
                    $list['discount'],
                    $list['final_amount'],
                    $list['description'],
                ];
            }
            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
        return view('Setting/adminCourseList');
    }

    /*---------------------------------- Subject Add ---------------------------------------------------------*/
    public function adminSubject(Request $request, $id = null)
    {
        $table = new Subject();
        if ($request->isMethod('post')) {
            $res = $table->saveData($request->except(['_token']));
            return redirect('/admin/subject/list')->with($res[0], $res[1]);
        }
        $model = [];
        if (!empty($id)) {
            $model = $table->edit($id);
        }
        $table_list = $table
            ->orderByRaw('id DESC')
            ->paginate(10)->toArray();

        return view('Setting/adminSubject')
            ->with('table_list', $table_list)
            ->with('course', $this->getCourse())
            ->with('model', $model);
    }

    function adminSubjectList(Request $request)
    {
        if ($request->isMethod('post')) {
            $table = new Subject();
            $status = $request->formType;
            if ($status == 'Delete') {
                $row = $table->find($request->id);
                //@unlink(public_path() . '/' . $row->image);
                $row->delete();
                return response()->json("success");
            }
            if ($status == 'Status') {
                $row = $table->where('id', $request->id)->update(['status' => $request->status]);
                return response()->json("success");
            }
            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input(); 
            $table_res = $table::with('course')->wherehas('course')->orderBy('id', 'DESC')
                ->where(function ($q) use ($requestData) {

                    for ($i = 0; $i < sizeof($requestData['columns']); $i++) {

                        $searchValue = $requestData['columns'][$i]['search']['value'];
                        if ($searchValue != '' && $i == 4) {
                            $q->where('subject', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 3) {
                            $q->where('course_id', $searchValue);
                        }
                        if ($searchValue != '' && $i == 5) {
                            $q->where('type', $searchValue);
                        }


                    }
                });
            $table_res = $table_res->paginate($request['length'])->toArray();
            $table_list = [];
            $i = $request['start'];

            foreach ($table_res['data'] as $key => $list) {
                $table_list[] = [++$i,
                    $list['id'],
                    $list['status'],
                    $list['course']['course'], $list['subject'],
                    $list['type'],
                    $list['amount'],
                ];
            }
            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
        return view('Setting/adminSubjectList')->with('course', $this->getCourse());
    }

    /*---------------------------------- Chapter Add ---------------------------------------------------------*/
    public function adminChapter(Request $request, $id = null)
    {
        $table = new Chapter();
        if ($request->isMethod('post')) {
            $request['date'] = date('Y-m-d', strtotime($request->date));
            $file = $request->file('new_material');
            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                  //  @unlink(public_path() . '/' . $request['material']);
                    Storage::disk('azure')->delete($request['material']);
                }
                $newFileName = 'Materials_' . substr(trim($request->input('chapter')), 0, 8);
                $newFileName = $this->fileUpload('Uploads/Course', $file, $newFileName);
                $request['material'] = $newFileName;
            }
           
            $res = $table->saveData($request->except(['_token', 'video_link', 'new_material']));
            return redirect('/admin/chapter/list')->with($res[0], $res[1]);
        }
        $model = [];
        if (!empty($id)) {
            $model = $table->edit($id);
        }
        $table_list = $table
            ->orderByRaw('id DESC')
            ->paginate(10)->toArray();
        return view('Setting/adminChapters')
            ->with('table_list', $table_list)
            ->with('course', $this->getCourse())
            ->with('model', $model);
    }

    function adminChapterList(Request $request)
    {
        if ($request->isMethod('post')) {
            $table = new Chapter();
            $status = $request->formType;
            if ($status == 'Delete') {
                $row = $table->find($request->id);
                Storage::disk('azure')->delete($row->material);
                $row->delete();
                return response()->json("success");
            }
            if ($status == 'Status') {
                $row = $table->where('id', $request->id)->update(['status' => $request->status]);
                return response()->json("success");
            }
            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input();
            $table_res = $table::with(['course', 'subject'])->wherehas('course')->wherehas('subject')->orderBy('id', 'DESC')
                ->where(function ($q) use ($requestData) {

                    for ($i = 0; $i < sizeof($requestData['columns']); $i++) {
                        $searchValue = $requestData['columns'][$i]['search']['value'];
                        if ($searchValue != '' && $i == 5) {
                            $q->where('chapter', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 3) {
                            $q->where('course_id', $searchValue);
                        }
                        if ($searchValue != '' && $i == 4) {
                            $q->where('subject_id', $searchValue);
                        }
                        if ($searchValue != '' && $i == 6) {
                            $q->where('type', $searchValue);
                        }
                    }
                });
            $table_res = $table_res->paginate($request['length'])->toArray();
            $table_list = [];
            $i = $request['start'];

            foreach ($table_res['data'] as $key => $list) {
                $table_list[] = [++$i,
                    $list['id'],
                    $list['status'],
                    $list['course']['course'],
                    $list['subject']['subject'],
                    $list['chapter'],
                    $list['type'],
                    $list['date'],
                    $list['amount'],
                    $list['material'],
                    $list['video_material'],

                ];
            }
            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
        return view('Setting/adminChapterList')->with('course', $this->getCourse());
    }

    /*---------------------------------- Current Affairs Add ---------------------------------------------------------*/
    public function material(Request $request)
    {
        $table = new Material();
        if ($request->isMethod('post')) {

            $file = $request->file('new_material');
            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {

                    Storage::disk('azure')->delete($request['material']);
                }
                $newFileName = substr(trim($request->input('title')), 0, 8);
                $newFileName = $this->fileUpload('Uploads/Material', $file, $newFileName);
                $request['material'] = $newFileName;
            } else if (strpos($request->input('video_link'), '/') !== false) {
                $filepath = explode('/', $request->input('video_link'));
                $request['material'] = 'Uploads/Material/' . $filepath[sizeof($filepath) - 1];
            }

            $new_thumbnail = $request->file('new_thumbnail');


            if ($new_thumbnail != '' && $new_thumbnail->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($new_thumbnail->getClientOriginalName() != '')) {

                    @unlink(public_path() . '/' . $request['thumbnail']);
                }
                $newFileName = substr(trim('thumbnail_' . $request->input('title')), 0, 8);
                $newFileName = $this->fileUpload('Uploads/Material', $new_thumbnail, $newFileName);
                $request['thumbnail'] = $newFileName;
            }

            $request['date'] = date('Y-m-d', strtotime($request->input('date')));

            $res = $table->saveData($request->except(['_token', 'new_material', 'video_link', 'new_thumbnail']));
            return redirect('/admin/material/list?type=' . $request->type)->with($res[0], $res[1]);
        }
        $material = [];
        if (!empty($request->id)) {
            $material = $table->edit($request->id);
        }

        return view('Setting/adminMaterial')
            ->with('model', $material);
    }

    function materialList(Request $request)
    {
        if ($request->isMethod('post')) {
            $table = new Material();
            $status = $request->formType;
            if ($status == 'Delete') {
                $row = $table->find($request->id);
                Storage::disk('azure')->delete($row->material);
                $row->delete();
                return response()->json("success");
            }

            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input();
            $table_res = $table::orderBy('id', 'DESC')
                ->where('type', $request->type)
                ->where(function ($q) use ($requestData) {

                    for ($i = 0; $i < sizeof($requestData['columns']); $i++) {

                        $searchValue = $requestData['columns'][$i]['search']['value'];
                        if ($searchValue != '' && $i == 2) {
                            $q->where('title', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 3) {
                            $date = date('Y-m-d', strtotime($searchValue));
                            $q->where('date', $date);
                        }

                        if ($searchValue != '' && $i == 4) {
                            $q->where('tags', 'Like', "%" . $searchValue . "%");
                        }

                    }
                });
            $table_res = $table_res->paginate($request['length'])->toArray();
            $table_list = [];
            $i = $request['start'];

            foreach ($table_res['data'] as $key => $list) {
                
                $src = ($list['material']!='') ? uploads($list['material']) : '';

                $table_list[] = [++$i,
                    $list['id'],
                    $list['title'],
                    $list['date'],
                    $list['tags'],
                    $src,
                    $list['youtube_url'],

                ];
            }

            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
        return view('Setting/adminMaterialList');
    }

    /*---------------------------------- Special Test Course Add ---------------------------------------------------------*/
    public function specialTestCourse(Request $request, $id = null)
    {
        $table = new SpecialTestCourse();
        if ($request->isMethod('post')) {
            $res = $table->saveData($request->except(['_token']));
            return redirect('/admin/specialTest/course')->with($res[0], $res[1]);
        }
        $model = [];
        if (!empty($id)) {
            $model = $table->edit($id);
        }
        $table_list = $table
            ->orderByRaw('id DESC')
            ->paginate(10);

        return view('Setting/adminSpecialTestCourse')
            ->with('table_list', $table_list)
            ->with('model', $model);
    }

   function users(Request $request)
    {
        if ($request->isMethod('post')) {
            $table = new App\Models\User();
            $status = $request->formType;
            if ($status == 'Delete') {
                $row = $table->find($request->id);
               // @unlink(public_path() . '/' . $row->profile);
                Storage::disk('azure')->delete($row->profile);
                $row->delete();
                return response()->json("success");
            }
            if ($status == 'Update') {
                $row = $table->where('id',$request->id)->update(['status'=>$request->status]);
                return response()->json("success");
            }

            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input();
            $table_res = $table::orderBy('id', 'DESC')
                ->where(function ($q) use ($requestData) {

                    for ($i = 0; $i < sizeof($requestData['columns']); $i++) {

                        $searchValue = $requestData['columns'][$i]['search']['value'];
                        if ($searchValue != '' && $i == 2) {
                            $q->where(function($s)use($searchValue){
                                $s->where('name', 'Like', "%" . $searchValue . "%");
                                  $s->orWhere('user_id', 'Like', "%" . $searchValue . "%");
                            });
                        }
                        if ($searchValue != '' && $i == 3) {
                            $q->where(function($r)use($searchValue){
                                $r->where('dob', 'Like', "%" . $searchValue . "%");
                                $r->orWhere('dob', 'Like', date('Y-m-d',strtotime($searchValue)));
                            });

                        }
                        if ($searchValue != '' && $i == 4) {
                            $q->where('email', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 5) {
                            $q->where('mobile', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 6) {
                            $date = date('Y-m-d', strtotime($searchValue));
                            $q->where('created_at', 'Like', "%" . $date . "%");
                        }
                        if ($searchValue != '' && $i == 7) {
                            $q->where('city', 'Like', "%" . $searchValue . "%");
                        }
                        if ($searchValue != '' && $i == 8) {
                            $q->where('zipcode', 'Like', "%" . $searchValue . "%");
                        }
                    }
                });
            $table_res = $table_res->paginate($request['length'])->toArray();
            $table_list = [];
            $i = $request['start'];

            foreach ($table_res['data'] as $key => $list) {
                $src = asset($list['profile']);
                $dob=($list['dob']!=null)?date('d-m-Y',strtotime($list['dob'])):'-';
                $table_list[] = [
                    ++$i,
                    $list['id'],
                    $list['name'].'<br/> '.$list['user_id'],
                   $dob,
                    $list['email'],
                    $list['mobile'],
                    date('d-m-Y', strtotime($list['created_at'])),
                    
                    ($list['city']==0)?'':$list['city'],
                    $list['zipcode'],
                    $list['profile'],
                    $list['status'],

                ];
            }

            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
        return view('Setting/userList');
    }

    function usersPaymentList(Request $request)
    {
        if ($request->isMethod('post')) {
            $table = new PaymentDetail();
            $status = $request->formType;
            if ($status == 'Delete') {
                $row = $table->find($request->id);
                $row->delete();
                return response()->json("success");
            }

            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input();
            $table_res = $table::with(['course', 'specialCourse','user'])->orderBy('id', 'DESC');


                    for ($i = 0; $i < sizeof($requestData['columns']); $i++) {

                        $searchValue = $requestData['columns'][$i]['search']['value'];
                        if ($searchValue != '' && $i == 1) {
                            $table_res->whereHas("user",function ($q)use($searchValue){
                                $q->where('name', 'Like', "%" . $searchValue . "%");
                            });

                        }

                        if ($searchValue != '' && $i == 2) {
                            $data=explode(' ',$searchValue);
                            $from=date('Y-m-d',strtotime($data[0]));
                            $to=date('Y-m-d',strtotime($data[2]));
                            $table_res->whereBetween('payment_date',[$from,$to]);
                        }
                        if ($searchValue != '' && $i == 3) {
                            $table_res->where('amount',  $searchValue );
                        } if ($searchValue != '' && $i == 4) {
                            $table_res->where('type', 'Like', "%" . $searchValue . "%");
                        }if ($searchValue != '' && $i == 6) {
                            $table_res->where('payment_method', 'Like', "%" . $searchValue . "%");
                        }


                    }

            $table_res = $table_res->paginate($request['length'])->toArray();
           
            $table_list = [];
            $i = $request['start'];
            $totalAmount = 0;
            foreach ($table_res['data'] as $key => $list) {
                if($requestData['columns'][5]['search']['value']!=''){
                    $searchValue = $requestData['columns'][5]['search']['value'];

                    if(!strpos( $list['special_course']['course'],$searchValue ) && $list['type'] == 'SpecialTestCourse') {
                        goto next;
                    }if(!strpos( $list['course']['course'],$searchValue ) && $list['type'] == 'Course') {
                        goto next;
                    }
                }

                $totalAmount += $list['amount'];
                $course = ($list['type'] == 'SpecialTestCourse') ? $list['special_course']['course'] : $list['course']['course'];
                $table_list[] = [++$i,

                    $list['user']['name'],
                    date('d-m-Y h:i A', strtotime($list['payment_date'])),
                    $list['amount'],
                    $list['type'],
                    $course,
                    $list['payment_method'], 
                    $list['payment_id'],
                    $list['id'],


                ];
                next:
            }
            $table_list[] = [++$i,
                '<b>Total Amount</b>',
                '',
                '<b>'.$totalAmount.'</b>',
                '',
                '',
                '',
                '', '',

            ];

            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
        $course=['Course'=>Course::select(DB::raw("concat(id,'~Course') AS id"), "course")->where('course_type','Paid')->orderBy('course', 'asc')->pluck('course', 'id'),
        'Special Test'=>SpecialTestCourse::select(DB::raw("concat(id,'~SpecialTestCourse') AS id"), "course")->where('type','Paid')->orderBy('course', 'asc')->pluck('course', 'id')];

        return view('Setting/userPaymentList')  ->with('users', $this->getAllUsers())
        ->with('course', $course);
    }
     public function usersPayment(Request $request)
    {

        if ($request->isMethod('post')) {
            $course=explode('~',$request->input('course_id'));
            $data = [
                'user_id' => $request->input('user_id'),
                'type' => $course[1],
                'type_id' => $course[0],
                'payment_id' => "manual",
                'amount' => $request->input('amount'),
                'status' => "Success",
                'payment_method' => "Manual",
                'payment_date' => date('Y-m-d H:i:s')
            ];
            //dd($data);
            $payment_detail = new PaymentDetail();
            $payment_detail = $payment_detail->create($data);
            return redirect('/admin/usersPaymentList');
        }

    }
    function getAllUsers() {
        $users = User::orderByRaw('name ASC')->pluck('name', 'id')->toArray();
        return $users;

    }
	    public function smsList(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $table = new SmsDetail();
            $no_array = explode(',', $request->input('number'));
             $sender=SmsTemplate::select('sender')->where('title',$request->template)->first();
            $data = [];
            for ($i = 0; $i < count($no_array); $i++) {
                $item = [];
                if ($no_array[$i]) {
                    $user_id = User::where('mobile', $no_array[$i])->select('id')->first();
                    $item['user_id'] = $user_id ? $user_id->id : '';
                    $item['mobile'] = $no_array[$i];
                    $item['date'] = date('Y-m-d h:i');
                    $item['sms_type'] = $request->input('sms_type');
                    $item['message'] = $request->input('message');
                    $number = $no_array[$i];
                    //$result = $this->sendSms('GuruDevAcademy', $request->message, $number);
                    $result = $this->sendSmsGurudev($request->message, $number,$sender->sender);
                    $item['status'] = $result['status'];
                    array_push($data, $item);

                }
            }

            //dd($data);
            $res = $table->saveData($data);

            return redirect('/sms_list')->with($res[0], $res[1]);


        }


         $templates= SmsTemplate::orderBy('title', 'asc')->pluck('title', 'template');
        return view('Setting/sms_list')->with('templates',$templates);
    }
    public function smsListAjax(Request $request)
    {

        if ($request->isMethod('post')) {
            $table = new SmsDetail();
            $status = $request->formType;


            if ($request['length'] != -1)
                $currentPage = ($request['start'] / $request['length']) + 1;
            else {
                $currentPage = 1;
                $request['length'] = $request->input('recordsTotal');
            }

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $requestData = $request->input();
            $table_res = $table::with(['user'])->orderBy('id', 'DESC');


            for ($i = 0; $i < sizeof($requestData['columns']); $i++) {

                $searchValue = $requestData['columns'][$i]['search']['value'];
                if ($searchValue != '' && $i == 1) {
                    $table_res->whereHas("user", function ($q) use ($searchValue) {
                        $q->where('name', 'Like', "%" . $searchValue . "%");
                    });

                }
                if ($searchValue != '' && $i == 2) {
                    $table_res->where('mobile', 'Like', "%" . $searchValue . "%");
                }

                if ($searchValue != '' && $i == 3) {
                    $data = explode(' ', $searchValue);
                    $from = date('Y-m-d', strtotime($data[0]));
                    $to = date('Y-m-d', strtotime($data[2]));
                    $table_res->whereBetween('date', [$from, $to]);
                }
                if ($searchValue != '' && $i == 4) {
                    $table_res->where('sms_type', 'Like', "%" . $searchValue . "%");
                }
                if ($searchValue != '' && $i == 5) {
                    $table_res->where('status', 'Like', "%" . $searchValue . "%");
                }
            }

            $table_res = $table_res->paginate($request['length'])->toArray();

            $table_list = [];
            $i = $request['start'];

            foreach ($table_res['data'] as $key => $list) {
                $table_list[] = [++$i,

                    $list['user']['name'],
                    $list['mobile'],
                    date('d-m-Y h:i A', strtotime($list['date'])),
                    $list['sms_type'],
                    $list['status'],

                    substr($list['message'],0,130),
                     $list['message'],
                ];

            }
            $_resdata = ["draw" => $request['draw'], "recordsTotal" => $table_res['total'], "recordsFiltered" => $table_res['total'], "data" => $table_list];
            return response()->json($_resdata);
        }
    }
     public function smsIndividual(Request $request, $id = null)
    {

        if ($request->isMethod('post')) {
            $table = new SmsDetail();
            $data = [];
            $sender=SmsTemplate::select('sender')->where('title',$request->data[0]['template'])->first();


            foreach ($request->data as $list) {
                $result = $this->sendSmsGurudev($list['message'], $list['mobile'],$sender->sender);
                $list['status'] = $result['status'];
                $list['date'] = date('Y-m-d H:i:s');
                unset($list['template']);
                $data[] = $list;
            }
            $res = $table->saveData($data);
            if ($res) {
                header('Content-Type: application/json');
                return Response()->json( $res[0]);
            }
        }
       $templates= SmsTemplate::orderBy('title', 'asc')->pluck('title', 'template');

        $users_list = User::select(['id', 'name', 'mobile'])->orderByRaw('name ASC')->get()->toArray();
        return view('Setting/sms_individual')->with('user_list', $users_list)->with('templates', $templates);
    }

    /*---------------------------------- Admin Email Send ---------------------------------------------------------*/
    function email(Request $request){
        $table= new App\Models\EmailSentItems();
        if($request->isMethod('post')){
            $requestData=$request->except(['_token']);

            $emails=[];$userIds=[];
            foreach ($requestData['user_id'] as $item){
                $email=explode(':',$item);
                $emails[]=$email[1];
                $userIds[]=$email[0];
            }
            $file = $request->file('attachment');
            if ($file != '' && $file->getClientOriginalName() != '') {
                $newFileName = substr(trim($requestData['subject']), 0, 8);
                $newFileName = $this->fileUpload('Uploads/EmailAttachments', $file, $newFileName);
                $requestData['attachment'] = $newFileName;
            }
            $requestData['user_id']=implode(',',$userIds);
            $requestData['email']=implode(',',$emails);


            Mail::send('Email.adminEmail', $requestData, function($message) use ($requestData,$emails) {
                $message->to($emails)->subject($requestData['subject']);
                if($requestData['attachment']!=''){
                    $message->attach(env('AZURE_STORAGE_URL').$requestData['attachment']); 
                }
            });
            $res=$table->saveData($requestData);
            return redirect('/admin/email')->with($res[0], $res[1]);
        }

        $users=User::select(DB::raw("CONCAT(name,' : ',email) AS email"),DB::raw("CONCAT(id,':',email) AS id"))->pluck('email','id')->toArray();

        $table_list = $table->orderByRaw('id DESC')->paginate(10)->toArray();

        return view('Setting/email')
            ->with(['users'=>$users,'table_list'=>$table_list]);

    }
    /*---------------------------------- Banner Images Add ---------------------------------------------------------*/
    function bannerImages (Request $request,$id=null){
        $table= new App\Models\BannerImages();
        if($request->isMethod('post')){
            $requestData=$request->except(['_token']);

            // dd($requestData);
            $file = $requestData['image'];
            if ($file != '' && $file->getClientOriginalName() != '') {
                $newFileName = 'Banner';
                $newFileName = $this->fileUpload('Uploads/BannerImages', $file, $newFileName);
                $requestData['image'] = $newFileName;

                if($requestData['old_image']!='')
                    Storage::disk('azure')->delete($requestData['old_image']);
            }
            unset($requestData['old_image']);
            $res= $table->saveData($requestData);
            return redirect('/admin/bannerImages')->with($res[0], $res[1]);
        }
        if (!empty($id)) {
            $model = $table->edit($id);
        }
        $table_list = $table->where('type','!=','Marquee Text')->orderByRaw('id DESC')->paginate(10)->toArray();

        return view('Setting/bannerImages')
            ->with(['table_list'=>$table_list,'model'=>$model]);

    }
    /*---------------------------------- Marquee Text ---------------------------------------------------------*/
    function marqueeText (Request $request,$id=null){
        $table= new App\Models\BannerImages();
        if($request->isMethod('post')){
            $requestData=$request->except(['_token']);
            $requestData['type'] = "Marquee Text";
            // dd($requestData);
            $res= $table->saveData($requestData);
            return redirect('/admin/marqueeText')->with($res[0], $res[1]);
        }
        if (!empty($id)) {
            $model = $table->edit($id);
        }
        $table_list = $table->where('type','Marquee Text')->orderByRaw('id DESC')->paginate(10)->toArray();

        return view('Setting/marqueeText')
            ->with(['table_list'=>$table_list,'model'=>$model]);

    }
     /*---------------------------------- Batches Create  ---------------------------------------------------------*/
    function batches (Request $request,$id=null){
        $table= new App\Models\Batch();
        if($request->isMethod('post')){
            $requestData=$request->except(['_token']);
            $res=$table->saveData($requestData);
            return redirect('/admin/batches')->with($res[0], $res[1]);
        }
        if (!empty($id)) {
            $model = $table->edit($id);
            $model->course_id=explode(',',$model->course_id);
        }
        $table_list = $table->orderByRaw('id DESC')->paginate(10)->toArray();

        return view('Setting/batches')
            ->with([
                'table_list'=>$table_list,
                'course'=>$this->getCourse('Paid'),
                'model'=>$model
            ]);
    }
    function batchMembersLoad(Request $request,$id=null){

        $list=App\Models\Batch::where('batches.id',$id)
            ->join("users",DB::raw("FIND_IN_SET(users.id,batches.user_id)"),">",DB::raw("'0'"))
            ->get();

        return view('Setting/batchMembers')->with('list',$list);
    }
    function getUsersOnCourse(Request $request){
        if($request->isMethod('post')){
           $users=PaymentDetail::with('user')
               ->where(['type'=>'Course','status'=>'Success'])
               ->whereIn('type_id',$request->course)
               ->get()
               ->pluck('user.name','user.id')->toArray();
           return response($users);
        }
    }
     /*---------------------------------- weeklyBuzz Add ---------------------------------------------------------*/
      public function weeklyBuzz(Request $request, $id = null)
      {
          //  dd($request->input());
          $table = new WeeklyBuzz();
          if ($request->isMethod('post')) {
              $request['date'] = date('Y-m-d', strtotime($request->input('date')));

              $file = $request->file('new_image');
              if ($file != '' && $file->getClientOriginalName() != '') {
                  if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                      Storage::disk('azure')->delete($request['old_image']);
                  }
                  $newFileName = substr(trim($request['title']), 0, 8);
                  $newFileName = $this->fileUpload('Uploads/WeeklyBuzz', $file, $newFileName);
                  $request['attachment'] = $newFileName;
              }
              $file = $request->file('new_thumbnail');
              if ($file != '' && $file->getClientOriginalName() != '') {
                  if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    Storage::disk('azure')->delete($request['old_tumnnail']);
                    //  @unlink(public_path() . '/' . $request['old_tumnnail']);
                  }
                  $newFileName = substr(trim($request['title']), 0, 8);
                  $newFileName = $this->fileUpload('Uploads/WeeklyBuzz', $file, $newFileName);
                  $request['thumbnail'] = $newFileName;
              }


              $res = $table->saveData($request->except(['_token', 'new_image','old_image','old_tumnnail','new_thumbnail']));
              return redirect('/admin/weeklyBuzz')->with($res[0], $res[1]);
          }
          $model = [];
          if (!empty($id)) {
              $model = $table->edit($id);
              $model['date'] = date('d-m-Y', strtotime($model['date']));
          }
          $table_list = $table
                 ->with('weeklyBuzzFolder')
              ->orderByRaw('id DESC')
              ->paginate(10)->toArray();
        $folder_list = WeeklyBuzzFolder::orderByRaw('id DESC')->pluck('folder_name','id');
          return view('Setting/adminWeeklyBuzz')
           ->with('folder_list', $folder_list)
              ->with('table_list', $table_list)
              ->with('model', $model);
      }
      function weeklyBuzzFolder (Request $request){
        $table= new WeeklyBuzzFolder();
        if($request->isMethod('post')){
            $requestData=$request->except(['_token']);
            $chk_mm = $table->where("folder_name",$requestData['folder_name'])->where('id','!=',$requestData['id'])->exists();
            if(empty($chk_mm))
            {
                if($requestData['id']=='') {
                    $res = $table->create($requestData);
                    return redirect('/admin/weeklyBuzz')->with('success', 'Folder Saved Successfully');
                }
                else{
                    $table->where(["id"=>$requestData['id']])->Update($requestData);
                    return redirect('/admin/weeklyBuzz')->with('success','Folder Updated Successfully');
                }
            }
            else
            {
                return redirect('/admin/weeklyBuzz')->with('warning','Existing Record');
            }

        }


    }
       /*---------------------------------- Banner Images Add ---------------------------------------------------------*/
    function quizInstruction (Request $request,$id=null){
        $table= new App\Models\QuizInstruction();
        if($request->isMethod('post')){
            $requestData=$request->except(['_token']);
            $chk_mm = $table->where("type",$requestData['type'])->where('id','!=',$requestData['id'])->exists();
            if(empty($chk_mm))
            {
                if($requestData['id']=='') {
                    $res = $table->create($requestData);
                    return redirect('/admin/quizInstruction')->with('success', 'Instruction Saved Successfully');
                }
                else{
                    $table->where(["id"=>$requestData['id']])->Update($requestData);
                    return redirect('/admin/quizInstruction')->with('success','Instruction Updated Successfully');
                }
            }
            else
            {
                return redirect('/admin/quizInstruction')->with('warning','Existing Record');
            }
           
        }
        if (!empty($id)) {
            $model = $table->find($id);
        }
        $table_list = $table->orderByRaw('id DESC')->paginate(10)->toArray();

        return view('Setting/quizInstruction')
            ->with(['table_list'=>$table_list,'model'=>$model]);

    }
     /*---------------------------------- Announcements Add ---------------------------------------------------------*/
     public function smsTemplate(Request $request, $id = null)
     {
         $table = new App\Models\SmsTemplate();
         if ($request->isMethod('post')) {

             $res = $table->saveData($request->except(['_token']));
             return redirect('/smsTemplate')->with($res[0], $res[1]);
         }
         $model = [];
         if (!empty($request->id)) {
             $model = $table->edit($request->id);
         }
         $table_list = $table
             ->orderByRaw('id DESC')
             ->paginate(10)->toArray();

         return view('Setting/smsTemplate')
             ->with('table_list', $table_list)
             ->with('model', $model);
     }
     public function youtubeVideos(Request $request, $id = null)
      {
          $table = new YoutubeVideo();
          if ($request->isMethod('post')) {
              $request['date'] = date('Y-m-d', strtotime($request->input('date')));


            //   $file = $request->file('new_thumbnail');
            //   if ($file != '' && $file->getClientOriginalName() != '') {
            //       if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
            //           @unlink(public_path() . '/' . $request['old_tumnnail']);
            //       }
            //       $newFileName = substr(trim($request['title']), 0, 8);
            //       $newFileName = $this->fileUpload('Uploads/WeeklyBuzz', $file, $newFileName);
            //       $request['thumbnail'] = $newFileName;
            //   }


            $res = $table->saveData($request->except(['_token','untrim_link'/*'old_tumnnail','new_thumbnail'*/]));
              return redirect('/admin/youtubeVideos')->with($res[0], $res[1]);
          }
          $model = '';
          if (!empty($id)) {
              $model = $table->edit($id);
              $model['date'] = date('d-m-Y', strtotime($model['date']));
          }
          $table_list = $table
              ->orderByRaw('id DESC')
              ->paginate(10);
            //  dd($table_list);

          return view('Setting/adminYoutubeVideos')
              ->with('table_list', $table_list)
              ->with('model', $model);
      }
      public function specialTestSubCourse(Request $request, $id = null){
    
            $table = new SpecialTestSubCourse();
            if ($request->isMethod('post')) {
                $res = $table->saveData($request->except(['_token']));
                return redirect('/admin/specialTest/subCourse')->with($res[0], $res[1]);
            }
            $model = [];
            if (!empty($id)) {
                $model = $table->edit($id);
            }
            $table_list = $table->with('course')
                ->orderByRaw('id DESC')
                ->paginate(10);
            //dd($table_list->toArray());
    
            return view('Setting/adminSpecialTestSubCourse')
                ->with('table_list', $table_list)
                ->with('specialTestCourses',$this->getSpecialTestCourses())
                ->with('model', $model);
        }
}
