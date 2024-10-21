<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Task;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportTask implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Task::query();
        
        if (isset($this->data['status'])) {
            $status = $this->data['status'];
            $query->where('status', $status);
        }

        if (isset($this->data['due_date'])) {
            $due_start_date = $this->data['due_date']['start_date'];
            $due_end_date = $this->data['due_date']['end_date'];

            $query->orWhereBetween('due_date', [$due_start_date, $due_end_date]);
        }

        if (isset($this->data['created_date'])) {
            $created_start_date = $this->data['created_date']['start_date'];
            $created_end_date = $this->data['created_date']['end_date'];

            $query->orWhereBetween('due_date', [$created_start_date, $created_end_date]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Project ID',
            'User ID',
            'Title',
            'Description',
            'Status',
            'Due Date',
            'Created At',
            'Updated At'
        ];
    }

    public function map($task): array
    {
        return [
            $task->id,
            $task->project_id,
            $task->user_id,
            $task->title,
            $task->description,
            $task->status,
            $task->due_date,
            $task->created_at,
            $task->updated_at
        ];
    }
}
