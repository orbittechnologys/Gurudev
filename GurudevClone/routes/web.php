<?php

use App\Http\Controllers\AccessRoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InteractiveClassController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Http\Controllers\RazorpayController;

require __DIR__ . '/auth.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
     $exitCode = Artisan::call('view:clear');
    // return what you want
});
Route::get('/dashboard', function () {
    dd('cgfg');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::get('/dynamicDelete/{modal}/{id}', [HomeController::class, 'dynamicDelete'])->name('dynamicDelete')->middleware('authAdmin');

    //new lines added by svn on 02-02-2023
    Route::post('/googleAuthenticationLogin', [HomeController::class,'googleAuthenticationLogin']);
    Route::post('/getNextChild',  [HomeController::class,'getNextChild']);
    Route::post('/ajaxOtp', [HomeController::class,'ajaxOtp']);
    Route::post('/ajaxForgotPwdOtp', [HomeController::class,'ajaxForgotPwdOtp']);
    Route::post('/checkEmailAvailable', [HomeController::class,'checkEmailAvailable']);

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->middleware(['authAdmin'])->name('adminDashboard');
        Route::match(['get', 'post'],'/changePassword', [HomeController::class, 'adminPasswordChange'])->middleware(['authAdmin']);
            /*-------------------------------- Current Affairs -----------------------------*/

        Route::prefix('course')->group(function () {
            Route::match(['get', 'post'], '/list', [SettingController::class, 'adminCourseList'])->middleware('authAdmin');
            Route::match(['get', 'post'], '/{id?}', [SettingController::class, 'adminCourse'])->middleware('authAdmin');
        });
        Route::prefix('subject')->group(function () {
            Route::match(['get', 'post'], '/list', [SettingController::class, 'adminSubjectList'])->middleware('authAdmin');
            Route::match(['get', 'post'], '/{id?}', [SettingController::class, 'adminSubject'])->middleware('authAdmin');
        });
        Route::prefix('chapter')->group(function () {
            Route::match(['get', 'post'], '/list', [SettingController::class, 'adminChapterList'])->middleware('authAdmin');
            Route::match(['get', 'post'], '/{id?}', [SettingController::class, 'adminChapter'])->middleware('authAdmin');
        });
        Route::match(['get', 'post'], '/announcements/{id?}', [SettingController::class, 'adminAnnouncements'])->name('adminAnnouncements')->middleware('authAdmin');

        /*--------------------------------- Quiz Questions Add ---------------------------*/
            Route::match(['get', 'post'], 'questions/add', [QuizController::class, 'questionsAdd'])->middleware('authAdmin');
            Route::get('questions/list/{search?}', [QuizController::class, 'questionsList'])->middleware('authAdmin');
            Route::post('questions/get/', [QuizController::class, 'questionEdit'])->middleware('authAdmin');
            Route::get('questions/dragDrop/{search_string?}/{selected_qu?}', [QuizController::class, 'dragDrop'])->middleware('authAdmin');
        /*---------------------------------Chapter  Quiz  Add ---------------------------*/
        Route::get('/mockTest/add/{id}',  [QuizController::class, 'mockTestAdd'])->middleware('authAdmin');
         /*---------------------------------Current Affair  Quiz  Add ---------------------------*/

        Route::prefix('currentAffairs')->group(function () {
            Route::get('/mcq',  [QuizController::class, 'currentAffairsQuiz'])->middleware('authAdmin');
            Route::get('/mcq/list',  [QuizController::class, 'quizList'])->middleware('authAdmin');
            Route::match(['get', 'post'], '/list', [SettingController::class, 'currentAffairsList'])->middleware('authAdmin');
            Route::match(['get', 'post'], '/{id?}', [SettingController::class, 'currentAffairs'])->middleware('authAdmin');
        });

        Route::post('/quiz/save',  [QuizController::class, 'quizSave'])->middleware('authAdmin');
        Route::get('/quiz/view/{id}',  [QuizController::class, 'quizView'])->middleware('authAdmin');
        Route::get('/quiz/attended/{id}',  [QuizController::class, 'quizAttendedDetails'])->middleware('authAdmin');
        Route::post('/quiz/delete',  [QuizController::class, 'quizDelete'])->middleware('authAdmin');

        Route::match(['get', 'post'], '/material/list/', [SettingController::class, 'materialList'])->middleware('authAdmin');
        Route::match(['get', 'post'], '/material', [SettingController::class, 'material'])->middleware('authAdmin');
        Route::prefix('specialTest')->group(function () {
            Route::match(['get', 'post'], '/course/{id?}', [SettingController::class, 'specialTestCourse'])->name('specialTestCourse')->middleware('authAdmin');
            Route::match(['get', 'post'], '/subCourse/{id?}', [SettingController::class, 'specialTestSubCourse'])->name('specialTestSubCourse')->middleware('authAdmin');
            Route::get('/test', [QuizController::class, 'specialTestAdd'])->middleware('authAdmin');
            Route::get('/test/list', [QuizController::class, 'quizList'])->middleware('authAdmin');
            Route::post('/save', [QuizController::class, 'specialTestSave'])->middleware('authAdmin');
        });
        Route::match(['get', 'post'], '/users', [SettingController::class, 'users'])->middleware('authAdmin');
        Route::match(['get', 'post'], '/usersPaymentList', [SettingController::class, 'usersPaymentList'])->middleware('authAdmin');
	    Route::post('/payAmount', [SettingController::class, 'usersPayment'])->middleware('authAdmin');

        Route::match(['get','post'],'/email',  [SettingController::class, 'email'])->middleware('authAdmin');
        Route::match(['get','post'],'/bannerImages/{id?}',  [SettingController::class, 'bannerImages'])->middleware('authAdmin');
        Route::match(['get','post'],'/marqueeText/{id?}',  [SettingController::class, 'marqueeText'])->middleware('authAdmin');
        
        Route::match(['get','post'],'/batches/{id?}',  [SettingController::class, 'batches'])->middleware('authAdmin');
        Route::get('/batchMembersLoad/{id}',  [SettingController::class, 'batchMembersLoad'])->middleware('authAdmin');
        Route::post('/getUsersOnCourse/',  [SettingController::class, 'getUsersOnCourse'])->middleware('authAdmin');

        Route::prefix('liveClass')->group(function () {
            Route::match(['get','post'],'create', [InteractiveClassController::class, 'create'])->middleware('authAdmin');
            Route::get('list', [InteractiveClassController::class, 'list'])->middleware('authAdmin');
            Route::get('/create/{id}', [InteractiveClassController::class, 'create'])->name('liveClass.edit')->middleware('authAdmin');
            Route::get('/goLive/{id}', [InteractiveClassController::class, 'adminGoLive'])->middleware('authAdmin');
            Route::get('/attendedStudent/{id}', [InteractiveClassController::class,'attendedStudent'])->middleware('authAdmin');
        });
       Route::match(['get','post'],'/weeklyBuzz/{id?}',  [SettingController::class, 'weeklyBuzz'])->name('adminWeeklyBuzz')->middleware('authAdmin');
       Route::match(['get', 'post'],'/weeklyBuzzFolder/', [SettingController::class, 'weeklyBuzzFolder'])->middleware('authAdmin');
       Route::match(['get','post'],'/quizInstruction/{id?}',  [SettingController::class, 'quizInstruction'])->name('quizInstruction')->middleware('authAdmin');
       Route::match(['get','post'],'/youtubeVideos/{id?}',  [SettingController::class, 'youtubeVideos'])->name('adminYoutubeVideos')->middleware('authAdmin');

        Route::post('importUser', function () {
            $data = new UsersImport;
            $response = Excel::import($data, request()->file('file'));
            if(empty($data->missedRows))
                return redirect()->back()->with('success','User Imported Successfully');
            else
                return redirect()->back()->with('missed-records', $data->missedRows);
        });
    });
    /*--------------------------------Access Role-----------------------------*/
    Route::prefix('accessRole')->group(function () {
        Route::match(['get', 'post'], '/mainMenu', [AccessRoleController::class, 'mainMenu'])->middleware(['authAdmin']);
        Route::get('/mainMenuEdit/{id}', [AccessRoleController::class, 'mainMenu'])->middleware(['authAdmin']);
        Route::get('/mainMenuDelete/{id}', [AccessRoleController::class, 'mainMenuDelete'])->middleware(['authAdmin']);
        Route::match(['get', 'post'], '/subMenu', [AccessRoleController::class, 'subMenu'])->middleware(['authAdmin']);
        Route::get('/subMenuEdit/{id}', [AccessRoleController::class, 'subMenu'])->middleware(['authAdmin']);
        Route::get('/subMenuDelete/{id}', [AccessRoleController::class, 'subMenuDelete'])->middleware(['authAdmin']);
        Route::match(['get', 'post'], '/userRole/{id?}', [AccessRoleController::class, 'userRole'])->middleware('authAdmin');
        Route::match(['get', 'post'], '/userRoleBulk/', [AccessRoleController::class, 'userRoleBulk'])->middleware('authAdmin');
    });
	 /*---------------------------------------- sms --------------------------------------------*/
    Route::match(['get', 'post'],'/sms_list', [SettingController::class,'smsList'])->middleware('authAdmin');
    Route::match(['get', 'post'],'/smsListAjax', [SettingController::class,'smsListAjax'])->middleware('authAdmin');
    Route::match(['get', 'post'],'/sms_individual',  [SettingController::class,'smsIndividual'])->middleware('authAdmin');
    Route::match(['get', 'post'],'/smsTemplate',  [SettingController::class,'smsTemplate'])->name('smsTemplate')->middleware('authAdmin');

   
    /*--------------------------------User Routes-----------------------------*/
    Route::get('/dashboard',  [UserController::class, 'userDashboard'])->name('userDashboard')->middleware('auth');
    Route::match(['get', 'post'], '/updateProfile/', [UserController::class, 'updateProfile'])->middleware('auth');
    Route::get('/announcements',  [UserController::class, 'announcements'])->middleware('auth');
    Route::get('/currentAffairs',  [UserController::class, 'currentAffairs']);
 
    // Route::post('/generatePayment',  [HomeController::class, 'generatePayment'])->middleware('auth');
    Route::post('/generatePayment',  [RazorpayController::class, 'generatePayment'])->middleware('auth');
    Route::post('/generatePaymentOrder',  [RazorpayController::class,'generatePaymentOrder'])->name('generatePaymentOrder')->middleware('auth');
    Route::prefix('course')->group(function () {
        Route::get('/',  [UserController::class, 'course'])->middleware('auth');
        Route::get('/subject/chapter/{slug?}',  [UserController::class, 'material'])->middleware('auth');
        Route::get('/subject/{slug?}',  [UserController::class, 'chapter'])->middleware('auth');
        Route::get('/{slug?}',  [UserController::class, 'subject'])->middleware('auth');
        Route::get('/onlineTest/{id}', [UserController::class, 'onlineTest'])->middleware('auth');

    });
    Route::get('/mcq/', [UserController::class, 'mcq'])->middleware('auth');
    Route::get('/mcq/onlineTest/{id}', [UserController::class, 'mcqTest'])->middleware('auth');

    Route::get('/specialTest/course', [UserController::class, 'specialTestCourse'])->middleware('auth');
    Route::get('/specialTest/quizList', [UserController::class, 'specialTestQuizList'])->middleware('auth');
   	Route::get('/specialTest/onlineTest/{id}', [UserController::class, 'specialTest'])->middleware('auth');
    Route::post('/specialTest/updateResult/', [UserController::class, 'specialTestUpdate'])->middleware('auth');
    Route::post('/specialTest/saveResult/', [UserController::class, 'specialTestSave'])->middleware('auth');
    Route::get('/specialTest/keyAnswer/{id}', [UserController::class, 'specialTestQuizKeyAnswer'])->middleware('auth');
    Route::post('/test-complete',  [UserController::class, 'onlineTestSave'])->middleware('auth');
    Route::get('/key-answers/{id}', [UserController::class, 'keyAnswers'])->middleware('auth');

    Route::get('/studyMaterials/', [UserController::class, 'studyMaterials'])->middleware('auth');
    Route::get('/videoMaterials/', [UserController::class, 'videoMaterials'])->middleware('auth');
    Route::get('/liveClass/', [UserController::class, 'liveClass'])->middleware('auth');
    Route::get('/liveClass/goLive/{id}', [InteractiveClassController::class, 'liveClass'])->middleware('auth');
    Route::post('/bookmark',  [UserController::class, 'bookmark'])->middleware('auth');
    Route::get('/bookmarks',  [UserController::class, 'bookmarks'])->middleware('auth');
    Route::get('/weeklyBuzz/folder', [UserController::class, 'weeklyBuzzFolder'])->middleware('auth');
    Route::get('/weeklyBuzz/', [UserController::class, 'weeklyBuzz'])->middleware('auth');
    Route::get('/studyMaterialView/{id}',  [UserController::class, 'studyMaterialView'])->middleware('auth');
    Route::post('/deleteMaterial',  [UserController::class, 'deleteMaterial'])->middleware('auth');
    Route::get('/youtubeVideos/', [UserController::class, 'youtubeVideos'])->middleware('auth');
});
   Route::get('/currentAffairs/{slug}',  [UserController::class, 'currentAffairs']);

   Route::get('destroy', function () {
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    \Artisan::call('event:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
});

Route::get('create', function () {
    \Artisan::call('view:cache');
    \Artisan::call('config:cache');
    \Artisan::call('event:cache');
    \Artisan::call('route:cache');
});
   
