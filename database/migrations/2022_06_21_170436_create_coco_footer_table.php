<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocoFooterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coco_footer', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->comment('Footer名稱');
            $table->string('url',250)->comment('網址')->nullable();
            $table->string('blank')->comment('開啟方式 0->同頁開啟 1->另頁開啟');
            $table->integer('sort')->comment('排序')->default(0);
            $table->boolean('status')->comment('狀態')->default('0');
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
        Schema::dropIfExists('coco_footer');
    }
}
