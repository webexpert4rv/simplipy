<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNewMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('agent_id');
            $table->string('client_name')->nullable();
            $table->string('pre_name')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->text('address2')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('security_no')->nullable();
            $table->string('exam_type')->nullable();
            $table->string('date_of_exam')->nullable();
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
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
        Schema::drop('new_messages');
    }
}
