<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;

class ApiDocsController extends Controller
{
    public function index()
    {
        return view('api-docs.index');
    }
}
