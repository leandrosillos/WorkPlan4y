<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Exports\ExportTask;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportExcel(Request $request)
    {
        if (!$this->validateParams($request->all())) {
            return $this->response(400, 'Invalid parameters', []);
        }

        $exporTask = new ExportTask($request->all());

        return Excel::download($exporTask, 'tasks.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    private function validateParams($request)
    {
        $data = [
            'status' => $request['status'],
            'due_date' => $request['due_date'],
            'created_date' => $request['created_date'],
        ];

        // check if due_date is not empty
        if (!empty($data['due_date'])) {
            // check if start_date and end_date are not empty
            if (empty($data['due_date']['start_date']) || empty($data['due_date']['end_date'])) {
                return false;
            }
        }  

        // check if created_date is not empty
        if (!empty($data['created_date'])) {
            // check if start_date and end_date are not empty
            if (empty($data['created_date']['start_date']) || empty($data['created_date']['end_date'])) {
                return false;
            }
        }  
        
        // check if status and due_date are empty
        if (empty($data['status']) && empty($data['due_date']) && empty($data['created_date'])) {
            return false;
        }
        
        return true;
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
