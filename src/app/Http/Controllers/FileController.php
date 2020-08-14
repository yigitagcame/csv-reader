<?php

namespace App\Http\Controllers;

use App\Models\Csvfile as Csv;
use App\Models\Csvcolumn;

use App\Services\CsvSaverService;
use App\Services\ParserService;
use App\Services\CsvDownloaderService;

use App\Http\Requests\StoreCsvRequest;

class FileController extends Controller
{

    public function store(StoreCsvRequest $request){

        $file = $request->file('csv');

        $fileParsed = (new ParserService)->csv($file);
        $insert = (new CsvSaverService($fileParsed))->insert();

        if($insert){
            return response()->json(['message' => 'Your File succesfully saved!'], 200);
        }else{
            return response()->json(['message' => 'Error'], 500);
        }

    }

    public function show($id){

        Csv::findOrFail($id);

        $columnModel = Csvcolumn::where(["csvfile_id" => $id])->get();
        $columns = $columnModel->pluck('title')->toArray();
        $rows = $columnModel->pluck('row_names')->toArray();

        $fileName = 'file-' . date('d-m-Y-H:i:s').'.csv';

        $headers= array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $download = new CsvDownloaderService($columns,$rows,$id);

        return response()->streamDownload(function () use ($download){
            $download->processCsv();
        },$fileName, $headers);

    }

    public function update(StoreCsvRequest $request,$id){

        Csv::findOrFail($id);
        $file = $request->file('csv');

        $fileParsed = (new ParserService)->csv($file);
        $update = (new CsvSaverService($fileParsed))->update($id);

        if($update){
            return response()->json(['message' => 'Your File succesfully updated!'], 200);
        }else{
            return response()->json(['message' => 'Error'], 500);
        }


    }






}
