<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('商品名');
            $table->integer('price')->comment('商品料金');
            $table->string('image', 255)->comment('商品画像');
            $table->text('description')->comment('商品説明');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE products COMMENT '商品テーブル'");
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
