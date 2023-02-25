<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiveStatsController extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    public function vivo_campaign(){
        return view('admin.stats.vivo_campaign');
    }
}
