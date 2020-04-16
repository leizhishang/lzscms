<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Console\Commands;

use Leizhishang\Lzscms\Lzscms;
use Leizhishang\Lzscms\Model\HookModel;
use Leizhishang\Lzscms\Model\HookInjectModel;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Console\Command;

class HookCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'hook:cache {--p=null} {--f=null} {--t=null}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hook Cache';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The Application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * Create a new command instance.
     *
     * @param Lzscms $Lzscms
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $p = $this->option('p');
        $f = $this->option('f');
        $t = $this->option('t');
        $path    = realpath(base_path());
        $appPath    = realpath(app_path());
        if($p !== null && $p !=='all') {
            if($f == 'app') {
                $hooks = $this->files->glob($appPath.'/'.$p.'/Hook/config.php');
            } else {
                $hooks = $this->files->glob($path.'/'.$p.'/Hook/config.php');
            }
            if($hooks) {
                $hookLists = $this->files->getRequire($hooks[0])['hookList'];
                $hookInjects = $this->files->getRequire($hooks[0])['hookInject'];
                $this->initHook($hookLists, $t);
                $this->initHookInject($hookInjects, $t);
            }
        } else if($p !== null && $p === 'all') {
            $hooks = $this->files->glob($appPath.'/Hook/config.php');
            if($hooks) {
                $hookLists = $this->files->getRequire($hooks[0])['hookList'];
                $this->initHook($hookLists);
            }
            $mhooks = $this->files->glob($appPath.'/Modules/*/Hook/config.php');
            if($mhooks) {
                foreach ($mhooks as $hook) {
                    $hookLists = $this->files->getRequire($hook)['hookList'];
                    $this->initHook($hookLists);
                }
            }
            if($hooks) {
                $hookInjects = $this->files->getRequire($hooks[0])['hookInject'];
                $this->initHookInject($hookInjects);
            }
            if($mhooks) {
                foreach ($mhooks as $hook) {
                    $hookInjects = $this->files->getRequire($hook)['hookInject'];
                    $this->initHookInject($hookInjects);
                }
            }
            $vhooks = $this->files->glob($path.'/vendor/Leizhishang/*/src/Hook/config.php');
            if($vhooks) {
                foreach ($vhooks as $hook) {
                    $hookLists = $this->files->getRequire($hook)['hookList'];
                    $hookInjects = $this->files->getRequire($hook)['hookInject'];
                    $this->initHook($hookLists);
                    $this->initHookInject($hookInjects);
                }
            }
        }
        $data = HookModel::setCache();
        $injectAll = HookInjectModel::setAllCache();
        $inject = HookInjectModel::setCache();
        $this->info('hook cache ok!');
    }

    public function initHook($hookLists = []) {
        if($hookLists) {
            foreach ($hookLists as $key => $value) {
                if(!HookModel::where('name', $key)->count()) {
                    HookModel::addInfo($key, $value['description'], $value['document'], 1, $value['module']);
                    $this->info('Add Hook: '.$key.'         Success');
                } else {
                    HookModel::editInfo($key, $value['description'], $value['document']);
                    $this->info('Edit Hook: '.$key.'         Success');
                }
            }
        }
    }

    public function initHookInject($hookInjects = [], $t = null) {
        if($hookInjects) {
            foreach ($hookInjects as $key => $value) {
                foreach ($value as $k => $v) {
                    $info = HookInjectModel::where('hook_name', $v['hook_name'])->where('alias', 'mod_'.$v['alias'])->first();
                    if(!$info && ($t === null || $t === 'null')) {
                        HookInjectModel::addInfo($v['hook_name'], $v['alias'], $v['files'], $v['class'], $v['fun'], $v['description'], 1);
                        $this->info('Add HookInjetct: '.$v['hook_name']. '   '.$v['alias'].'         Success');
                    } else {
                        if($t == 'delete') {
                            HookInjectModel::del('id', $info['id']);
                            $this->info('Delete HookInjetct: '.$v['hook_name']. '   '.$info['alias'].'         Success');
                        } else {
                            HookInjectModel::editInfo($info['id'], $v['hook_name'], $v['alias'], $v['files'], $v['class'], $v['fun'], $v['description']);
                            $this->info('Edit HookInjetct: '.$v['hook_name']. '   '.$info['alias'].'         Success');
                        }
                    }
                }
            }
        }
    }
}
