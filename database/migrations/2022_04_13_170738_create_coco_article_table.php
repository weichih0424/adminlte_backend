<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocoArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coco_article', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->comment('節目名稱');
            $table->string('intro',40)->comment('簡介');
            $table->string('url',250)->comment('網址');
            $table->string('image',200)->comment('圖片');
            $table->string('fb_url',250)->nullable()->comment('FB連結');
            $table->string('yt_url',250)->nullable()->comment('YT連結');
            $table->string('line_url',250)->nullable()->comment('LINE連結');
            $table->string('ig_url',250)->nullable()->comment('IG連結');
            $table->integer('sort')->comment('排序')->default(0);
            $table->boolean('status')->default('0')->comment('狀態');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coco_article');
    }
}
