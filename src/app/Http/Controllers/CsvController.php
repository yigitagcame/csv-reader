<?php

namespace App\Http\Controllers;

use App\Models\Csvfile;

class CsvController extends Controller
{

    public function index(){

        $csvFiles = Csvfile::orderBy('id','DESC')->get()->toJson();

        return response()->json($csvFiles,200);


    }

    public function show($id){

        $csvFiles = Csvfile::where(["id" => $id])->with('columns')->first()->toJson();

        return response()->json($csvFiles,200);

    }

}
