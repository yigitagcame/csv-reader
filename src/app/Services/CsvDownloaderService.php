<?php

namespace App\Services;

use App\Models\Csvcompute;

class CsvDownloaderService {

    protected $fileId;
    protected $responseHeaders;
    protected $columns;
    protected $rows;

    public function __construct($columns,$rows,$fileId){

        $this->fileId = $fileId;
        $computed = $this->getComputed();

        $this->columns = array_merge($columns,$computed["columns"]);
        $this->rows = array_map(null,...array_merge($rows,$computed["rows"]));

        return [$this->columns,$this->rows];

    }

    public function processCsv(){
            $file = fopen('php://output', 'w');
            fputcsv($file, $this->columns);

            foreach ($this->rows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
    }

    protected function getComputed(){

        $computed = [
            "columns" => [],
            "rows" => []
        ];

        $computations = Csvcompute::where(["csvfile_id" => $this->fileId])->get();

        if($computations){

            foreach($computations as $computation){

                $compute = (new GroupByComputeService($computation->group_by_column_id,$computation->compute_column_id));
                array_push($computed["columns"],$compute->getTitlesColumnName() ."($computation->calculation)",$compute->getEntitiesColumnName(). "($computation->calculation)");
                $computed["rows"] = array_merge($computed["rows"], $compute->compute($computation->calculation));

            }
        }

        return $computed;
    }
}
