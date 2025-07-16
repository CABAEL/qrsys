<?php

use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AppAccessController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientUsersController;
use App\Http\Controllers\Document_CodeController;
use App\Http\Controllers\FilegroupsController;
use App\Http\Controllers\FilePasswordController;
use App\Http\Controllers\JobsDispatcherController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MyaccountController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReportsController;
use App\Jobs\TestLogJob;
use App\Models\App_key;
use App\Models\Base;
use App\Models\Client;
use App\Models\File_upload;
use App\Models\RedisModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\FileUploadController;

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

Route::get('/debug-queue', function () {
    return [
        'env' => env('QUEUE_CONNECTION'),
        'config' => config('queue.default'),
    ];
});

Route::get('/test-job', function () {
    TestLogJob::dispatch();
    return 'TestJob dispatched!';
});


//login routes
Route::post('login/login_post',[LoginController::class,'authenticate'])->name('login_post');

Route::get('/test_redis', function (Request $request) {

    return base64_encode("1");

    //return storage_path('tmp');
    //return RedisModel::updateQueueData(array(['id'=>'test2','file_name'=>'test']));
});

Route::get('/', function (Request $request) {
    return view('/login');
})->middleware('check_login')->name('base');

Route::get('/login', function (Request $request) {
    return view('/login');
})->middleware('role')->name('login');

Route::get('/logout',[LogoutController::class,'logout_user'])->name('logout');


//file Viewer Routes
Route::get('/fileviewer/{id}', function($id) {

    $file = File_upload::find($id);
    $client = Client::where('client_id',$file['client_id'])->first();

    $data = array(
        'filename' => $file['file_name'],
        'client_folder' => md5($client->client_name),
        'client_code' => $file->document_code,
        'logo' => $client->logo,
        'file_password' => ($file->password != '') ? true : false,
        'file_id' => $id
    );

    if(!$file){
        return false;
    }
    return view('template.iframe_views.file_view', compact('data'));

});


Route::get('/view_file_data/{id}', function($id) {

    $file = File_upload::where('id',$id)->select('client_id','id','file_name','description','password','document_code')
    ->first();

    return $file;

})->middleware('auth');

Route::post('/save_file_data/{id}',[FileUploadController::class,'saveFileData'])->middleware('auth');

Route::get('/view_file_delete/{id}', [FileUploadController::class,'DeleteFile'])->middleware('auth');

Route::get('/fileviewerupdate/{id}', function($id) {
    return $id;
    // $file = File_upload::find($id);
    // $client = Client::where('client_id',$file['client_id'])->first();

    // $data = array(
    //     'filename' => $file['file_name'],
    //     'client_folder' => md5($client->client_name),
    //     'client_code' => $file->document_code,
    //     'logo' => $client->logo,
    //     'file_password' => ($file->password != '') ? true : false,
    //     'file_id' => $id
    // );

    // if(!$file){
    //     return false;
    // }
    // return view('template.iframe_views.file_view', compact('data'));

});

Route::get('/verify_password/{id}', [FilePasswordController::class,'VerifyFilePassword'])->name('file_password_verify');


Route::post('/submit_file_password/{id}',[FilePasswordController::class,'submitFilePassword'])->name('submitFilePassword');

Route::get('/upload-pdf', [PDFController::class, 'addQrDummy'])->name('upload.pdf');


Route::middleware(['auth','role'])->group(function(){

    Route::group([                                           
        'prefix' => 'admin',
        'as' => 'admin',
        ],function(){

        //search client
        Route::get('/search_clients',[ClientController::class,'searchClients'])->name('searchClients');

        Route::get('/',function(Request $request){
            return redirect('admin/home');
        })->name('admin_home');

        Route::get('/adminaccounts',function(Request $request){
            return view('template.admin.admin_accounts');
        });

        Route::get('/home',function(Request $request){
            return view('template.admin.index');
        });

        Route::get('/api_access',function(Request $request){
            return view('template.admin.api');
        });

        Route::get('/reports',function(Request $request){
            return view('template.admin.reports');
        });


        Route::get('/logout',function(Request $request){
            return redirect(route('logout'));
        });

        Route::post('/update_user_data/{id}',[UserController::class,'updateClient']);

        Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);

        Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);

        Route::get('/user_list',[UserController::class,'index']);

        Route::get('/admin_list',[AdminUsersController::class,'adminList']);

        Route::get('/user_info/{id}',[UserController::class,'user_info']);

        Route::post('add_client',[ClientController::class,'storeClient']);

        Route::POST('/add_access_key',[AppAccessController::class,'addAccessKey'])->name('add_access_key');

        Route::get('/active_clients',[ClientController::class,'activeClients'])->name('activeClients');

        Route::get('/activate_user/{id}',[UserController::class,'activate']);

        Route::get('/totaluploads',[FileUploadController::class,'totalCount']);

        Route::post('add_admin',[AdminUsersController::class,'store']);

        Route::post('/update_adminuser_data/{id}',[AdminUsersController::class,'updateAdminUser']);

        Route::get('/logs', [LogsController::class,'adminLogView'])->middleware('auth')->name('adminLogView');

        Route::get('/api_key_list', [AppAccessController::class,'apiKeys'])->middleware('auth')->name('apiKeys');

        Route::get('/show_app_key/{id}', [AppAccessController::class,'showAppKey'])->middleware('auth')->name('showAppKeys');
        
        Route::post('/update_access_key/{id}', [AppAccessController::class,'updateAppKey'])->middleware('auth')->name('updateAppKey');

        Route::delete('/confirm_delete_api_access/{id}', [AppAccessController::class,'destroy'])->middleware('auth')->name('destroyApiAccess');
    
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

        Route::get('/reports',function(Request $request){
            return view('template.client.reports');
        });

        Route::post('/update_clientuser_data/{id}',[ClientUsersController::class,'updateClientUser']);

        Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);

        Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);

        Route::get('/user_list',[UserController::class,'index']);

        Route::get('/user_info/{id}',[ClientUsersController::class,'show']);

        Route::post('add_user',[UserController::class,'storeUser']);

        Route::get('/active_clients',[ClientController::class,'activeClients']);

        Route::get('/active_client_users',[ClientUsersController::class,'activeClientUsers']);

        Route::post('/file_upload',[FileUploadController::class,'uploadFile']);

        Route::get('/file_groups',[FilegroupsController::class,'index']);

        Route::get('/show_filegroup/{id}',[FilegroupsController::class,'show']);

        Route::post('/add_filegroup',[FilegroupsController::class,'store']);

        Route::post('/update_filegroup/{id}',[FilegroupsController::class,'update']);
        
        Route::delete('/delete_filegroup/{id}',[FilegroupsController::class,'destroy']);

        Route::get('/activate_user/{id}',[UserController::class,'activate']);

        Route::get('/all_filegroups',[FilegroupsController::class,'showFilegroups']);

        Route::get('/clientfiles',[FileUploadController::class,'clientfileList']);

        Route::get('/logs', [LogsController::class,'clientLogView'])->middleware('auth')->name('clientLogView');

        Route::get('/filecollections',function(){
            return view('template.client.filecollections');
        });

    });


    Route::group([                                           
        'prefix' => 'user',
        'as' => 'user',
        ],function(){
        
        Route::get('/',function(Request $request){
            return redirect('user/home');
        })->name('user_home');

        Route::get('/home',function(Request $request){
            return view('template.user.index');
        });


        Route::get('/accounts',function(Request $request){
            return view('template.user.accounts');
        });

        Route::get('/filegroups', function(){
            return view('template.user.filegroups');
        });


        Route::get('/logout',function(Request $request){
            return redirect(route('logout'));
        });

        Route::post('/update_clientuser_data/{id}',[ClientUsersController::class,'updateClientUser']);

        Route::put('/confirm_deactivate/{id}',[UserController::class,'deactivateUser']);

        Route::delete('/confirm_delete/{id}',[UserController::class,'destroy']);

        Route::get('/user_list',[UserController::class,'index']);

        Route::get('/user_info/{id}',[ClientUsersController::class,'show']);

        Route::get('/active_clients',[ClientController::class,'activeClients']);

        Route::get('/active_client_users',[ClientUsersController::class,'activeClientUsers']);

        Route::post('/file_upload',[FileUploadController::class,'uploadFile']);

        Route::get('/file_groups',[FilegroupsController::class,'index']);

        Route::get('/show_filegroup/{id}',[FilegroupsController::class,'show']);

        Route::post('/add_filegroup',[FilegroupsController::class,'store']);
        
        Route::delete('/delete_filegroup/{id}',[FilegroupsController::class,'destroy']);

        Route::get('/activate_user/{id}',[UserController::class,'activate']);

        Route::get('/all_filegroups',[FilegroupsController::class,'showFilegroups']);

        Route::get('/filecollections',function(){
            return view('template.user.filecollections');
        });

    });


});

Route::get('/document_code/{id}',[Document_CodeController::class,'CodeDocuments'])
->middleware('auth')
->name('code_document_list');

Route::get('/code_list',[Document_CodeController::class,'list'])
->middleware('auth')
->name('code_list');


Route::get('/file_list',function(){

    $current_user_auth = Auth::user();
    $conditions = array(
        ["file_uploads.status", '=', 1]
    );
    
    $search = \Request::get('search');

    if(isset($search)){
        $conditions[] = ["file_uploads.file_name", 'LIKE', '%' . $search . '%'];
    }

    if ($current_user_auth->role == 'client') {

        $current_user = $current_user_auth->client_data;
        $current_user_id = $current_user['client_id'];
        $conditions[] = ["file_uploads.client_id", '=', $current_user_id];

    } else if ($current_user_auth->role == 'user') {

        $current_user = $current_user_auth->client_users_data;
        $current_user_id = $current_user['client_id'];
        $conditions[] = ["file_uploads.client_id", '=', $current_user_id];
        $conditions[] = ["file_uploads.file_group_id", '=', $current_user->file_group_id];
    }
    
    $files = File_upload::select('file_uploads.*', 'users.username');
    $files->join('users', 'file_uploads.uploaded_by', '=', 'users.id');

    foreach ($conditions as $condition) {
        $files->where(...$condition);
    }
    $files->orderBy('file_uploads.created_at','DESC');
    
    $files = $files->paginate(20);
    

    return view('template.iframe_views.file_list',compact('files'));
})
->middleware('auth')
->name('file_list');


Route::get('/search_result',function(){

    $current_user_auth = Auth::user();
    $conditions = array(
        ["file_uploads.status", '=', 1]
    );
    
    $search = \Request::get('search');

    if(isset($search)){
        $conditions[] = ["file_uploads.file_name", 'LIKE', '%' . $search . '%'];
    }

    if ($current_user_auth->role == 'client') {

        $current_user = $current_user_auth->client_data;
        $current_user_id = $current_user['client_id'];
        $conditions[] = ["file_uploads.client_id", '=', $current_user_id];

    } else if ($current_user_auth->role == 'user') {

        $current_user = $current_user_auth->client_users_data;
        $current_user_id = $current_user['client_id'];
        
        $conditions[] = ["file_uploads.client_id", '=', $current_user_id];
        $conditions[] = ["file_uploads.file_group_id", '=', $current_user->file_group_id];

    }
    
    $files = File_upload::select('file_uploads.*', 'users.username');
    $files->join('users', 'file_uploads.uploaded_by', '=', 'users.id');
    $files->orderBy('file_uploads.created_at','DESC');

    foreach ($conditions as $condition) {
        $files->where(...$condition);
    }
    
    $files = $files->paginate(10);
    

    return view('template.iframe_views.search_result',compact('files','search'));
})
->middleware('auth')
->name('file_list');


Route::get('/my_account_view/{id}',[UserController::class,'myAccountView'])->middleware('auth');

Route::post('/update_my_acc',[MyaccountController::class,'update'])->middleware('auth');

Route::get('/change_my_password/{id}',function(){
    return view('change_password');
});

//dispatch routes for job
Route::get('dispatch_job',[JobsDispatcherController::class,'dispatchFiles']);


//change password route 
Route::post('changePass',[LoginController::class,'changePass'])->name('changePass');

//graph
Route::get('system_usage_graph',[ReportsController::class,'systemUsageGraph'])->name('systemUsageGraph')->middleware('auth');


//reports
Route::get('/client_report', [ReportsController::class,'clientReports'])->middleware('auth')->name('client_report');
Route::get('/user_report', [ReportsController::class,'userReports'])->middleware('auth')->name('user_report');

Route::get('/download_client_report', [ReportsController::class,'generateClientReport'])->middleware('auth')->name('download_client_report');
Route::get('/download_user_report', [ReportsController::class,'generateUserReport'])->middleware('auth')->name('download_user_report');


//greetings route
Route::get('/greetings', [MyaccountController::class,'Greetings'])->middleware('auth')->name('download_user_report');

//file_info
Route::get('/file_info/{id}',[FileUploadController::class,'fileInfo'])->name('fileInfo');








