<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EpassController extends Controller
{
    function index() {
    	return view('epass/index');
    }
}
