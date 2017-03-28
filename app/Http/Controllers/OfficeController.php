<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Office;

class OfficeController extends Controller
{
    public function show_profile($id){
        $office = Office::find($id);
        print_r($office->user);
    }
}
