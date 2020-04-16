<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms;

use Leizhishang\Lzscms\Contracts\Repository;
use Leizhishang\Lzscms\Providers\RouteServiceProvider;
use Leizhishang\Lzscms\Providers\HelperServiceProvider;
use Leizhishang\Lzscms\Providers\ConsoleServiceProvider;
use Leizhishang\Lzscms\Providers\LibrariesServiceProvider;
use Leizhishang\Lzscms\Providers\RepositoryServiceProvider;
use Leizhishang\Lzscms\Providers\MiddlewareServiceProvider;
use Leizhishang\Lzscms\Providers\GeneratorServiceProvider;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

class LzscmsServiceProvider extends ServiceProvider
{ 
    /**
     * @var bool Indicates if loading of the provider is deferred.
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/lzscms.php' => config_path('lzscms.php'),
        ], 'config');
        $this->loadViewsFrom(__DIR__.'/../views', 'lzscms');
        $this->publishes([
            __DIR__.'/../assets' => public_path('assets'),
        ], 'public');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../translations', 'lzscms');
        //处理单页多元化模版
        $this->loadViewsFrom(public_path('theme/special'), 'special');
        Paginator::defaultView('lzscms::pagination.default');
        Paginator::defaultSimpleView('lzscms::pagination.simple-default');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/lzscms.php', 'lzscms'
        );
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(LibrariesServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(GeneratorServiceProvider::class);

        $this->app->singleton('lzscms', function ($app) {
            $repository = $app->make(Repository::class);
            return new Lzscms($app, $repository);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string
     */
    public function provides()
    {
        return ['lzscms'];
    }
}
