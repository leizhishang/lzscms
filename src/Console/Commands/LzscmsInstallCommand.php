<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Console\Commands;

use Leizhishang\Lzscms\Lzscms;

use Illuminate\Console\Command;

class LzscmsInstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'lzscms:install {--data=true}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lzscms Install';

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
        $boolData = $this->option('data');
        $this->call('migrate', [
            '--force' => true
        ]);
        $this->call('db:seed');
        $seedListsClass = [
            'CommonConfig', 'CommonRole', 'ManageMenu', 'CommonRoleUri'
        ];
        if($seedListsClass) {
            foreach ($seedListsClass as $class) {
                $this->call('db:seed', [
                    '--class' => $class . 'TableSeeder'
                ]);
            }
        }
        //Set up test data in the database
        if (!empty($boolData))
        {
            $seedListClass = [
                //'Article'
            ];
            if($seedListClass) {
                foreach ($seedListClass as $class) {
                    $this->call('db:seed', [
                        '--class' => $class . 'TableSeeder'
                    ]);
                }
            }
        }
    }
}
