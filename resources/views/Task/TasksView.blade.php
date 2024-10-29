@extends('MainView')
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <h4 class="text-danger">{{ $error }}</h4>
        @endforeach
    @endif
    <div class="flex align-items-center justify-between w-full">
        <h1 class="text-primary text-center d-inline-block">
            Tasks
        </h1>
        <button type="button" class="btn btn-info">
            <a href="{{ route('tasks.create') }}" class="text-decoration-none  text-white ">Create Task</a>
        </button>
    </div>
    <div class="row">
        @foreach ($tasks as $task)
            <div class="card m-2 px-0 w-full">
                <div class="card-body">
                    <h3 class="card-title"> {{ $task->title }} </h3>
                    <p class="card-text ">Description: {{ $task->description }}</p>
                    <p class="card-text ">Status: {{ $task->status }} </p>
                    <span class="card-subtitle d-block">Due date: {{ $task->due_date }}</span>
                    <button type="button" class="btn btn-info">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-decoration-none  text-white ">Edit</a>
                    </button>
                    @if ($task->status === 'pending')
                        <form action="{{ route('delivery', $task->id) }}" method="POST" class="d-inline ">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Delivery
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline ">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
