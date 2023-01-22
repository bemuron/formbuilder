<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaunchFormController extends Controller
{

    //open the view that launches the form
    public function launchForm(){
        return view('view_form');
    }
}
