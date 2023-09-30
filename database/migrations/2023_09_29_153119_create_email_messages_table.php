<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('email_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->longText('prompt')->nullable();
            $table->longText('content')->nullable();
            $table->tinyInteger('type')->default(0); // 0 -> Motivation Message | 1-> Reminder Message 
            $table->tinyInteger('status')->default(0); // 0 -> Pending | 1 -> Sent
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('email_messages');
    }
};
