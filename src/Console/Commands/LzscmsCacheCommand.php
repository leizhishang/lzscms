<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Console\Commands;

use Leizhishang\Lzscms\Lzscms;
use Leizhishang\Lzscms\Model\CommonRoleModel;
use Leizhishang\Lzscms\Model\CommonRoleUriModel;
use Leizhishang\Lzscms\Model\ManageMenuModel;
use Leizhishang\Lzscms\Model\ManageUserModel;
use Leizhishang\Lzscms\Model\ManageModulesModel;
use Leizhishang\Lzscms\Model\CommonConfigModel;
use Leizhishang\Lzscms\Model\ApiModel;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class LzscmsCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lzscms:cache {--t=null} {--v=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cache';

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
        CommonRoleModel::setCache('manage', false);
        $this->info('Common Role Success');
        CommonRoleUriModel::setCache('manage', false);
        $this->info('Common Role Uri Success');
        ManageMenuModel::setCache('manage', false);
        $this->info('Manage Menu Success');
        ManageUserModel::setCache(false);
        $this->info('Manage User Success');
        ManageModulesModel::setCache(false);
        $this->info('Modules Success');
        CommonConfigModel::setAllCache();
        $this->info('Config Success');
        ApiModel::setCache();
        $this->info('Api Success');
        $this->call('hook:cache', [
            '--p'=>'all'
        ]);
        Lzscms_hook('s_cache');
        $this->info('Success');
    }
}
