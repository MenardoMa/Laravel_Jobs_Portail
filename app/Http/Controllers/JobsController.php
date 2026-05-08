<?php

namespace App\Http\Controllers;

use App\Enum\ExperienceLevel;
use App\Http\Requests\JobFormRequest;
use App\Models\Category;
use App\Models\JobType;

class JobsController extends Controller
{
    //
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $types = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        $experiences = ExperienceLevel::cases();

        return view('jobs_portail.front.post-job.create-job', [
            'categories' => $categories,
            'types' => $types,
            'experiences' => $experiences
        ]);
    }

    public function createSave(JobFormRequest $request)
    {
        dd($request->validated());
    }
}
