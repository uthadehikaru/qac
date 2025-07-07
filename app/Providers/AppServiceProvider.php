<?php

namespace App\Providers;

use App\Models\MemberBatch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
            $view->with('member_level', -1);
            if(Auth::check() && Auth::user()->role === 'member'){
                $member = Auth::user()->member;
                $level = 0;
                foreach($member->batches()->wherePivot('status', '>=', MemberBatch::STATUS_PAID)->get() as $batch){
                    $isLite = Str::startsWith($batch->course->name, 'QAC 1.0 Lite');
                    if($isLite){
                        $approved_at = $batch->approved_at;
                        $end_course = Carbon::parse($approved_at)->addDays(30);
                        if($end_course->isPast()){
                            continue;
                        }
                    }
                    $level = max($level, $batch->course->level);
                }
                $view->with('member_level', $level);
            }
        });
    }
}
