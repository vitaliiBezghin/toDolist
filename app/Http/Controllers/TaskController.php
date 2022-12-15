<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(public TaskService $taskService)
    {
    }


    public function index()
    {
        return $this->taskService->getTasks();
    }


    public function store(CreateTaskRequest $request)
    {
        return $this->taskService->createTask($request->input());
    }


    public function update(Request $request, $id)
    {
        return $this->taskService->markAsDone($id);
    }


    public function destroy($id)
    {
        return $this->taskService->deleteTask($id);
    }
}
