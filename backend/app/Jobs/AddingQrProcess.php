<?php

namespace App\Jobs;

use App\Models\File_upload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddingQrProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //get all redis data to update

        // $files = File_upload::where('status',0)->get();

        // foreach($files as $file){
        //     File_upload::where('id',$file['id'])->update(['status' => 1]);
        // }
        //
    }

    public function failed(\Throwable $exception)
    {
        // Handle the failed job here
        // For example, re-queue the job for later execution
        $this->release(300); // Re-queue the job after 10 minutes (600 seconds)
    }

}
