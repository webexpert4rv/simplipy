<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('center_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->longText('bio')->nullable();
            $table->string('image_id')->nullable();
            $table->string('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone_num')->nullable();
            $table->string('facebook_url',255)->nullable();
            $table->string('twitter_url',255)->nullable();
            $table->string('twitter_subscribers',255)->nullable();
            $table->string('twitter_secret',255)->nullable();
            $table->string('twitter_token',255)->nullable();
            $table->string('linkedin_url',255)->nullable();
            $table->string('google_plus_url',255)->nullable();
            $table->string('youtube_url',255)->nullable();
            $table->string('youtube_subscribers',255)->nullable();
            $table->string('pinterest_url',255)->nullable();
            $table->string('instagram_url',255)->nullable();
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
        Schema::dropIfExists('user_profiles');
    }
}
