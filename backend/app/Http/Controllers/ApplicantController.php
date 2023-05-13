<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\User_profile;
use App\Models\Applicant_data;
use App\Models\Applicant_experiences;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $user = $request->id;
        if($request->id){
            $users = User_profile::
            join('applicant_datas', 'applicant_datas.user_id', '=', 'user_profiles.id')
            ->join('job_vacancies', 'job_vacancies.id', '=', 'applicant_datas.position_applied')
            ->select('*','applicant_datas.status AS application_status')
            ->where('user_id','=',$user)
            ->get(); 
        }else{
            $users = User_profile::
            join('applicant_datas', 'applicant_datas.user_id', '=', 'user_profiles.id')
            ->join('job_vacancies', 'job_vacancies.id', '=', 'applicant_datas.position_applied')
            ->select('*','applicant_datas.*', 'job_vacancies.name')
            ->where('applicant_datas.status','!=',2)//declined
            ->where('applicant_datas.status','!=',3)//failed
            ->where('applicant_datas.status','!=',4)//hired
            ->get();
   
        }


        $data = [
            'response_time' => LARAVEL_START,
            'count' => count($users),
            'data' => $users,
        ];

        return response()->json($data);
    }
    
    public function recommended(){

        $exp = Applicant_experiences::get('user_id');
        //return $exp;
        $users = User_profile::
        join('applicant_datas','applicant_datas.user_id', '=', 'user_profiles.id')
        ->join('job_vacancies', 'job_vacancies.id', '=', 'applicant_datas.position_applied')
        //->join('applicant_experiences', 'applicant_experiences.user_id', '=', 'user_profiles.id')
        ->select('*','applicant_datas.*', 'job_vacancies.name')
        ->whereIn('user_profiles.id',$exp)
        ->where('applicant_datas.status','!=',2)//declined
        ->where('applicant_datas.status','!=',3)//failed
        ->where('applicant_datas.status','!=',4)//hired
        ->get();

        //return $expinsert;
        $exp_data = array();
       foreach($users as $k => $v){
            $exp = Applicant_experiences::where('user_id','=',$users[$k]['user_id'])->get();
        
            $exp_data[$v['user_id']] = [
                //'user_id' => $users[$k]['user_id'],
                'count' => count($exp),
            ];
        }
        

        
        $data = [
            'response_time' => LARAVEL_START,
            'count' => count($users),
            'exp' =>$exp_data ,
            'user_data' => $users,
        ];

        return response()->json($data);

    }

    public function user(Request $request){

        //return $request->user()->id;
        return Applicant_data::where('user_id',$request->user()->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function acceptApplicant(Request $request)
    {
        $user_id = $request->id;
        $applicant_data = Applicant_data::where('user_id',$user_id)->update(['status'=>1]);

        $response = [
            'flag' => 1,
            'data' => $applicant_data,
            'message' => 'Applicant status updated!'
        ];

         

        return response()->json($response);

    }

    public function declineApplicant(Request $request)
    {
        $user_id = $request->id;
        $applicant_data = Applicant_data::where('user_id',$user_id)->update(['status'=>2]);

        $response = [
            'flag' => 1,
            'data' => $applicant_data,
            'message' => 'Applicant status updated!'
        ];

        return response()->json($response);

    }

    public function failedApplicant(Request $request)
    {
        $user_id = $request->id;

        $applicant_data = Applicant_data::where('user_id',$user_id)->update(['status' => 3]);

        $response = [
            'flag' => 1,
            'data' => $applicant_data,
            'message' => 'Applicant status updated!'
        ];

        return response()->json($response);

    }

    public function incrementalHash(){
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $base = strlen($charset);
        $result = '';
      
        $now = explode(' ', microtime())[1];
        while ($now >= $base){
          $i = $now % $base;
          $result = $charset[$i] . $result;
          $now /= $base;
        }
        return substr($result, -5);
    }

    public function hireApplicant(Request $request)
    {

        $user_id = $request->id;

        if($applicant_data = Applicant_data::where('user_id',$user_id)->update(['status' => 4])){

            $selected_applicant_data = Applicant_data::where('user_id',$user_id)->get();
            //return $selected_applicant_data[0]['id'] ;
            $update = User::find($user_id);
            $update->role = 'employee';
            $update->save();

            $date = date('Y');

            $employee_tbl = Employee::create([
                'user_id'=>$user_id,
                'employee_id'=>$this->incrementalHash().'-'.$user_id.'-'.$date,
                'start_date'=>date('Y-d-m H:i:s'),
                'applicant_data_id'=>$selected_applicant_data[0]['id'],
            ]);
    
            $response = [
                'flag' => 1,
                'employee_id' => $employee_tbl->employee_id,
                'message' => 'Applicant Hired!'
            ];
    
            return response()->json($response);

        }



    }
    public function store(Request $request)
    {


        $validated_user = $request->validate([
            'username' => 'unique:users,username|required|max:60',
            'password' => 'required|confirmed|max:60',
            'password_confirmation' => 'required',
            'fname' => 'required|max:60',
            'mname' => 'nullable|max:60',
            'lname' => 'required|max:60',
            'age' => 'required|integer',
            'address' => 'required',
            'gender' => 'required|max:1',
            'birthday' => 'required',
            'email' => 'required|email|max:60',
            'mobile_number' => 'required|numeric',
        ]);


        $merge_data = array();

        $request_user = User::create([
            'username' => $validated_user['username'],
            'password' => Hash::make($validated_user['password']),
        ]);

        $user_id = $request_user->id;
    
        $request_profile = User_profile::create([
            'id' => $user_id,
            'fname' => $validated_user['fname'],
            'mname' => $validated_user['mname'],
            'lname' => $validated_user['lname'],
            'age' => $validated_user['age'],
            'gender' => $validated_user['gender'],
            'birthday' => $validated_user['birthday'],
            'address' => $validated_user['address'],
            'mobile_number' => $validated_user['mobile_number'],
            'email' => $validated_user['email'],
        ]);


        $request_applicant = Applicant_data::create([
            'user_id' => $request_profile->id,
        ]);

        $merge_data = [
            'user' => $request_user,
            'user_profile' => $request_profile,
            'applicant_data' => $request_applicant
        ];

        $data = [
            'data' => $merge_data,
            'message' => 'User Created Successfully!'
        ];

        return response()->json($data);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function getApplicantChart($id)
    {
        $prending_applicants = Applicant_data::where('status','=',0)->get('created_at','status');
        $hired_applicants = Applicant_data::where('status','=',4)->get('created_at','status');
        //0 = pending 1 = accepted 2 = declined 3 = failed 4 = hired

        $data = array();
        $jan = $feb = $mar = $apr = $may = $jun = $jul = $aug = $sep = $oct = $nov = $dec =  0;           
        $jan1 = $feb1 = $mar1 = $apr1 = $may1 = $jun1 = $jul1 = $aug1 = $sep1 = $oct1 = $nov1 = $dec1 =  0;           
        
        foreach($prending_applicants as $k => $v){

          $date = date('d-m-Y', strtotime($v->created_at));
          
          $explode = explode('-',$date);

         //echo var_dump($explode);

          if($explode[2] == $id){
            $year = $explode[2];
            $month = $explode[1];
            
            if($year == $id){
                if($month == 1){
                    $jan += 1;
                  }
      
                  if($month == 2){
                    $feb += 1;
                  }
      
                  if($month == 3){
                    $mar += 1;
                  }
      
                  if($month == 4){
                    $apr += 1;
                  }
                  
                  if($month == 5){
                    $may += 1;
                  }
      
                  if($month == 6){
                    $jun += 1;
                  }
      
                  if($month == 7){
                    $jul += 1;
                  }
      
                  if($month == 8){
                    $aug += 1;
                  }
      
                  if($month == 9){
                    $sep += 1;
                  }
      
                  if($month == 10){
                    $oct += 1;
                  }
      
                  if($month == 11){
                    $nov += 1;
                  }
      
                  if($month == 12){
                    $dec += 1;
                  }
            }


          }
            

        }

        $data_pending = [
            $jan,
            $feb,
            $mar,
            $apr,
            $may,
            $jun,
            $jul,
            $aug,
            $sep,
            $oct,
            $nov,
            $dec,
        ];


        foreach($hired_applicants as $k => $v){

            $date1 = date('d-m-Y', strtotime($v->created_at));
            
            $explode1 = explode('-',$date1);
  
           //echo var_dump($explode);
  
            if($explode1[2] == $id){

              $year = $explode1[2];

              $month1 = $explode1[1];
              
            if($year == $id){

                if($month1 == 1){
                    $jan1 += 1;
                  }
      
                  if($month1 == 2){
                    $feb1 += 1;
                  }
      
                  if($month1 == 3){
                    $mar1 += 1;
                  }
      
                  if($month1 == 4){
                    $apr1 += 1;
                  }
                  
                  if($month1 == 5){
                    $may1 += 1;
                  }
      
                  if($month1 == 6){
                    $jun1 += 1;
                  }
      
                  if($month1 == 7){
                    $jul1 += 1;
                  }
      
                  if($month1 == 8){
                    $aug1 += 1;
                  }
      
                  if($month1 == 9){
                    $sep1 += 1;
                  }
      
                  if($month1 == 10){
                    $oct1 += 1;
                  }
      
                  if($month1 == 11){
                    $nov1 += 1;
                  }
      
                  if($month1 == 12){
                    $dec1 += 1;
                  }
            }

  
            }
              
          }


        $data_hired = [
            $jan1,
            $feb1,
            $mar1,
            $apr1,
            $may1,
            $jun1,
            $jul1,
            $aug1,
            $sep1,
            $oct1,
            $nov1,
            $dec1,
        ];

        $response = [
            'pending' => $data_pending,
            'hired' => $data_hired,
        ];

        return response()->json($response);

    }
    public function applicantDetails(Request $request)
    {

        $user_id = $request->user()->id;

        $validated_request = $request->validate([
            'position' => 'required',
            //'about_self' => 'required',
            'resume_file' => 'required',
        ]);

        if(isset($_FILES['resume_file']['name'])){
            
            /* Getting file name */
            $filename = $_FILES['resume_file']['name'];

            /* Location */
            $location = "upload/resume/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
         
            /* Valid extensions */
            $valid_extensions = array("pdf");
         
            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
               /* Upload file */
               if(move_uploaded_file($_FILES['resume_file']['tmp_name'],$location)){
                $user = $request->user()->id;
                //$qry = Applicant_data::where('user_id',$user)->update(['resume_link'=>$filename]);
                  $response = $location;
               }
            }
            

            $qry = Applicant_data::where('user_id',$user_id)->update([
                'position_applied' => $validated_request['position'],
                //'about_self' => $validated_request['about_self'],
                'resume_link' => $filename
            ]);

        if($qry){
            if(isset($request['prevcompany'])){
                foreach($request['prevcompany'] as $k => $v){

                    $add_applicant = Applicant_experiences::create([
                        'user_id' => $user_id,
                        'company_name' => $request['prevcompany'][$k],
                        'position' => $request['prevposition'][$k],
                        'from' => $request['from_date'][$k],
                        'to' => $request['to_date'][$k],
                    ]);
                }
            }


            $data = [
                'data' => $request,
                'message' => 'Application details created successfully!'
            ];
    
            return response()->json($data);
        }
            
        }


    }
}
