<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Parsedown;
use App\Helpers\HandHelpers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('markdown', function($expression){
            return "<?php echo app('markdown')->setMarkupEscaped(true)->text({$expression});?>";
        });

        Blade::directive('result', function ($expression){
           return "<?php echo app('helper')->resultToHuman({$expression}) ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('helper', HandHelpers::class);
        $this->app->singleton('markdown', Parsedown::class);
    }
}
