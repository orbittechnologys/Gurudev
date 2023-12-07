<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileUserController;
use App\Http\Controllers\RazorpayController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [MobileUserController::class, 'register']);Route::post('/getMobileAppVertion', [MobileUserController::class, 'getMobileAppVertion']);
Route::post('/login', [MobileUserController::class, 'login']);
Route::get('/register/course',  [MobileUserController::class, 'course']);
Route::get('/validateMobile/{hash_code?}',  [MobileUserController::class, 'validateMobile']);
Route::get('/autoOTPRead',  [MobileUserController::class, 'autoOTPRead']);
Route::post('/generateOtp/{hash_code?}',[MobileUserController::class, 'generateOtp']);
Route::post('/resetForgotUserPassword/',[MobileUserController::class, 'resetForgotUserPassword']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile',[MobileUserController::class, 'profile']);
    Route::post('/profileUpdate',[MobileUserController::class, 'profileUpdate']);
    Route::get('/homePage/{slug?}', [MobileUserController::class, 'homePage']);
 
    Route::get('/bannerImages',[MobileUserController::class, 'bannerImages']);
    Route::get('/currentAffairs/{slug?}',[MobileUserController::class, 'currentAffairs']);
     Route::get('/currentAffairsNew/{slug?}',[MobileUserController::class, 'currentAffairsNew']);
    Route::get('/studyMaterials/',[MobileUserController::class, 'studyMaterials']);
    Route::get('/videoMaterials/',[MobileUserController::class, 'videoMaterials']);

    Route::get('/bookMarks/',[MobileUserController::class, 'bookMarks']);
    Route::post('/bookMark/',[MobileUserController::class, 'bookmark']);

    Route::get('/mcq/',[MobileUserController::class, 'mcq']);
    Route::get('/mcq/onlineTest/{id}',[MobileUserController::class, 'mcqTest']);

    Route::get('/specialTest/course', [MobileUserController::class, 'specialTestCourse']);
    Route::get('/specialTest/quiz/{slug}', [MobileUserController::class, 'specialTestQuizList']);
    Route::get('/specialTest/onlineTest/{id}', [MobileUserController::class, 'specialTestOnlineTest']);
    Route::post('/specialTest/quiz/save', [MobileUserController::class, 'specialTestQuizSave']);
    Route::get('/notifications/{slug?}', [MobileUserController::class, 'notifications']);

    Route::post('/currentAffairs/MCQ/quiz/save', [MobileUserController::class, 'currentAffairsMCQQuizSave']);
    

    //new route to get order details for payment by svn on 06-04-2023
    Route::post('/generatePaymentOrder',  [RazorpayController::class, 'generatePaymentOrder']);
    Route::post('/getPaymentDetails',  [RazorpayController::class, 'generatePayment']);

    Route::prefix('course')->group(function () {
        Route::get('/',  [MobileUserController::class, 'course']);
        Route::get('/subject/{slug?}',  [MobileUserController::class, 'chapter']);
        Route::get('/subject/chapter/{slug?}',  [MobileUserController::class, 'material']);
        Route::get('/{slug?}',  [MobileUserController::class, 'subject']);
        Route::get('/onlineTest/{id}', [MobileUserController::class, 'onlineTest']);
        Route::post('/quiz/save', [MobileUserController::class, 'courseQuizSave']);
    });
    Route::post('/logout', [MobileUserController::class, 'logout']);
    Route::post('/resetUserPassword',[MobileUserController::class,'resetUserPassword']);
    Route::get('/homePage/{slug?}', [MobileUserController::class, 'homePage']);
    Route::get('/weeklyBuzz/',[MobileUserController::class, 'weeklyBuzz']);
    Route::get('/weeklyBuzzFolder',[MobileUserController::class, 'weeklyBuzzFolder']);
    Route::get('/keyAnswers/{id}',[MobileUserController::class, 'keyAnswers']);
     Route::get('/notificationHistoryUpdate',[MobileUserController::class, 'notificationHistoryUpdate']);
     Route::get('/quizInstruction/{type?}',[MobileUserController::class, 'quizInstruction']);
        Route::get('/youtubeVideo/{type?}',[MobileUserController::class, 'youtubeVideo']);
   
});