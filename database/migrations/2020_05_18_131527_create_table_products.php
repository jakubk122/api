<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('title');
            $table->double('price', 10, 2);
            $table->unsignedBigInteger('currency_id');
            $table->timestamps();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::insert('products',[
           [
               'title' => 'Fallout',
               'price' => '1.89',
               'currency_id' => 1,
           ],
           [
               'title' => 'Dont Starve',
               'price' => '2.99',
               'currency_id' => 1,
           ],
           [
               'title' => 'Baldurs Gate',
               'price' => '3.99',
               'currency_id' => 1,
           ],
           [
               'title' => 'Icewind Date',
               'price' => '4.99',
               'currency_id' => 1,
           ],
           [
               'title' => 'Bloodborne',
               'price' => '5.99',
               'currency_id' => 1,
           ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_products');
    }
}
