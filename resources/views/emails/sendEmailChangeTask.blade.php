<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkPlan4y</title>
</head>
<body>
    <h1>Olá, {{ $user->name }}</h1>
    <p>Uma tarefa em seu nome foi alterada.</p>
    <p>Segue abaixo os detalhes da tarefa:</p>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>status</th>
            <th>Previsão</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $task['id'] }}</td>
            <td>{{ $task['title'] }}</td>
            <td>{{ $task['description'] }}</td>
            <td>{{ $task['status'] }}</td>
            <td>{{ date('d/m/Y', strtotime($task['due_date'])) }}</td>
        </tr>
        </tbody>
    
</body>
</html>