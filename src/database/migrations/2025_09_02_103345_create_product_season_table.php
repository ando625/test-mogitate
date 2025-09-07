<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_season', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')           // product_id: 外部キー
                  ->constrained('products')           // products(id) を参照
                  ->onDelete('cascade');              // 商品削除で中間も削除
            $table->foreignId('season_id')            // season_id: 外部キー
                  ->constrained('seasons')            // seasons(id) を参照
                  ->onDelete('cascade');              // 季節削除で中間も削除
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
        Schema::dropIfExists('product_season');
    }
}
