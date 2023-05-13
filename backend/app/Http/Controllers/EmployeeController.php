<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use App\Models\User_profile;
use App\Models\Dtr_employee;
use App\Models\Payslip_record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employee_id = $request->id;

        $qry = User::join('user_profiles', 'users.id', '=', 'user_profiles.id')
        ->join('employees','employees.user_id','=','users.id')
        ->where('employees.employee_id','=',$employee_id)
        ->get();

        return $qry;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function employeeDTR(Request $request)
    {

        $user_id = $request->user()->id;

        $validated_request = $request->validate([
            'time' => 'required',
        ]);

        $today = date('Y-m-d');

        $find_dtr_today = Dtr_employee::
        where('user_id','=',$user_id)
        ->where('time_out','=',NULL)
        ->where('created_at', 'like', '%' . $today . '%')->get();

        //return count($find_dtr_today);
        
        if(count($find_dtr_today) == 0){

            $qry = Dtr_employee::create([
                'user_id' => $user_id,
                'time_in' => $validated_request['time'],
            ]);
    
            if($qry){
    
                $response = [
                    'flag' => 1,
                    'message' => 'Time-in recorded successfully!'
                ];
    
            }

        }else{

            $dtr_id = $find_dtr_today[0]->id;

            $dtr = Dtr_employee::find($dtr_id);

            $dtr->time_out = $validated_request['time'];
            $dtr->save();

            $response = [
                'flag' => 1,
                'message' => 'Time-out recorded successfully!'
            ];
        }

        return response()->json($response);


    }

    public function store(Request $request)
    {
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee_id = $id;

        $qry = User::join('user_profiles', 'users.id', '=', 'user_profiles.id')
        ->join('employees','employees.user_id','=','users.id')
        ->where('employees.employee_id','=',$employee_id)
        ->get();

        return $qry;
    }

    public function addPayslip(Request $request)
    {

        $validated_request = $request->validate([
            'from' => 'required',
            'to' => 'required',
            'payslip' => 'required',
        ]);

        if(isset($_FILES['payslip']['name'])){
            $user = $request->user_id;
            /* Getting file name */
            $filename = hash('sha256',$_FILES['payslip']['name'].$user.'_'.date('Y:m:d H:i:s')).".pdf";
            
            //return $filename;

            /* Location */
            $location = "upload/payslip/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
         
            /* Valid extensions */
            $valid_extensions = array("pdf");
         
            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
               /* Upload file */
               if(move_uploaded_file($_FILES['payslip']['tmp_name'],$location)){
               
                $qry = Payslip_record::create([
                    'user_id' => $user,
                    'from' => $validated_request['from'],
                    'to' => $validated_request['to'],
                    'filename' => $filename,
                ]);
               }
            }
        

        if($qry){
            $data = [
                'data' => $request,
                'message' => 'Payslip Uploaded!'
            ];
    
            return response()->json($data);
        }
            
        }
    }

    public function getEmployeePayslip($id)
    {
       // return $id;
        $request = Payslip_record::where('user_id','=',$id)->get();

        if($request){
            $data = [
                'response_time' => LARAVEL_START,
                'data' => $request,
            ];
    
            return response()->json($data);
        }


    }

    public function getEmployeeDTR(Request $request)
    {
        $user_id = Auth::id();
        //return $user_id;
        if(isset($request->user_id)){
            $user_id = $request->user_id;
        }

        if($user_id){
            $db_request = Dtr_employee::where('user_id','=',$user_id)->orderBy('created_at','DESC')->get();

        }else{
            $db_request =  Dtr_employee::all($user_id);
        }

        $response = [
            'data' => $db_request,
            'message' => 'Data fetched successfully!'
        ];

        return response()->json($response);

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
        //
    }

    public function activeEmployee($id)
    {

        $employees = Employee::where('end_date','=',null)->get();
        
        
        $data = array();
        $jan = $feb = $mar = $apr = $may = $jun = $jul = $aug = $sep = $oct = $nov = $dec =  0;
        foreach($employees as $k => $v){

            $data [] = [
                'user_id' => $v->user_id,
            ];


            $employee_dtr = Dtr_employee::where('user_id','=',$v->user_id)->get();
            $dtr_count = array();
            $months = array();
            foreach($employee_dtr as $employee_row){

                $date = $employee_row['created_at']->format('Y-m-d H:i:s');

                $explode = explode('-',$date);
    
                $year = $explode[0];
                $month = $explode[1];

                if($year === $id){

                    $dtr_count[] = $employee_row['user_id'];


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
                $months = [
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
                
            }
            $data[$k]['dtr_count'] = count($dtr_count);
            $data[$k]['months'] = $months;
            $jan = $feb = $mar = $apr = $may = $jun = $jul = $aug = $sep = $oct = $nov = $dec =  0;   
        }
        //end of each employee
        return $data;
        //return $employees;

    }
}
