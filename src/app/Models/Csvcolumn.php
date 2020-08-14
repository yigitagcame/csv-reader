<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Csvcolumn extends Model
{
    protected $table = 'csv_columns';
    protected $fillable = ["title","isNumeric","csvfile_id"];
    protected $appends = ['row_names'];

    public function rows(){
        return $this->hasMany(Csvrow::class,"csvcolumn_id","id");
    }

    public function getRowNamesAttribute()
    {
        return $this->rows->pluck('field');
    }
}
