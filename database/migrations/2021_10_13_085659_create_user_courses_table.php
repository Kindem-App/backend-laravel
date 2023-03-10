<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses', function (Blueprint $table) {
            $table->char('id', 10)->primary();
            $table->string('answer')->nullable();
            $table->boolean('checked')->default(0);
            $table->boolean('is_true')->default(0);
            $table->char('course_id', 10);
            $table->char('sub_category_id', 10);
            $table->bigInteger('user_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
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
        Schema::dropIfExists('user_courses');
    }
}
