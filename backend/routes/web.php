<?php

use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientUsersController;
use App\Http\Controllers\Document_CodeController;
use App\Http\Controllers\FilegroupsController;
use App\Http\Controllers\JobsDispatcherController;
use App\Http\Controllers\MyaccountController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReportsController;
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


//login routes
Route::post('login/login_post',[LoginController::class,'authenticate'])->name('login_post');

Route::get('/test_redis', function (Request $request) {

    $data = "test";
    $date_today = date('Y-m-d');


    //return storage_path('tmp');
    //return RedisModel::updateQueueData(array(['id'=>'test2','file_name'=>'test']));
});

Route::get('/', function (Request $request) {
    return view('/login');
})->middleware('check_login')->name('base');

Route::get('/login', function (Request $request) {
    return view('/login');
})->middleware('role')->name('login');


Route::get('/hash',[ApplicantController::class,'incrementalHash']);

Route::resource('/register/add_user',ApplicantController::class);

Route::get('/logout',[LogoutController::class,'logout_user'])->name('logout');


//file Viewer Routes
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

Route::get('/upload-pdf', [PDFController::class, 'addQrDummy'])->name('upload.pdf');


Route::middleware(['auth','role'])->group(function(){

    Route::group([                                           
        'prefix' => 'admin',
        'as' => 'admin',
        ],function(){
        
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

        Route::get('/active_clients',[ClientController::class,'activeClients']);

        Route::get('/activate_user/{id}',[UserController::class,'activate']);

        Route::get('/totaluploads',[FileUploadController::class,'totalCount']);

        Route::post('add_admin',[AdminUsersController::class,'store']);

        Route::post('/update_adminuser_data/{id}',[AdminUsersController::class,'updateAdminUser']);
    
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

        Route::get('/filecollections',function(){
            return view('template.client.filecollections');
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
    }
    
    $files = File_upload::select('file_uploads.*', 'users.username');
    $files->join('users', 'file_uploads.uploaded_by', '=', 'users.id');
    $files->orderBy('file_uploads.created_at','DESC');

    foreach ($conditions as $condition) {
        $files->where(...$condition);
    }
    
    $files = $files->paginate(1);
    

    return view('template.iframe_views.search_result',compact('files'));
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

Route::get('/client_report', [ReportsController::class,'clientReports'])->middleware('auth')->name('client_report');

Route::get('/download_client_report', [ReportsController::class,'generateClientReport'])->middleware('auth')->name('download_client_report');







