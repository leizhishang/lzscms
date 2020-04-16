<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Console\Commands;

use Leizhishang\Lzscms\Lzscms;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class LzscmsSeedCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'Lzscms:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with records for a specific or all Lzscms';

    /**
     * @var Lzscms
     */
    protected $Lzscms;

    /**
     * Create a new command instance.
     *
     * @param Lzscms $Lzscms
     */
    public function __construct(Lzscms $Lzscms)
    {
        parent::__construct();

        $this->Lzscms = $Lzscms;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $seeder = ['ManageUser', 'CommonConfig', 'CommonRole', 'CommonRoleUri', 'ManageMenu'];
        if($seeder) {
            if($this->option('table')) {
                if(in_array($this->option('table'), $seeder)) {
                    $fullPath = 'Leizhishang\Lzscms\Database\Seeds\\'.$this->option('table').'TableSeeder';
                    $this->seed($fullPath, $this->option('table'));
                }
            } else {
                foreach ($seeder as $key => $value) {
                    $fullPath = 'Leizhishang\Lzscms\Database\Seeds\\'.$value.'TableSeeder';
                    $this->seed($fullPath, $value);
                }
            }
        }
    }

    /**
     * Seed the specific module.
     *
     * @param string $module
     *
     * @return array
     */
    protected function seed($fullPath, $table)
    {
         if (class_exists($fullPath)) {
            if ($this->option('class')) {
                $params['--class'] = $this->option('class');
            } else {
                $params['--class'] = $fullPath;
            }
            if ($option = $this->option('database')) {
                $params['--database'] = $option;
            }
            if ($option = $this->option('force')) {
                $params['--force'] = $option;
            }
            $this->call('db:seed', $params);
            $this->info('Seed: '. $table);
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['table', null, InputOption::VALUE_OPTIONAL, 'The table name of the Lzscms\'s root seeder.'],
            ['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the Lzscms\'s root seeder.'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run while in production.'],
        ];
    }
}
