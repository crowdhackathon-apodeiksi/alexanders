<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('aa');
            $table->string('afm', 20);
            $table->string('eponimia', 50);
            $table->double('poso');
            $table->binary('image')->nullable();
            $table->timestamp('printed_at');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('receipts');
    }

}
