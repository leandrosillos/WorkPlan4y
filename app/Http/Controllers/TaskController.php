<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Exports\ExportTask;
use App\Jobs\JobSendEmailChangetask;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'project_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'due_date' => 'required'
        ]);
        
        $response = $request->user()->tasks()->create($fields);

        return response(['message' => 'Successfully created task', 'response' => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $fields = $request->validate([
            'project_id' => 'numeric',
            'user_id' => 'numeric',
            'title' => 'string',
            'description' => 'string',
            'status' => 'string',
            'due_date' => 'date'
        ]);

        $task->update($fields);

        $dataTask = Task::find($task->id);

        $user = User::find($dataTask->user_id);

        JobSendEmailChangetask::dispatch($user->id, $task->id)->onQueue('default');

        return response(['message' => 'Successfully updated task']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        
    }

    public function exportExcel(Request $request)
    {
        if (!$this->validateParams($request->all())) {
            return response(['message' => 'Invalid parameters']);
        }

        $exporTask = new ExportTask($request->all());

        return Excel::download($exporTask, 'tasks.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportPdf(Request $request){
        $data = $this->validateParams($request->all());

        if (!$data) {
            return response(['message' => 'Invalid parameters']);
        }

        $tasks = $this->getTasks($data);

        if ($tasks->isEmpty()) {
            return response(['message' => 'Tasks not found']);
        }

        $data = $this->getDataToPdf($tasks);
        
        $pdf = Pdf::loadView('task.taskPdf', ['data' => $data]);

        $filePath = storage_path('app/public/exports/tasks.pdf');
        $pdf->save($filePath);

        return response()->download($filePath);
    }

    private function getDataToPdf($tasks)
    {
        $data = [];
        foreach ($tasks as $task) {
            $data[] = [
                'id' => $task->id,
                'project_id' => $task->project_id,
                'user_id' => $task->user_id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->due_date,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at
            ];
        }

        return $data;
    }

    private function getTasks($data) 
    {
        $query = Task::query();
        
        if (isset($data['status'])) {
            $status = $data['status'];
            $query->where('status', $status);
        }

        if (!empty($data['due_date'])) {
            $due_start_date = $data['due_date']['start_date'];
            $due_end_date = $data['due_date']['end_date'];

            $query->orWhereBetween('due_date', [$due_start_date, $due_end_date]);
        }

        if (!empty($data['created_date'])) {
            $created_start_date = $data['created_date']['start_date'];
            $created_end_date = $data['created_date']['end_date'];

            $query->orWhereBetween('due_date', [$created_start_date, $created_end_date]);
        }

        return $query->get();
    }

    private function validateParams($request)
    {
        $data = [
            'status' => $request['status'],
            'due_date' => isset($request['due_date']) ? $request['due_date'] : '',
            'created_date' => isset($request['created_date']) ? $request['created_date'] : '',
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
        
        return $data;
    }
}
