<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;


class TaskRepository implements TaskRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $user = $filters['user'] ?? auth()->user();
        $query = Task::with(['assignedUser', 'creator', 'dependencies']);
        // Role-based filtering
        if ($user->hasRole('user')) {
            $query->where('assigned_to', $user->id);
        }

        // Filters
        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        if (isset($filters['due_date_start']) || isset($filters['due_date_end'])) {
            $query->byDueDateRange($filters['due_date_start'], $filters['due_date_end']);
        }

        if (isset($filters['assigned_to']) && $user->hasRole('manager')) {
            $query->byAssignedUser($filters['assigned_to']);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);

        return $tasks;
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

