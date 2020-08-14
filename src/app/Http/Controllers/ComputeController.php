<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\Csvfile;
use App\Models\Csvcompute;

class ComputeController {

    public function store(Request $request){

        Csvfile::findOrFail($request->input('fileId'));

        $insert = Csvcompute::firstOrCreate([
            "calculation" => $request->input('calculation'),
            "compute_column_id" => $request->input('computeColumn'),
            "group_by_column_id" => $request->input('groupByColumn'),
            "csvfile_id" => $request->input('fileId')
        ]);

        if($insert){
            return response()->json(['message' => 'Columns calculated and added to csv file!'], 200);
        }else{
            return response()->json(['message' => 'Error'], 500);
        }

    }
}
