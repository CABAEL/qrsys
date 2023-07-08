<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//pdf processor packages
use setasign\Fpdi\Fpdi;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class PDFcore extends Model
{
    use HasFactory;


    public static function generateQrCode($cr_code_value,$logopath,$file_upload_id)
    {

        $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($cr_code_value)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->logoPath($logopath)
        ->logoResizeToWidth(50)
        ->logoPunchoutBackground(true)
        ->labelText('INTELODOCS')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->validateResult(false)
        ->build();


        $imageData = $result->getString();
        $blobData = base64_encode($imageData);

        $file = File_upload::where('id',$file_upload_id)->update([
            'blob_qr' => $blobData
        ]);


        //$result->saveToFile(public_path('test/qrtest.png'));
    }
    

    public function convertPDFwithQR()
    {
        $pdf = new Fpdi();
        //$pdf->setSourceFile(public_path('test/SAMPLEPDF.pdf'));
        $pdf->setSourceFile("D:\SAMPLEPDF.pdf");
    
        // Iterate through each page of the PDF
        //$totalPages = $pdf->setSourceFile(public_path('test/SAMPLEPDF.pdf'));
        $totalPages = $pdf->setSourceFile("D:\SAMPLEPDF.pdf");
        for ($pageNo = 1; $pageNo <= $totalPages; $pageNo++) {
            // Import the current page
            $templateId = $pdf->importPage($pageNo);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
    
            // Set the watermark image
            $watermarkImagePath = "https://cdn.britannica.com/17/155017-050-9AC96FC8/Example-QR-code.jpg";
    
            $pageWidth = $pdf->getPageWidth() * (97 / 100);
            $pageHeight = $pdf->getPageHeight() * (97 / 100);
    
            // Determine the available width and height of the PDF viewer's layout
            $availableWidth = $pageWidth;
            $availableHeight = $pageHeight;
    
            // Define the maximum width and height for the watermark image
            $maxWidth = 15;
            $maxHeight = 15;
    
            // Calculate the scale factor for resizing the watermark image
            $scaleWidth = $availableWidth / $maxWidth;
            $scaleHeight = $availableHeight / $maxHeight;
            $scaleFactor = min($scaleWidth, $scaleHeight);
    
            // Calculate the new width and height for the watermark image
            $newWidth = $maxWidth;
            $newHeight = $maxHeight;
    
            // Calculate the new position for the watermark image
            $newX = $pageWidth - $newWidth;
            $newY = $pageHeight - $newHeight;
    
            // Display the adjusted watermark image
            $pdf->Image($watermarkImagePath, $newX, $newY, $newWidth, $newHeight);
        }
    
        $pdf->Output(public_path('test/file_encodedsss.pdf'), 'F');
    
        // Optionally, you can return a response or redirect to the generated PDF file.
    }


    public function mergePDFs()
    {
        $pdf = new Fpdi();

        $files = [
            public_path('test/1.pdf'),
            public_path('test/2.pdf'),
            // Add additional file paths here
        ];

        foreach ($files as $file) {
            $pageCount = $pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo, '/MediaBox');
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
        }

        $outputFilename = '';

        $pdf->Output(public_path('test/merged.pdf'), 'F');

        //return response()->download($outputFilename)->deleteFileAfterSend();
    }



}
