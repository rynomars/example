<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand_id', 10)->default('');
            $table->string('part_number', 100)->default('');
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->tinyInteger('error_level')->unsigned()->default(0);
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->index(['part_number']);
            $table->index(['status']);
            $table->index(['brand_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
