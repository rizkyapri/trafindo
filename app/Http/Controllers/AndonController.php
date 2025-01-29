<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AndonController extends Controller
{
    public function index(){
        return view('andonreceived.index');
    }
}
