<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	
	public function up(): void
    {
		Schema::create('courses_ratings', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('rating');
			$table->foreignId('course_id')->constrained(table:'courses')->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('student_id')->constrained(table:'students')->onUpdate('cascade')->onDelete('cascade');
			$table->unique('course_id','student_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_ratings');
    }
}