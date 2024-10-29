<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Pending Tasks for Today</title>
</head>

<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Here are your pending tasks for today:</p>

    <ul>
        @foreach ($pendingTasks as $task)
            <li>{{ $task->title }} - Due: {{ $task->due_date->format('H:i') }}</li>
        @endforeach
    </ul>

    <p>Make sure to complete them before the deadline!</p>
</body>

</html>
