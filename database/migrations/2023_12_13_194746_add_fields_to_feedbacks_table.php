<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->text('feedback');
            $table->foreignId('user_id')->constrained(); // Adjust if needed
            $table->foreignId('complaint_id')->constrained(); // Adjust if needed
            // Add any other fields you need
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn('feedback');
            $table->dropForeign(['user_id']);
            $table->dropForeign(['complaint_id']);
            // Drop any other columns if needed
        });
    }
}

