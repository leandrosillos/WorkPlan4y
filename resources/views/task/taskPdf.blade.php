<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Tasks</h1>
<table>
    <thead>
    <tr>
        <th>id</th>
        <th>project_id</th>
        <th>user_id</th>
        <th>title</th>
        <th>description</th>
        <th>status</th>
        <th>created_at</th>
        <th>updated_at</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $task)
        <tr>
            <td>{{ $task['id'] }}</td>
            <td>{{ $task['project_id'] }}</td>
            <td>{{ $task['user_id'] }}</td>
            <td>{{ $task['title'] }}</td>
            <td>{{ $task['description'] }}</td>
            <td>{{ $task['status'] }}</td>
            <td>{{ $task['created_at'] }}</td>
            <td>{{ $task['updated_at'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
