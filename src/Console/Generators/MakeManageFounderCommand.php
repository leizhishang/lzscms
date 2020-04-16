<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Console\Generators;

use Leizhishang\Lzscms\Lzscms;
use Leizhishang\Lzscms\Model\ManageUserModel;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class MakeManageFounderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:lzscms:manage:founder {--t=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lzscms Manage Founder';

    /**
     * The Lzscms instance.
     *
     * @var Lzscms
     */
    protected $Lzscms;

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Lzscms    $Lzscms
     */
    public function __construct(Filesystem $files, Lzscms $Lzscms)
    {
        parent::__construct();

        $this->files  = $files;
        $this->Lzscms = $Lzscms;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->stepOne();
    }

    /**
     * Step 1: Configure module manifest.
     *
     * @return mixed
     */
    private function stepOne()
    {
        $t = $this->option('t');
        if($t === 'add') {
            $this->container['username']        = $this->ask('Please enter the username:', 'admin1');
            $this->container['password']        = $this->ask('Please enter the password:', 'admin888');
            $this->comment('You have provided the following manifest information:');
            $this->comment('Username:                           '.$this->container['username']);
            $this->comment('Password:                           '.$this->container['password']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) {
                if(ManageUserModel::where('username', $this->container['username'])->count()) {
                    $this->error(lzs_lang('lzscms::manage.founder.username.noone'));
                    return $this->stepOne();
                }
                $salt = Lzs_random(6);
                $postData = [
                    'username'=>trim($this->container['username']),
                    'password'=>trim(lzs_md5(trim($this->container['password']), $salt)),
                    'salt'=>$salt,
                    'status'=>1,
                    'gid'=>99
                ];
                ManageUserModel::insert($postData);
                ManageUserModel::setCache();
                $this->info('Add Success');
            }
        } else if($t === 'edit') {
            $this->container['username']        = $this->ask('Please enter the username:', 'admin1');
            $this->container['password']        = $this->ask('Please enter the new password:', 'admin888');
            $this->comment('You have provided the following manifest information:');
            $this->comment('Username:                           '.$this->container['username']);
            $this->comment('Password:                           '.$this->container['password']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) {
                $user = ManageUserModel::where('username', $this->container['username'])->first();
                if(!$user) {
                    $this->error(lzs_lang('lzscms::manage.no.username'));
                    return true;
                }
                $postData = [
                    'username'=>trim($this->container['username']),
                    'password'=>trim(lzs_md5(trim($this->container['password']), $user['salt'])),
                ];
                ManageUserModel::where('username', $this->container['username'])->update($postData);
                ManageUserModel::setCache();
                $this->info('Edit Success');
            }
        } else if($t === 'delete') {
            $this->container['username']        = $this->ask('Please enter the username:', 'admin1');
            $this->comment('You have provided the following manifest information:');
            $this->comment('Username:                           '.$this->container['username']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) {
                $user = ManageUserModel::where('username', $this->container['username'])->first();
                if(!$user) {
                    $this->error(lzs_lang('lzscms::manage.no.username'));
                    return true;
                }
                ManageUserModel::where('username', $this->container['username'])->delete();
                ManageUserModel::setCache();
                $this->info('Delete Success');
            }
        }   
        return true;
    }
}
