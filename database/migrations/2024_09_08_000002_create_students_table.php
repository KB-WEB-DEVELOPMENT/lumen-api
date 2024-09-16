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
		Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::dropIfExists('students');
    }
}