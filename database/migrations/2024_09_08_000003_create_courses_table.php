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
		Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title',length:100)->unique();
			$table->enum('topic',['PHP','C++','Java']);
			$table->string('start_date');
			$table->integer('total_number_hours')->default(1);
			$table->foreignId('instructor_id')->constrained(table:'instructors')->onUpdate('cascade')->onDelete('cascade');
			$table->unique('title','topic');
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
        Schema::dropIfExists('courses');
    }
}