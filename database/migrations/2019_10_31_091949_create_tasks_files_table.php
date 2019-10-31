<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id');
            $table->unsignedInteger('file_id');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade')->onUpdate('CASCADE');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade')->onUpdate('CASCADE');
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
        Schema::table('tasks_files', function($table) {
              $table->dropForeign(['task_id']);
              $table->dropForeign(['file_id']);
        });


        Schema::dropIfExists('tasks_files');
    }
}
