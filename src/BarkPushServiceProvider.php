<?php
namespace Pokeface\BarkPush;

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\ServiceProvider;
use Pokeface\BarkPush\Controllers\BarkPushController;


class BarkPushServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/Configs/BarkPushConfig.php', 'BarkPushConfig');
    }
    public function register()
    {
        $this->registerRoutes();
        $this->app->bind('BarkPush', function () {
            return new BarkPushController();
        });
        

    }
    
    /**
     * Register the Horizon routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'namespace' => 'Pokeface\BarkPush\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
    
    /**
     * @return array
     */
    public function provides()
    {
        return array('BarkPush');
    }
    
    
}