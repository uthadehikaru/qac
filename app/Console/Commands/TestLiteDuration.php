<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MemberBatch;
use App\Helpers\AppHelper;

class TestLiteDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:liteduration {memberBatchId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the liteduration helper function';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $memberBatchId = $this->argument('memberBatchId');
        
        if ($memberBatchId) {
            $memberBatch = MemberBatch::find($memberBatchId);
            if (!$memberBatch) {
                $this->error("MemberBatch with ID {$memberBatchId} not found.");
                return 1;
            }
            $this->testSingleMemberBatch($memberBatch);
        } else {
            $this->testMultipleMemberBatches();
        }
        
        return 0;
    }

    private function testSingleMemberBatch($memberBatch)
    {
        $this->info("Testing MemberBatch ID: {$memberBatch->id}");
        $this->info("Session: {$memberBatch->session}");
        $this->info("Approved At: {$memberBatch->approved_at}");
        
        // Test using the helper class
        $duration = AppHelper::liteduration($memberBatch);
        $this->info("Duration (Helper Class): " . ($duration ? $duration->format('Y-m-d H:i:s') : 'null'));
        
        // Test using the global helper function
        $duration2 = liteduration($memberBatch);
        $this->info("Duration (Global Function): " . ($duration2 ? $duration2->format('Y-m-d H:i:s') : 'null'));
        
        // Test using the model attribute
        $duration3 = $memberBatch->lite_duration;
        $this->info("Duration (Model Attribute): " . ($duration3 ? $duration3->format('Y-m-d H:i:s') : 'null'));
    }

    private function testMultipleMemberBatches()
    {
        $memberBatches = MemberBatch::whereNotNull('approved_at')
            ->whereIn('session', ['session1', 'bundling_session', 'regular_session'])
            ->limit(5)
            ->get();

        if ($memberBatches->isEmpty()) {
            $this->warn("No MemberBatches with approved_at found for testing.");
            return;
        }

        $this->info("Testing multiple MemberBatches:");
        $this->newLine();

        foreach ($memberBatches as $memberBatch) {
            $this->testSingleMemberBatch($memberBatch);
            $this->newLine();
        }
    }
} 