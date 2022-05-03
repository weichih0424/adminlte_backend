<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocoNavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coco_nav', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)  ->comment('分類名稱');
            $table->string('url',200)   ->comment('網址')->nullable();
            $table->boolean('position') ->comment('分類層級 0->第一層,1->有第二層選單,2->第二層選單');
            $table->integer('parent_id')->comment('父層ID')->nullable();
            $table->string('blank')     ->comment('開啟方式 0->同頁開啟 1->另頁開啟');
            $table->integer('sort')     ->comment('排序')->default(0);
            $table->integer('status')   ->comment('狀態')->default(0);
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
        Schema::dropIfExists('coco_nav');
    }
}
