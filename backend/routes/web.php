<?php

use App\Http\Controllers\ApplicantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ChatController;
use App\Models\Employee;
use GuzzleHttp\Middleware;

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

Route::get('/', function (Request $request) {
    return view('portal.index');
})->name('portal');


Route::get('/test', function (Request $request) {
    return Auth::user();
});

Route::get('/register', function (Request $request) {
    return view('register');
});

Route::get('/login', function (Request $request) {
    return view('/login');
})->middleware('role')->name('login');


Route::get('/hash',[ApplicantController::class,'incrementalHash']);

Route::resource('/register/add_user',ApplicantController::class);

Route::post('login/login_post',[LoginController::class,'authenticate']);
Route::get('/logout',[LogoutController::class,'logout_user'])->name('logout');
//Route::post('login_post',[ 'as' => 'login', 'uses' => 'LoginController@authenticate']);



//portal get routes
Route::get('/portal_event',[EventController::class,'index']);
Route::get('/portal_announcement',[AnnouncementController::class,'index']);


//Route::post('google_auth',[LoginController::class,'google_auth']);
Route::middleware(['auth','role'])->group(function(){

    Route::group([                                           
        'prefix' => 'admin',
        'as' => 'admin',
        ],function(){

       
        Route::get('/chat_support',function(Request $request){
            return view('template.admin.chat_support');
        });
        Route::resource('/chat',ChatController::class);
        Route::get('/getAdminChats',[ChatController::class,'getAdminChats']);
        Route::get('/updateMsgsStatus/{id}',[ChatController::class,'updateMsgsStatus']);
        
        Route::get('/',function(Request $request){
            return redirect('admin/home');
        })->name('admin_home');

        Route::get('/home',function(Request $request){
            return view('template.admin.index');
        });

        Route::get('/deactivated_users',function(){
            return view('template.admin.deactivated_users');
        });

        Route::get('/logout',function(Request $request){
            return redirect(route('logout'));
        });

        Route::get('/users',function(){
            return view('template.admin.users');
        });

        Route::get('/activate_user/{id}',[UserController::class,'activate']);

        Route::put('/update_user_data/{id}',[UserController::class,'update']);

        Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);

        Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);

        Route::get('/user_list',[UserController::class,'index']);

        Route::get('/deactivated_list',[UserController::class,'deactivatedUser']);

        Route::get('/user_info/{id}',[UserController::class,'user_info']);

        Route::post('add_user',[UserController::class,'store']);
    
    });

    Route::group([
        'prefix' => 'hr_head',
        'as' => 'hr_head',
        ],function(){

            Route::resource('/chat',ChatController::class);

            Route::get('/get_payslip/{id}',[EmployeeController::class,'getEmployeePayslip']);
            
            Route::post('/employee_get_dtr',[EmployeeController::class,'getEmployeeDTR']);

            Route::get('/chat_support',function(Request $request){
                return view('template.hr_head.chat_support');
            });

            Route::get('/employee_id/{id}',function(Request $request){
                return view('template.hr_head.employee_page');
            });

            Route::get('/',function(Request $request){
                return redirect('hr_head/home');
            })->name('hr_head_home');
    
            Route::get('/home',function(Request $request){
                return view('template.hr_head.index');
            });
    
            Route::get('/deactivated_users',function(){
                return view('template.hr_head.deactivated_users');
            });
    
            Route::get('/logout',function(Request $request){
                return redirect(route('logout'));
            });
    
            Route::get('/users',function(){
                return view('template.hr_head.users');
            });

            Route::get('/job_vacancies',function(){
                return view('template.hr_head.job_vacancies');
            });

            Route::get('/applicants',function(){
                return view('template.hr_head.applicant_list');
            });

            Route::get('/employees',function(){
                return view('template.hr_head.employee_list');
            });

            Route::get('/events_announcements',function(){
                return view('template.hr_head.events_announcement');
            });
    
            Route::get('/activate_user/{id}',[UserController::class,'activate']);

            //Route::resource('/employee_list',UserController::class);
            
            Route::get('/employee_list',[UserController::class,'employeeList']);

            Route::get('/employee/{id}',[EmployeeController::class,'index']);
    
            Route::put('/update_user_data/{id}',[UserController::class,'update']);
    
            Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);
    
            Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);
    
            Route::get('/user_list',[UserController::class,'index']);
    
            Route::get('/deactivated_list',[UserController::class,'deactivatedUser']);
    
            Route::get('/user_info/{id}',[UserController::class,'user_info']);
    
            Route::post('add_user',[UserController::class,'store']);
        
            Route::resource('/job',JobVacancyController::class);
            
            //Route::put('/job/{id}',[JobVacancyController::class,'update']);

            Route::get('/applicant_details',[ApplicantController::class,'index']);

            Route::get('/applicant_chart/{id}',[ApplicantController::class,'getApplicantChart']);
            
            Route::post('/accept_applicant',[ApplicantController::class,'acceptApplicant']);

            Route::post('/decline_applicant',[ApplicantController::class,'declineApplicant']);

            Route::post('/failed_applicant',[ApplicantController::class,'failedApplicant']);

            Route::post('/hire_applicant',[ApplicantController::class,'hireApplicant']);
            
            Route::post('/add_payslip',[EmployeeController::class,'addPayslip']);

            Route::get('active_employee/{id}',[EmployeeController::class,'activeEmployee']);

            Route::get('/recommendedlist',[ApplicantController::class,'recommended']);

            Route::resource('/event',EventController::class);

            Route::resource('/announcement',AnnouncementController::class);

    });



    Route::group([
        'prefix' => 'hr_assistant',
        'as' => 'hr_assistant',
        ],function(){
            
            Route::resource('/chat',ChatController::class);

            Route::get('/get_payslip/{id}',[EmployeeController::class,'getEmployeePayslip']);
            
            Route::post('/employee_get_dtr',[EmployeeController::class,'getEmployeeDTR']);

            Route::get('/chat_support',function(Request $request){
                return view('template.hr_assistant.chat_support');
            });

            Route::get('/employee_id/{id}',function(Request $request){
                return view('template.hr_assistant.employee_page');
            });

            Route::get('/',function(Request $request){
                return redirect('hr_assistant/home');
            })->name('hr_assistant_home');
    
            Route::get('/home',function(Request $request){
                return view('template.hr_assistant.index');
            });
    
            Route::get('/deactivated_users',function(){
                return view('template.hr_assistant.deactivated_users');
            });
    
            Route::get('/logout',function(Request $request){
                return redirect(route('logout'));
            });
    
            Route::get('/users',function(){
                return view('template.hr_assistant.users');
            });

            Route::get('/job_vacancies',function(){
                return view('template.hr_assistant.job_vacancies');
            });

            Route::get('/applicants',function(){
                return view('template.hr_assistant.applicant_list');
            });

            Route::get('/employees',function(){
                return view('template.hr_assistant.employee_list');
            });

            Route::get('/events_announcements',function(){
                return view('template.hr_assistant.events_announcement');
            });
    
            Route::get('/activate_user/{id}',[UserController::class,'activate']);

            //Route::resource('/employee_list',UserController::class);
            
            Route::get('/employee_list',[UserController::class,'employeeList']);

            Route::get('/employee/{id}',[EmployeeController::class,'index']);
    
            Route::put('/update_user_data/{id}',[UserController::class,'update']);
    
            Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);
    
            Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);
    
            Route::get('/user_list',[UserController::class,'index']);
    
            Route::get('/deactivated_list',[UserController::class,'deactivatedUser']);
    
            Route::get('/user_info/{id}',[UserController::class,'user_info']);
    
            Route::post('add_user',[UserController::class,'store']);
        
            Route::resource('/job',JobVacancyController::class);
            
            //Route::put('/job/{id}',[JobVacancyController::class,'update']);

            Route::get('/applicant_details',[ApplicantController::class,'index']);

            Route::get('/applicant_chart/{id}',[ApplicantController::class,'getApplicantChart']);
            
            Route::post('/accept_applicant',[ApplicantController::class,'acceptApplicant']);

            Route::post('/decline_applicant',[ApplicantController::class,'declineApplicant']);

            Route::post('/failed_applicant',[ApplicantController::class,'failedApplicant']);

            Route::post('/hire_applicant',[ApplicantController::class,'hireApplicant']);
            
            Route::post('/add_payslip',[EmployeeController::class,'addPayslip']);

            Route::get('active_employee/{id}',[EmployeeController::class,'activeEmployee']);

            Route::get('/recommendedlist',[ApplicantController::class,'recommended']);

            Route::resource('/event',EventController::class);

            Route::resource('/announcement',AnnouncementController::class);

    });


    Route::group([
        'prefix' => 'applicant',
        'as' => 'applicant',
        ],function(){
            
            Route::get('/logout',function(Request $request){
                return redirect(route('logout'));
            });

            Route::get('/',function(Request $request){
                return redirect('hr_head/home');
            })->name('hr_head_home');
    
            Route::get('/home',function(Request $request){
                return view('template.applicant.index');
            });

            Route::resource('/job',JobVacancyController::class);

            Route::post('/add_applicant_details',[ApplicantController::class,'applicantDetails']);

            Route::get('/applicant_details',[ApplicantController::class,'index']);

            Route::get('/user_applicant_details',[ApplicantController::class,'user']);

            Route::post('/upload_resume',[FileUploadController::class,'uploadResume']);

           
    });

    Route::group([
        'prefix' => 'employee',
        'as' => 'employee',
        ],function(){

            Route::get('/get_payslip/{id}',[EmployeeController::class,'getEmployeePayslip']);
            
            Route::get('/logout',function(Request $request){
                return redirect(route('logout'));
            });

            Route::get('/home',function(Request $request){
                return view('template.employee.index');
            });

            Route::get('/payslip',function(Request $request){
                return view('template.employee.payslip');
            });

            Route::post('/employee_dtr',[EmployeeController::class,'employeeDTR']);

            Route::get('/get_dtr',[EmployeeController::class,'getEmployeeDTR']);

            Route::get('/user_info/{id}',[UserController::class,'user_info']);

    });


});
    /*Route::post('/sendEmail',[EmailController::class,'send']);*/

/*Route::get('/invalidUser',function(){
    
    $data = [
        'status' => 'Invalid request.',
        'message' => 'Access denied.',
    ];

    //return response()->json($data);
    return redirect(route('base'));


})->name('invalidUser');*/










