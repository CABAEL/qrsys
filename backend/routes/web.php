<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\FilegroupsController;
use App\Models\Client;
use App\Models\File_upload;
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


//login routes
Route::post('login/login_post',[LoginController::class,'authenticate'])->name('login_post');

Route::get('/', function (Request $request) {
    return view('login');
})->name('portal');

Route::get('/login', function (Request $request) {
    return view('login');
})->middleware('role')->name('login');

Route::get('/register', function (Request $request) {
    return view('register');
});


Route::get('/login', function (Request $request) {
    return view('/login');
})->middleware('role')->name('login');


Route::get('/hash',[ApplicantController::class,'incrementalHash']);

Route::resource('/register/add_user',ApplicantController::class);

Route::get('/logout',[LogoutController::class,'logout_user'])->name('logout');

//portal get routes
Route::get('/portal_event',[EventController::class,'index']);
Route::get('/portal_announcement',[AnnouncementController::class,'index']);


Route::get('/fileviewer/{id}', function($id) {

    $file = File_upload::find($id);
    $client = Client::where('client_id',$file['client_id'])->first();

    $data = array(
        'filename' => $file['file_name'],
        'client_folder' => md5($client->client_name),
        'client_code' => $file->document_code,
        'logo' => $client->logo
    );

    if(!$file){
        return false;
    }
    return view('template.iframe_views.file_view', compact('data'));

});

Route::get('/verify_password', function() {
    return view('file_password');
});


// ->middleware(['auth']);

Route::middleware(['auth','role'])->group(function(){

    Route::group([                                           
        'prefix' => 'admin',
        'as' => 'admin',
        ],function(){
        
        Route::get('/',function(Request $request){
            return redirect('admin/home');
        })->name('admin_home');

        Route::get('/home',function(Request $request){
            return view('template.admin.index');
        });


        Route::get('/logout',function(Request $request){
            return redirect(route('logout'));
        });

        Route::post('/update_user_data/{id}',[UserController::class,'updateClient']);

        Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);

        Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);

        Route::get('/user_list',[UserController::class,'index']);

        Route::get('/user_info/{id}',[UserController::class,'user_info']);

        Route::post('add_client',[UserController::class,'storeClient']);

        Route::get('/active_clients',[UserController::class,'activeClients']);

        Route::get('/activate_user/{id}',[UserController::class,'activate']);

        Route::get('/totaluploads',[FileUploadController::class,'totalCount']);
    
    });

    Route::group([                                           
        'prefix' => 'client',
        'as' => 'client',
        ],function(){
        
        Route::get('/',function(Request $request){
            return redirect('client/home');
        })->name('client_home');

        Route::get('/home',function(Request $request){
            return view('template.client.index');
        });


        Route::get('/accounts',function(Request $request){
            return view('template.client.accounts');
        });

        Route::get('/filegroups', function(){
            return view('template.client.filegroups');
        });


        Route::get('/logout',function(Request $request){
            return redirect(route('logout'));
        });

        Route::post('/update_clientuser_data/{id}',[UserController::class,'updateClientUser']);

        Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);

        Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);

        Route::get('/user_list',[UserController::class,'index']);

        Route::get('/user_info/{id}',[UserController::class,'user_info']);

        Route::post('add_user',[UserController::class,'storeUser']);

        Route::get('/active_clients',[UserController::class,'activeClients']);

        Route::get('/active_client_users',[UserController::class,'activeClientUsers']);

        Route::post('/file_upload',[FileUploadController::class,'uploadFile']);

        Route::get('/file_groups',[FilegroupsController::class,'index']);

        Route::get('/show_filegroup/{id}',[FilegroupsController::class,'show']);

        Route::post('/add_filegroup',[FilegroupsController::class,'store']);

        Route::post('/update_filegroup/{id}',[FilegroupsController::class,'update']);
        
        Route::delete('/delete_filegroup/{id}',[FilegroupsController::class,'destroy']);

        Route::get('/activate_user/{id}',[UserController::class,'activate']);

        Route::get('/all_filegroups',[FilegroupsController::class,'showFilegroups']);

        Route::get('/clientfiles',[FileUploadController::class,'clientfileList']);

    });

});










