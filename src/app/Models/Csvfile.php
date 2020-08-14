<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Csvfile extends Model
{
    protected $table = 'csv_files';
    protected $fillable = ["title"];

    public function columns()
    {
        return $this->hasMany(Csvcolumn::class,"csvfile_id","id");
    }

    public function computedColumns()
    {
        return $this->hasMany(Csvcompute::class,"csvfile_id","id");
    }
}
