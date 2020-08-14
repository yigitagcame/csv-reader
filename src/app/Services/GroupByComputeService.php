<?php

namespace App\Services;

use App\Models\Csvrow;
use App\Models\Csvcolumn;

class GroupByComputeService{

    protected $titles;
    protected $entities;
    protected $grouped = [];
    protected $titlesColumName;
    protected $entityTableColumnName;

    public function __construct(int $titleColumn,int $entityTable)
    {
        $this->titles = Csvrow::where(["csvcolumn_id" => $titleColumn])->select('field')->get()->pluck('field')->toArray();
        $this->entities = Csvrow::where(["csvcolumn_id" => $entityTable])->select('field')->get()->pluck('field')->toArray();

        $this->titlesColumName = Csvcolumn::find($titleColumn)->title;
        $this->entityTableColumnName = Csvcolumn::find($entityTable)->title;

    }

    public function compute($calculation) : array
    {
        foreach ($this->titles as $key => $val) {
            $this->grouped[$val][] = $this->entities[$key];
        }

        $computedGroup =  array_map(function($entity) use ($calculation){
            return $this->$calculation($entity);
        },$this->grouped);

        return [
            array_keys($computedGroup),
            array_values($computedGroup),
        ];

    }

    protected function min(array $array): int {
        return min($array);
    }

    protected function max(array $array): int {
        return max($array);
    }

    protected function sum(array $array): int {
        return array_sum($array);
    }

    protected function count(array $array): int {
        return count($array);
    }

    protected function avg(array $array): int {
        return array_sum($array) / count($array);
    }

    public function getTitlesColumnName(){
        return $this->titlesColumName;
    }

    public function getEntitiesColumnName(){
        return $this->entityTableColumnName;
    }

    public function getBothColumn(){
        return [$this->titlesColumName,$this->entityTableColumnName];
    }

    public function columnSize(){
        return count($this->entities);
    }


}
