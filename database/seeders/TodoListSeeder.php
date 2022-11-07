<?php

namespace Database\Seeders;

use App\Models\Tags;
use App\Models\TodoList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TodoList::factory(20)->create();

        TodoList::all()->each(function ($todoList) {
            $todoList->tags()->attach(Tags::inRandomOrder()->take(3)->pluck('id')->toArray());
        });
    }
}
