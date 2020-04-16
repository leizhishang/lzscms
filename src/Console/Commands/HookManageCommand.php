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
use Symfony\Component\Console\Input\InputArgument;

class HookManageCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hook:manage';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hook Manage';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $slug = $this->argument('slug');
        $value = $this->argument('value');
        if($slug && $value) {
            if($slug == 'module') {
                HookModel::del('', $value);
            } else if($slug == 'i') {
                if($value) {
                    $values = explode(',', $value);
                    if(isset($values[0]) && isset($values[1])) {
                        HookInjectModel::where('alias', $values[0])->where('hook_name', $values[1])->delete();
                    }
                }
            } else {
                HookModel::del($value);
            }
            $this->call('hook:cache');
            $this->info('Delete Success');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['slug', InputArgument::REQUIRED, 'Hook slug.'],
            ['value', InputArgument::REQUIRED, 'Hook value.']
        ];
    }
}
