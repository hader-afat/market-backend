<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_2')->create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('type'); //category
            $table->boolean('available')->default(true); //not solid
            $table->text('description');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            // $table->unsignedBigInteger('cat_id');
            $table->double('price', 15, 8)->default(0.0);
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::connection('mysql')->create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('type'); //category
            $table->boolean('available')->default(true); //not solid
            $table->text('description');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            // $table->unsignedBigInteger('cat_id');
            $table->double('price', 15, 8)->default(0.0);
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
