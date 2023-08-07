<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\File_upload;
use App\Models\PDFcore;
use App\Models\RedisModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\Constraint\ExceptionMessage;
use Illuminate\Support\Facades\File;

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
        $file_container = RedisModel::fetchFormattedData();
        try{
            if(!empty($file_container)){
                foreach($file_container as $file_data_value){
    
                    $source_file = storage_path('tmp').'\\'.$file_data_value['file_name'];
                    $get_client = Client::where('client_id',$file_data_value['client_id'])->first();
                    $outputFilePath = public_path(env('CLIENT_DIR_PATH').MD5($get_client->client_name).'/file_uploads/'.$file_data_value['file_name']);
                    $file_upload_data = File_upload::where('id',$file_data_value['id'])->first();

                    try{
                        $embedder = PDFcore::addQrToPdf($source_file,$outputFilePath,$file_upload_data->blob_qr);
                        //echo "embedder!".$embedder;
                        if($embedder){
                            
                            $update = File_upload::where('id',$file_data_value['id'])->update(['status' => 1]);
                            
                            if($update){
        
                                //get array redis data
                                $re_fetch_redis_data = RedisModel::fetchFormattedData();
                                unset($re_fetch_redis_data[$file_data_value['id']]);
        
                                //set Redis
                                if(RedisModel::setData(json_encode($re_fetch_redis_data))){
                                    if (File::exists($source_file)) {
                                        File::delete($source_file);
                                    }
                                }

                            }
                            //do some logging
                        }else{
                            //do some logging
                        }
                    }catch(\Exception $e){
                        echo $e;
                    }

                }
    
            }
        }catch(\Exception $e){
            echo $e;
        }

    }

    public function failed(\Throwable $exception)
    {
        // Handle the failed job here
        // For example, re-queue the job for later execution
        $this->release(300); // Re-queue the job after 10 minutes (600 seconds)
    }

}
