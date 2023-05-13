<?php

namespace App\Http\Controllers;

use App\Mail\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function date2Qtr(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $query_date = $request->query_date;

        //format date to Y-m-d
        $formatted_start_date = date("Y-m-d", $start_date);
        $formatted_end_date = date("Y-m-d", $end_date);
        $formatted_query_date = date("Y-m-d", $query_date);

        //date to array
        $process_explode_start_date = explode('-',$formatted_start_date);
        $process_explode_end_date = explode('-',$formatted_end_date);
        $process_explode_query_date = explode('-',$formatted_query_date);

        //month to identify quarter
        $start_date_month = $process_explode_start_date[1];
        $end_date_month = $process_explode_end_date[1];
        $query_date_month = $process_explode_query_date[1];
        
        $start_date_qtr = ceil($start_date_month / 3);
        $end_date_qtr = ceil($end_date_month / 3);
        $query_date_qtr = ceil($query_date_month / 3);


        $date = [
            'start_date' =>$start_date_qtr ,
            'end_date' =>$end_date_qtr,
            'query_date' =>$query_date_qtr,
        ];

        // json res data
        return response()->json($date);

    }

    public function send(Request $request){

        if(Mail::to($request->emailto)->send(new NewUser())){

            $data = [
                'message' => 'Email sent!',
                'status' => 200,
            ];
            
            return $data;
        }

    }
}
