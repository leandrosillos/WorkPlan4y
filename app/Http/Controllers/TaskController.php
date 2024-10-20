<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return task::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        return $task;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'due_date' => 'required'
        ]);
        
        $task = task::create($request->all());

        return $this->response(201, 'Task created successfully', $task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, task $task)
    {
        $task->update($request->all());

        return $this->response(200, 'Task updated successfully', $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(task $task)
    {
        $task->delete();
        
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
