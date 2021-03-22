<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo')->nullable();
            $table->string('name');
            $table->text('description');
            $table->longText('content')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('category_id')->nullable();
            $table->tinyInteger('status')->comment('1 -  enablevoan ,0 - disableovan');
            $table->tinyInteger('important')->comment('1 - important,0 - no important');
            $table->bigInteger('reviews')->default(0);
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
        Schema::dropIfExists('blog_posts');
    }
}
