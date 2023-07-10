<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('invoice_id');
            $table->timestamp('date');
            $table->timestamp('start_hour');
            $table->timestamp('end_hour');
            $table->integer('hours_count');
            $table->boolean('hours_pack')->default(false);
            $table->integer('hourly_rate');
            $table->text('learned_notions');
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('cours');
    }
}
