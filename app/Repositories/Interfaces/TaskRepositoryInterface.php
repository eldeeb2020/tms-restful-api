<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;

    public function findById(int $id): ?Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): bool;

    public function delete(Task $task): bool;

    public function toggleComplete(Task $task): Task;
}