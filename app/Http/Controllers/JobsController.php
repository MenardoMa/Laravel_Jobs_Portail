<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobsController extends Controller
{
    //
    public function create()
    {
        return view('jobs_portail.front.post-job.create-job');
    }
}
