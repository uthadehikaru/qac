<?php

namespace App\Helpers;

use App\Models\MemberBatch;
use App\Models\System;
use Carbon\Carbon;

class AppHelper
{
    /**
     * Calculate duration of memberbatch based on approved_at date
     * 
     * @param \App\Models\MemberBatch $memberBatch
     * @return \Carbon\Carbon
     */
    public static function liteduration($memberBatch_id)
    {
        $memberBatch = MemberBatch::find($memberBatch_id);
        $approved_at = $memberBatch->approved_at;
        if (!$approved_at) {
            return 'Menunggu Konfirmasi';
        }
        
        // Check if session is bundling (assuming bundling sessions contain 'bundling' in the name)
        $isBundling = false;
        if ($memberBatch->session) {
            $isBundling = stripos($memberBatch->session, 'bundling') !== false;
        }
        
        // If bundling, add twice of access months
        $ecourse_access_month = System::value('ecourse_access_month', 1);
        $duration = $isBundling ? $ecourse_access_month*2 : $ecourse_access_month;
        return $approved_at->format('d M Y').' s/d '.$approved_at->addMonths($duration)->format('d M Y');
    }
}

