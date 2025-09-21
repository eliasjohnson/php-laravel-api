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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Basic ticket info
            $table->integer('ticket_id')->unique();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->string('priority')->nullable();
            $table->string('urgency')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('type_of_issue')->nullable();
            $table->string('item')->nullable();

            // Requester info
            $table->string('requester_name')->nullable();
            $table->string('requester_email')->nullable();
            $table->string('requester_location')->nullable();
            $table->string('requester_vip')->nullable(); // Store as string "TRUE"/"FALSE"

            // Assignment & handling
            $table->string('agent')->nullable();
            $table->string('group_assigned')->nullable();
            $table->string('department')->nullable();
            $table->string('workspace')->nullable();

            // Impact & scope
            $table->string('impact')->nullable();
            $table->text('impacted_locations')->nullable();

            // Response & resolution
            $table->string('first_response_status')->nullable();
            $table->string('first_response_time_hrs')->nullable(); // Store as "0:00:00" format
            $table->string('initial_response_time')->nullable();
            $table->string('resolution_status')->nullable();
            $table->text('resolution_note')->nullable();
            $table->string('resolution_time_hrs')->nullable(); // Store as "28:56:23" format

            // Interactions & effort
            $table->integer('customer_interactions')->nullable();
            $table->integer('agent_interactions')->nullable();
            $table->string('planned_effort')->nullable();

            // Additional info
            $table->string('source')->nullable();
            $table->string('talent_acquisition_status')->nullable();
            $table->string('survey_result')->nullable();
            $table->string('tags')->nullable(); // Store as string, can convert to JSON later

            // Timestamps - store as strings initially, parse later if needed
            $table->string('created_time')->nullable(); // "1/1/20 16:00"
            $table->string('closed_time')->nullable(); // "1/8/20 1:34"
            $table->string('due_by_time')->nullable(); // "1/24/20 11:04"
            $table->string('resolved_time')->nullable(); // "1/7/20 12:56"
            $table->string('last_updated_time')->nullable(); // "1/8/20 1:34"

            $table->timestamps(); // Laravel's created_at & updated_at

            // Indexes for better performance
            $table->index(['status', 'priority']);
            $table->index(['agent']);
            $table->index(['requester_email']);
            $table->index(['ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
