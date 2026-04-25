<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('jobs_portail.front.index');
    }

    //Show
    public function show($slug, $id)
    {
        return view('jobs_portail.front.show');
    }

}
