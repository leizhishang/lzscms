<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class ConsoleServiceProvider extends ServiceProvider
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
        $this->registerInstallCommand();
        $this->registerInfoCommand();
        $this->registerSeedCommand();
        $this->registerCacheCommand();
        $this->registerHookCommand();
    }

    /**
     * Register the lzscms.install command.
     */
    protected function registerInstallCommand()
    {
        $this->app->singleton('command.lzscms.install', function ($app) {
            return new \Leizhishang\Lzscms\Console\Commands\LzscmsInstallCommand($app['lzscms']);
        });
        $this->commands('command.lzscms.install');
    }

    /**
     * Register the lzscms.info command.
     */
    protected function registerInfoCommand()
    {
        $this->app->singleton('command.lzscms.info', function ($app) {
            return new \Leizhishang\Lzscms\Console\Commands\LzscmsInfoCommand($app['lzscms']);
        });
        $this->commands('command.lzscms.info');
    }

    /**
     * Register the module:seed command.
     */
    protected function registerSeedCommand()
    {
        $this->app->singleton('command.lzscms.seed', function ($app) {
            return new \Leizhishang\Lzscms\Console\Commands\LzscmsSeedCommand($app['lzscms']);
        });
        $this->commands('command.lzscms.seed');
    }

    /**
     * Register the module:cache command.
     */
    protected function registerCacheCommand()
    {
        $this->app->singleton('command.lzscms.cache', function ($app) {
            return new \Leizhishang\Lzscms\Console\Commands\LzscmsCacheCommand($app['lzscms']);
        });
        $this->commands('command.lzscms.cache');
    }

    protected function registerHookCommand()
    {
        $this->app->singleton('command.hook.cache', function ($app) {
            $file = $this->app->make(Filesystem::class);
            return new \Leizhishang\Lzscms\Console\Commands\HookCacheCommand($file);
        });
        $this->commands('command.hook.cache');

        $this->app->singleton('command.hook.list', function ($app) {
            return new \Leizhishang\Lzscms\Console\Commands\HookListCommand($app['lzscms']);
        });
        $this->commands('command.hook.list');
        
        $this->app->singleton('command.hook.manage', function ($app) {
            return new \Leizhishang\Lzscms\Console\Commands\HookManageCommand($app['lzscms']);
        });
        $this->commands('command.hook.manage');
    }
}
