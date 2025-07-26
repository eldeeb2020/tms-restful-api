<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::role('manager')->first();
        $users = User::role('user')->get();

        // sample tasks
        $task1 = Task::create([
            'title' => 'Task 1',
            'description' => 'Task 1 Description',
            'status' => 'completed',
            'due_date' => now()->addDays(7),
            'assigned_to' => $users[0]->id,
            'created_by' => $manager->id,
        ]);

        $task2 = Task::create([
            'title' => 'Task 2',
            'description' => 'Task 2 Description',
            'status' => 'in_progress',
            'due_date' => now()->addDays(10),
            'assigned_to' => $users[1]->id,
            'created_by' => $manager->id,
        ]);

        $task3 = Task::create([
            'title' => 'Task 3',
            'description' => 'Task 3 Description',
            'status' => 'pending',
            'due_date' => now()->addDays(14),
            'assigned_to' => $users[0]->id,
            'created_by' => $manager->id,
        ]);

        $task4 = Task::create([
            'title' => 'Task 4',
            'description' => 'Task 4 Description',
            'status' => 'pending',
            'due_date' => now()->addDays(21),
            'assigned_to' => $users[1]->id,
            'created_by' => $manager->id,
        ]);

        // dependencies
        $task3->dependencies()->attach([$task1->id, $task2->id]);
        $task4->dependencies()->attach([$task3->id]);
    }
}
