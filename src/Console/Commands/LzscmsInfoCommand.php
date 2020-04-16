<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Console\Commands;

use Leizhishang\Lzscms\Lzscms;

use Illuminate\Console\Command;

class LzscmsInfoCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'lzscms:info {--t=null}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lzscms Info';

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
        $t = $this->option('t');
        switch ($t) {
            case 'version':
                $this->info($this->Lzscms->version());
                break;
            default:
                $this->info('Welcome to use Lzscms');
                $this->info('https://www.Leizhishang.com');
                break;
        }
    }
}
