<?php

use App\Helpers\AppHelper;
use App\Models\MemberBatch;

if (!function_exists('liteduration')) {
    /**
     * Calculate duration of memberbatch based on approved_at date
     * 
     * @param \App\Models\MemberBatch $memberBatch
     * @return \Carbon\Carbon|null
     */
    function liteduration($memberBatch_id)
    {
        return AppHelper::liteduration($memberBatch_id);
    }
} 