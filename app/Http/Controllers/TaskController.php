<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    use ResponseTrait;

    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the tasks.
     * @return View
     */
    public function index()
    {
        $tasks = Cache::remember('tasks', 3600, function () {
            return Task::where('created_by', auth()->user()->id)->get();
        });

        $data = [
            'tasks' => $tasks,
        ];
        return view('Task.TasksView', $data);
    }

    /**
     * Show the form for creating a new task.
     * @return View
     */
    public function create()
    {
        return view('Task.CreateTaskView');
    }

    /**
     * Store a newly created task in storage.
     * @param \App\Http\Requests\Task\StoreTaskRequest $storeFormRequest
     * @return View
     */
    public function store(StoreTaskRequest $storeFormRequest)
    {
        $validated = $storeFormRequest->validated();
        $response = $this->taskService->createTask($validated);
        return $response['status']
            ? redirect()->route('tasks.index')
            : redirect()
                ->back()
                ->with('error', $response['msg']);
    }

    /**
     * Show the form for editing the specified task.
     * @return View
     */
    public function edit(Task $task)
    {
        // Check if the user is authenticated
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in to edit tasks.');
        }

        // Check if the task exists (though Laravel's route model binding handles this)
        if (!$task) {
            return redirect()->back()->with('error', 'Task not found.');
        }

        // Check if the authenticated user is the creator of the task
        if ($task->created_by !== $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to edit this task.');
        }

        $data = [
            'task' => $task,
        ];
        return view('Task.EditTaskView', $data);
    }

    /**
     * Update the specified task in storage.
     * @param \App\Http\Requests\Task\UpdateTaskRequest $updateFormRequest
     * @param mixed $id
     * @return View
     */
    public function update(UpdateTaskRequest $updateFormRequest, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->with('error', 'Not Found This Task!');
        }

        $validated = $updateFormRequest->validated();
        $response = $this->taskService->update($validated, $task);
        return $response['status']
            ? redirect()->route('tasks.index')
            : redirect()
                ->back()
                ->with('error', $response['msg']);
    }

    /**
     * Remove the specified task from storage.
     * @param mixed $id
     * @return View
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->with('error', 'Not Found This Task!');
        }

        $response = $this->taskService->delete($task);
        return $response['status']
            ? redirect()->route('tasks.index')
            : redirect()
                ->back()
                ->with('error', $response['msg']);
    }

    /**
     * Deliveried task to admin
     * @param mixed $id
     * @return View
     */
    public function taskDelivery($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->with('error', 'Not Found This Task!');
        }

        $response = $this->taskService->delivery($task);
        return $response['status']
            ? redirect()->route('delivery', $task->id)
            : redirect()
                ->back()
                ->with('error', $response['msg']);
    }
}
