<?php

namespace App\Helpers;

use App\Models\MemberBatch;

class AppHelper
{
    /**
     * Calculate duration of memberbatch based on approved_at date
     * 
     * @param int $memberBatch_id
     * @return string
     */
    public static function liteduration($memberBatch_id)
    {
        $memberBatch = MemberBatch::find($memberBatch_id);
        $approved_at = $memberBatch->approved_at;
        if (!$approved_at) {
            return 'Menunggu Konfirmasi';
        }
        
        $start = $approved_at->copy();

        return $start->format('d M Y').' s/d '.$start->copy()->addMonths($memberBatch->accessMonths())->format('d M Y');
    }
}

