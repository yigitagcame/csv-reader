<?php

namespace App\Services;

use App\Models\Csvfile as Csv;
use App\Models\Csvcolumn as Csvcolumn;

Class CsvSaverService {

    protected $parsedCsv;
    protected $fileID;

    public function __construct(Array $parsedCsv)
    {
        $this->parsedCsv = $parsedCsv;
    }

    public function insert(): Object {

        $this->fileSaver();

        return Csv::where('id',$this->fileID)->get();
    }

    public function update($id){

        $columnIds = Csvcolumn::where(["csvfile_id" => $id])->select('id')->pluck('id');

        $this->columnUpdater($columnIds);

        return Csv::where('id',$id)->get();

    }

    protected function fileSaver():void {
        $csvModel = Csv::create(["title" => $this->parsedCsv["fileName"]]);
        $this->fileID = $csvModel->id;
        $this->columnSaver();
    }

    protected function columnSaver(){
        $rowIndex = 0;

        foreach($this->parsedCsv["columns"] as $key => $column){

            $columnModel = Csvcolumn::create([
                "title" => $column,
                "csvfile_id" => $this->fileID,
                "isNumeric" => $this->parsedCsv["columnTypes"][$key]
            ]);

            $this->rowSaver($columnModel,$rowIndex);
            $rowIndex++;
        }
    }

    protected function columnUpdater($columnIds){
        $rowIndex = 0;

        foreach($columnIds as $id){

            $columnModel = Csvcolumn::where(["id" => $id])->with('rows')->first();
            $this->rowSaver($columnModel,$rowIndex);
            $rowIndex++;
        }
    }

    protected function rowSaver(Object $columnModel,int $rowIndex): Object{

        return $columnModel->rows()->createMany(
            array_map(function($row){
                return ["field" => $row];
        },$this->parsedCsv["rows"][$rowIndex]));

    }

}
