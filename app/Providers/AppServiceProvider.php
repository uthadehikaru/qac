<?php

namespace App\Providers;

use App\Models\MemberBatch;
use App\Models\System;
use App\Services\MemberService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($money) {
            return "<?php echo 'Rp. '.number_format($money, 0, ',', '.').',-'; ?>";
        });
        View::composer('*', function ($view) {
            $qac_lite_1a = false;
            $qac_lite_1b = false;
            if(Auth::check() && Auth::user()->role === 'member'){
                $memberService = app(MemberService::class);
                $member = Auth::user()->member;
                $batch1a = $memberService->checkMemberActiveBatch($member->id, System::value('qac_1_lite_1a'), true);
                $batch1b = $memberService->checkMemberActiveBatch($member->id, System::value('qac_1_lite_1b'), true);
                $qac_lite_1a = $batch1a ? true : false;
                $qac_lite_1b = $batch1b ? true : false;
            }
            $view->with('qac_lite_1a', $qac_lite_1a);
            $view->with('qac_lite_1b', $qac_lite_1b);
        });
    }
}
