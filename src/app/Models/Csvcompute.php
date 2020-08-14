<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Csvcompute extends Model
{
    protected $table = 'csv_computes';
    protected $fillable = ["calculation","compute_column_id","group_by_column_id","csvfile_id"];

    public function computeColumn(){
        return $this->belongsTo(Csvcolumn::class,"compute_column_id","id");
    }

    public function groupByColumn(){
        return $this->belongsTo(Csvcolumn::class,"group_by_column_id","id");
    }
}
