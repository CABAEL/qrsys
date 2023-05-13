<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job_vacancy;
use Illuminate\Support\Facades\URL;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->id){
            $request = Job_vacancy::find($request->id);
            return response()->json($request);
        }else{
            $request = Job_vacancy::all();
        
            $data = [
                'response_time' => LARAVEL_START,
                'count' => count($request),
                'data' => $request,
            ];
    
            return response()->json($data);
        }


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
    public function store(Request $request)
    {
        //return $request;
        $validated_request = $request->validate([
            'name' => 'unique:job_vacancies,name|required',
            'description' => 'required',
        ]);

        $insert = Job_vacancy::create([
            'name' => $validated_request['name'],
            'description' => $validated_request['description'],
        ]);

        $response = [
            'flag' => 1,
            'data' => $insert,
            'message' => "Job successfully posted!"
        ];

        return response()->json($response);

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
    public function update(Request $request,$id)
    {
        $job_id = $id;
        $qry = Job_vacancy::find($job_id);

        //return $qry->name;

        if($qry->name == $request->update_name){
            $validated_request = $request->validate([
                'update_name' => 'required',
                'update_description' => 'required',
            ]);

        }else{
            $validated_request = $request->validate([
                'update_name' => 'unique:job_vacancies,name|required',
                'update_description' => 'required',
            ]);
        }
        $qry->name = $validated_request['update_name'];
        $qry->description = $validated_request['update_description'];
        if($qry->save()){
                
            $response = [
                'flag' => 1,
                'message' => 'Job updated!',
            ];

            return response()->json($response);

        }

        //return $request;


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qry = Job_vacancy::destroy($id);

        if($qry){
            $response = [
                'flag' => 1,
                'message' => 'Job deleted!',
            ];

            return response()->json($response);
        }
        
    }
}
