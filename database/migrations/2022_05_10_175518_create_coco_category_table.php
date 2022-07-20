<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocoCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coco_category', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->comment('分類名稱');
            $table->string('url',250)->comment('分類路徑');
            $table->boolean('category_show')->comment('分類列呈現')->default(0);
            $table->boolean('main_show')->comment('首頁呈現')->default(0);
            $table->integer('sort')->comment('排序')->default(0);
            $table->boolean('status')->default('0')->comment('狀態');
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
        Schema::dropIfExists('coco_category');
    }
}
