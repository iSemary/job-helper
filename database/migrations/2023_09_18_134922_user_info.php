<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('location')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('job_title', 255)->nullable();
            $table->tinyInteger('total_experience_years')->default(0);
            $table->boolean('looking_for_relocation')->default(1);
            $table->string('resume', 255)->nullable();
            $table->string('resume_file_name', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('user_info');
    }
};
