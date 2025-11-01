<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsSeasonsTable extends Migration
{
    public function up()
    {
        Schema::create('products_seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->comment('商品ID');
            $table->foreignId('season_id')->constrained()->onDelete('cascade')->comment('季節ID');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE products_seasons COMMENT '商品-季節中間テーブル'");
    }

    public function down()
    {
        Schema::dropIfExists('products_seasons');
    }
}
