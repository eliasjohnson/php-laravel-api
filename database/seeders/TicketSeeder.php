<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing tickets
        DB::table('tickets')->truncate();

        // Read CSV file
        $csvFile = storage_path('app/tickets_1.csv');

        if (!file_exists($csvFile)) {
            $this->command->error('CSV file not found at: ' . $csvFile);
            return;
        }

        $handle = fopen($csvFile, 'r');
        if (!$handle) {
            $this->command->error('Could not open CSV file');
            return;
        }

        // Read header row
        $headers = fgetcsv($handle);
        if (!$headers) {
            $this->command->error('Could not read CSV headers');
            fclose($handle);
            return;
        }

        // Map CSV headers to database columns
        $columnMapping = [
            'Category' => 'category',
            'Closed Time' => 'closed_time',
            'Created Time' => 'created_time',
            'Department' => 'department',
            'Description' => 'description',
            'Ticket Id' => 'ticket_id',
            'Due by Time' => 'due_by_time',
            'First Response Time (in Hrs)' => 'first_response_time_hrs',
            'First Response Status' => 'first_response_status',
            'Initial Response Time' => 'initial_response_time',
            'Group' => 'group_assigned',
            'Impact' => 'impact',
            'Impacted locations' => 'impacted_locations',
            'Customer interactions' => 'customer_interactions',
            'Item' => 'item',
            'Agent interactions' => 'agent_interactions',
            'Planned Effort' => 'planned_effort',
            'Priority' => 'priority',
            'Requester Email' => 'requester_email',
            'Requester Location' => 'requester_location',
            'Requester Name' => 'requester_name',
            'Requester VIP' => 'requester_vip',
            'Resolution Note' => 'resolution_note',
            'Resolution Status' => 'resolution_status',
            'Resolution Time (in Hrs)' => 'resolution_time_hrs',
            'Resolved Time' => 'resolved_time',
            'Agent' => 'agent',
            'Source' => 'source',
            'Status' => 'status',
            'Subject' => 'subject',
            'Talent Acquisition Status' => 'talent_acquisition_status',
            'Type Of Issue' => 'type_of_issue',
            'Survey Result' => 'survey_result',
            'Tags' => 'tags',
            'Type' => 'type',
            'Last Updated Time' => 'last_updated_time',
            'Urgency' => 'urgency',
            'Workspace' => 'workspace'
        ];

        $batchSize = 100;
        $batch = [];
        $rowCount = 0;

        $this->command->info('Starting to import tickets...');

        // Process CSV rows
        while (($row = fgetcsv($handle)) !== false) {
            $rowCount++;

            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Map CSV row to database columns
            $ticketData = [];
            foreach ($headers as $index => $header) {
                $dbColumn = $columnMapping[$header] ?? null;
                if ($dbColumn && isset($row[$index])) {
                    $value = trim($row[$index]);
                    // Convert empty strings to null
                    $ticketData[$dbColumn] = $value === '' ? null : $value;
                }
            }

            // Add timestamps
            $ticketData['created_at'] = now();
            $ticketData['updated_at'] = now();

            $batch[] = $ticketData;

            // Insert in batches
            if (count($batch) >= $batchSize) {
                DB::table('tickets')->insert($batch);
                $this->command->info("Imported {$rowCount} tickets...");
                $batch = [];
            }
        }

        // Insert remaining records
        if (!empty($batch)) {
            DB::table('tickets')->insert($batch);
        }

        fclose($handle);

        $totalTickets = DB::table('tickets')->count();
        $this->command->info("Successfully imported {$totalTickets} tickets from CSV!");
    }
}
