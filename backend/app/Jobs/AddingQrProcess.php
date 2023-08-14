<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\File_upload;
use App\Models\PDFcore;
use App\Models\Base;
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

                    if($get_client){
                        $outputFilePath = public_path(env('CLIENT_DIR_PATH').MD5($get_client->client_name).'/file_uploads/'.$file_data_value['file_name']);
                        $file_upload_data = File_upload::where('id',$file_data_value['id'])->first();

                        try{
                            $embedder = PDFcore::addQrToPdf($source_file,$outputFilePath,$file_upload_data->blob_qr);
                            //echo "embedder!".$embedder;
                            if($embedder){
                                
                                $this->updateExecute($file_data_value,$source_file);

                                $err = ['upload_success' => $source_file];
                                Base::writeToLogFile($err);
                                //do some logging
                            }else{
                                //do some convertion if embedder does not work.
                            }
                        }catch(\Exception $e){
                            $err = ['file_convert' => $file_data_value['file_name']];
                            Base::writeToLogFile($err);


                            $sc_output = storage_path('tmp').'\\'.'SC_'.time().$file_data_value['file_name'];

                            $command = sprintf(''.env('GS_HANDLER').' -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -o %s %s', $sc_output, $source_file);
                            exec($command,$output,$returnCode);

                            $outputFilePath = public_path(env('CLIENT_DIR_PATH').MD5($get_client->client_name).DIRECTORY_SEPARATOR.'file_uploads'.DIRECTORY_SEPARATOR.$file_data_value['file_name']);
                            
                            if ($returnCode === 0) {

                                // // // Add QR code to the modified PDF
                                $embedder = PDFcore::addQrToPdf($sc_output,$outputFilePath,$file_upload_data->blob_qr);
                                
                                if($embedder){
                            
                                    $this->updateExecute($file_data_value,$source_file);

                                    $err = ['upload_success' => $source_file];
                                    Base::writeToLogFile($err);
                                    //do some logging
                                    if(File::exists($sc_output)){
                                        File::delete($sc_output);
                                    }
                                    if(File::exists($source_file)){
                                        File::delete($source_file);
                                    }
                                }
                                

                                
                            }

                            continue;
                        }
                        // do some logging
                    }

                }
    
            }
        }catch(\Exception $e){
            echo $e;
        }

    }

    public function updateExecute($file_data_value,$source_file)
    {
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

        }else{
            $err = ['Update error' => $update];
            Base::writeToLogFile($err);
        }
    }

    public function checkPdfVersion($filePath)
    {

        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception("File does not exist or cannot be read.");
        }

        $pdfContent = file_get_contents($filePath);
        $hasVersionIndicator = strpos($pdfContent, '1.4') !== false;

        return !$hasVersionIndicator;
    }  

    public function failed(\Throwable $exception)
    {
        // Handle the failed job here
        // For example, re-queue the job for later execution
        $this->release(300); // Re-queue the job after 10 minutes (600 seconds)
    }

}
