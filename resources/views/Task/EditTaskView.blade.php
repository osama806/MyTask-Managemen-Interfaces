@extends('MainView')
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <h4 class="text-danger">{{ $error }}</h4>
        @endforeach
    @endif
    <div class="card ">
        <h1 class="card-header text-primary">
            Edit Task
        </h1>
        <div class="card-body">
            <div class="card-content">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mb-3 ">
                        <label for="title" class="form-label">Task title</label>
                        <input type="text" name="title" id="title" class="form-control text-white"
                            value="{{ $task->title }}" required>
                    </div>
                    <div class="form-group mb-3 ">
                        <label for="description" class="form-label ">Task Description</label>
                        <input type="text" name="description" id="description" class="form-control text-white"
                            value="{{ $task->description }}" required>
                    </div>
                    <div class="form-group mb-3 ">
                        <label for="due_date" class="form-label ">Task Duedate</label>
                        <input type="date" name="due_date" id="due_date" class="form-control text-white"
                            value="{{ $task->due_date }}" required />
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
