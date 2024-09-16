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
		Schema::create('instructors', function (Blueprint $table) {
            $table->increments('id');
			$table->enum('title',['Associate Professor', 'Teaching assistant','Professor','Adjunct professor',
								'Instructor','Clinical professor','Distinguished Professor','Professor Emeritus',
								'Professor of Practice','Research associate','Tenure track','Lecturer',
								'Visiting Assistant Professor']);
			$table->string('firstname',length:50);
			$table->string('lastname',length:50);
			$table->foreignId('user_id')->constrained(table: 'users')->onUpdate('cascade')->onDelete('cascade');
			$table->unique('firstname','lastname');
			$table->unique('user_id');
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
        Schema::dropIfExists('instructors');
    }
}