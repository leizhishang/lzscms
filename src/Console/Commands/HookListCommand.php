<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Console\Commands;

use Leizhishang\Lzscms\Model\HookModel;
use Leizhishang\Lzscms\Model\HookInjectModel;

use Illuminate\Console\Command;
use Cache;

class HookListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'hook:list {--t=null}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hook All';

    /**
     * Create a new command instance.
     *
     * @param Lzscms $Lzscms
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $t = $this->option('t');
        if($t == '1') {
            $Hook = HookModel::getAll();
            $Hooks = [];
            $Hooks = HookModel::getAll(2);
            $headers = ['name', 'description'];
            $this->table($headers, $Hooks);
        } else {
            if (!Cache::has('hookInject')) {
                $hookInject = HookInjectModel::setAllCache();
            } else {
                $hookInject = Cache::get('hookInject');
            }
            $hookInjectAll = [];
            foreach ($hookInject as $key => $value) {
                if($hookInjectAll) {
                    $hookInjectAll = array_merge($hookInjectAll, $value);
                } else {
                    $hookInjectAll = $value;
                }
            }
            $headers = ['hookName', 'files', 'class', 'fun'];
            $this->table($headers, $hookInjectAll);
        }
    }
}
