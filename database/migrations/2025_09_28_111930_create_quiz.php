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
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->text('question');                   // Quiz question
            $table->json('options');                    // Options in JSON
            $table->string('corr_ans');                 // Correct answer
            $table->text('expl')->nullable();           // Explanation (optional)
            $table->unsignedBigInteger('class_subject_id'); // Reference to class_subject pivot
            $table->enum('level', ['easy', 'medium', 'hard']); // Question level
            $table->unsignedBigInteger('entry_id');     // Entry user ID or reference
            $table->timestamp('entry_ts')->useCurrent();
            $table->timestamps();

            $table->foreign('class_subject_id')->references('id')->on('class_subject')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
