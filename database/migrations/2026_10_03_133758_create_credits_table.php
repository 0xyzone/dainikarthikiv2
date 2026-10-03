<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20); // 'given' or 'taken'
            $table->string('person_name');
            $table->string('phone')->nullable();
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->string('status', 20)->default('pending'); // 'pending', 'partial', 'settled'
            $table->text('notes')->nullable();
            $table->json('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
