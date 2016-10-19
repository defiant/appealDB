<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Parsedown;

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
            return "<?php echo app('markdown')->text(e({$expression}));?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        /*$this->app->singleton(Parser::class, function ($app) {
            $parsedown = new Parsedown;
            return new Parser($parsedown);
        });*/

        $this->app->singleton('markdown', Parsedown::class);
    }
}
