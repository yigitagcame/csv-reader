<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Csvrow extends Model
{
    protected $table = 'csv_rows';
    protected $fillable = ["field"];

    public function column(){
        return $this->belongsTo(Csvcolumn::class,"csvcolumn_id","id");
    }
}
