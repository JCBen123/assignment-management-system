<?php

use App\Enums\AssignmentStatus;
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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('title', 255);
            $table->text('details')->nullable();
            $table->date('deadline');
            $table->enum('status', array_column(AssignmentStatus::cases(), 'value'))->default(AssignmentStatus::PENDING);
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
