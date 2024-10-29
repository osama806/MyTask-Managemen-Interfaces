<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskService
{
    use ResponseTrait;

    /**
     * Create new task in storage
     * @param array $data
     * @return array
     */
    public function createTask(array $data)
    {
        // Check if the user is authenticated
        $user = auth()->user();
        if (!$user) {
            return ['status' => false, 'msg' => 'User not authenticated', 'code' => 401];
        }
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['due_date'],
        ]);
        $task->status = 'pending';
        $task->created_by = $user->id;
        $task->save();

        return $task ? ['status' => true] : ['status' => false, 'msg' => 'Failed Create New Task', 'code' => 500];
    }

    /**
     * Update a spicified task details in storage
     * @param array $data
     * @param \App\Models\Task $task
     * @return array
     */
    public function update(array $data, Task $task)
    {
        // Check if the user is authenticated
        $user = auth()->user();
        if (!$user) {
            return ['status' => false, 'msg' => 'User not authenticated', 'code' => 401];
        }

        if ($task->created_by !== $user->id) {
            return ['status' => false, 'msg' => 'Not Allow This Action!', 'code' => 400];
        }

        // return attributes value that not null and not empty
        $filteredData = array_filter($data, function ($value) {
            return !is_null($value) && trim($value) !== '';
        });

        if (count($filteredData) < 1) {
            return ['status' => false, 'msg' => 'Not Found Data in Request!', 'code' => 404];
        }

        $task->update($filteredData);

        return ['status' => true];
    }

    /**
     * Remove a specified task from storage
     * @param \App\Models\Task $task
     * @return bool[]|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete(Task $task)
    {
         // Check if the user is authenticated
         $user = auth()->user();
         if (!$user) {
             return ['status' => false, 'msg' => 'User not authenticated', 'code' => 401];
         }
         if ($task->created_by !== $user->id) {
            return ['status' => false, 'msg' => 'Not Allow This Action!', 'code' => 400];

        }
        $task->delete();
        return ['status' => true];
    }

    /**
     * Deliveried a specified task to admin in specific time
     * @param \App\Models\Task $task
     * @return array
     */
    public function delivery(Task $task)
    {
          // Check if the user is authenticated
          $user = auth()->user();
          if (!$user) {
              return ['status' => false, 'msg' => 'User not authenticated', 'code' => 401];
          }
          if ($task->created_by !== $user->id) {
            return ['status' => false, 'msg' => 'Not Allow This Action!', 'code' => 400];

        }
        if ($task->status !== 'pending') {
            return ['status' => false, 'msg' => 'Task status not pending', 'code' => 400];
        }

        $task->status = 'completed';
        $task->due_date = now()->toDateTime()->format('Y-m-d');
        $task->save();
        return ['status' => true];
    }
}
