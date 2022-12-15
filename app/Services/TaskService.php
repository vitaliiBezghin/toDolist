<?php

namespace App\Services;

use App\Enums\TaskEnum;
use App\Jobs\TaskJob;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService
{
    public function getTasks(): JsonResponse
    {
        //All because we don't have a lot of tasks :)
        return response()->json(Task::all());
    }
    protected function checkCountOfTasks(): void
    {
        $tasks = Task::all();
        if ($tasks->count() == 2) {
            $firstThereTask = DB::table('tasks')->orderBy('created_at', 'ASC')->limit(3)->get();
            Task::where('id', $firstThereTask->first()->id)->update([
               'status' => TaskEnum::DONE->name
            ]);
        }
    }
    public function createTask(array|object $requestTask): JsonResponse
    {
        try {
            $this->checkCountOfTasks();

            $task = Task::create([
                'task' => $requestTask['task'],
                'status' => TaskEnum::MUST_TO_BE_DONE->name
            ]);

            TaskJob::dispatch($task)->delay(now()->addMinutes(5));

            return response()->json(status: 204);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json("Can't create task !", 500);
        }
    }
    public function markAsDone(int $taskId): JsonResponse
    {
        try {
            Task::where('id', $taskId)->update([
                'status' => TaskEnum::DONE->name
            ]);
            return response()->json(status: 204);
        }catch (Exception $exception) {
            Log::error($exception);
            return response()->json("Can't update task !", 500);
        }
    }
    public function deleteTask(int $taskId): JsonResponse
    {
        try {
            Task::where('id', $taskId)->delete();
            return response()->json(status: 204);
        }catch (Exception $exception) {
            Log::error($exception);
            return response()->json("Can't delete task !", 500);
        }
    }
}
