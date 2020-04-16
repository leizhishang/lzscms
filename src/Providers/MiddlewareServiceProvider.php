<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton('manage.request.log', function ($app) {
            return new \Leizhishang\Lzscms\Http\Middleware\RequestLog($app['lzscms']);
        });
        $this->app->singleton('manage.auth.check', function ($app) {
            return new \Leizhishang\Lzscms\Http\Middleware\CheckAuth($app['lzscms']);
        });
        $this->app->singleton('api.service', function ($app) {
            return new \Leizhishang\Lzscms\Http\Middleware\ApiService($app['lzscms']);
        });
        $this->app->singleton('module.service', function ($app) {
            return new \Leizhishang\Lzscms\Http\Middleware\ModuleService($app['lzscms']);
        });
        $this->app->singleton('check.site.status', function ($app) {
            return new \Leizhishang\Lzscms\Http\Middleware\CheckSiteStatus($app['lzscms']);
        });
        // $this->app->singleton('module.api.service', function ($app) {
        //     return new \Leizhishang\Lzscms\Http\Middleware\ModuleApiService($app['lzscms']);
        // });
        // $this->app->singleton('module.openapi.service', function ($app) {
        //     return new \Leizhishang\Lzscms\Http\Middleware\ModuleOpenApiService($app['lzscms']);
        // });
    }
}
