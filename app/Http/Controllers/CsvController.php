<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function create(){
        return view('admin.modules.csv.create');
    }
    public function post_csv(Request $request){
        return 1;
        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $csv_data = array_slice($data, 0, 8);
        //return $data;
        return 0;
    }
}
