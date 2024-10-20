<?php

namespace App\Http\Controllers;

use App\Models\project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return project::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required'
        ]);
        
        $project = project::create($request->all());

        return $this->response(201, 'Project created successfully', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(project $project)
    {
        return $project;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, project $project)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required'
        ]);

        $project->update($request->all());

        return $this->response(200, 'Project updated successfully', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(project $project)
    {
        $project->delete();
        
    }

    /**
     * Builds a standardized response
     */
    private function response($code, $message, $data)
    {
        return response()->json([
            'code' => $code, 
            'message' => $message, 
            'data' => $data
        ], $code
        );
    }
}
