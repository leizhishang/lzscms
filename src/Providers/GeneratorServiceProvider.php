<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Providers;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
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
        $generators = [
            'command.make.lzscms'                   => \Leizhishang\Lzscms\Console\Generators\MakeInstallCommand::class,
            'command.make.lzscms.manage.founder'    => \Leizhishang\Lzscms\Console\Generators\MakeManageFounderCommand::class,
            'command.make.lzscms.api'               => \Leizhishang\Lzscms\Console\Generators\MakeApiCommand::class,
        ];

        foreach ($generators as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });
            $this->commands($slug);
        }
    }
}
