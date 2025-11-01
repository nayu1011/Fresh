<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSeasonsTable extends Migration
{
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('季節名');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE seasons COMMENT '季節テーブル'");
    }

    public function down()
    {
        Schema::dropIfExists('seasons');
    }
}
