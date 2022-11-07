<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->unique();
            $table->longText('description')->nullable();
            $table->timestamp('due_date')->useCurrent();
            $table->tinyInteger('status');
            $table->tinyInteger('priority');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::create('todo_list_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_list_id')->constrained('todo_lists');
            $table->foreignId('tag_id')->constrained('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo_lists');
        Schema::dropIfExists('todo_list_tags');
    }
};
