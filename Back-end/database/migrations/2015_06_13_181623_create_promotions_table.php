<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 200);
            $table->string('type', 50);
            $table->integer('receipts_count')->nullable();
            $table->double('money_count')->nullable();
            $table->string('business_afm', 20);
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
        Schema::table('promotions', function(Blueprint $table)
        {
            Schema::drop('promotions');
        });
    }

}
