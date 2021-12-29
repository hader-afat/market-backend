<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('username');
            $table->string('region');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->decimal('balance', 6, 2)->nullable()->default(0.0); //####.##
            $table->timestamps();
        });

        Schema::connection('mysql_2')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('username');
            $table->string('region');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->decimal('balance', 6, 2)->nullable()->default(0.0); //####.##
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
        Schema::dropIfExists('users');
    }


}
