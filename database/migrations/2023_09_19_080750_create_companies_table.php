<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration {
    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 255);
            $table->string('phone', 64)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('industry', 255)->nullable();
            $table->string('job_title', 255)->nullable();
            $table->text('job_description')->nullable();
            $table->decimal('job_salary', 10, 2)->nullable();
            $table->string('hr_name', 255)->nullable();
            $table->string('hr_email', 255)->nullable();
            $table->string('website', 64)->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('companies');
    }
}
