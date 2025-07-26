<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        
    }

    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function toggleComplete(Task $task): Task
    {
        $task->completed = !$task->completed;
        $task->save();
        return $task;
    }
}

