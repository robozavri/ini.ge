<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporaryusers', function (Blueprint $table) {
              $table->increments('id');
              $table->bigInteger('pasport_id')->unique();
              $table->string('name')->nullable();
              $table->string('surename')->nullable();
              $table->string('email')->nullable();
              $table->string('code')->nullable();
              $table->boolean('confirmed')->nullable()->default(0);
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
        Schema::dropIfExists('temporaryusers');
    }
}
