<?php

namespace App\Services;

Class ParserService {

    protected $csvFile;
    protected $parsedCsv = [];
    protected $columns;
    protected $columnTypes;
    protected $rows;

    public function csv(Object $file): array {

        $this->csvFile = file($file->getRealPath());
        $this->parseCsv();

        $fileName = $file->getClientOriginalName();

        $this->columns = $this->getColumns();
        $this->rows = $this->getRows();
        $this->columnTypes = $this->getColumnTypes();

        return [
            "fileName" => $fileName,
            "columns" => $this->columns,
            "columnTypes" => $this->columnTypes,
            "rows" => $this->rows
        ];
    }

    protected function parseCsv(): void{

        foreach ($this->csvFile as $line) {
            $this->parsedCsv[] = str_getcsv($line);
        }

    }

    protected function getColumns(){
        return $this->parsedCsv[0];
    }

    public function getRows(){
        return array_map(NULL, ...array_slice($this->parsedCsv,1));
    }

    public function getColumnTypes(){

        $types = [];

        foreach($this->rows as $row){

            $filtred = array_filter($row,function($field){
                return is_numeric($field);
            });

            $types[] = $filtred == $row;
        }

        return $types;
    }


}
