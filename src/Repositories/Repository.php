<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Repositories;

use Leizhishang\Lzscms\Contracts\Repository as RepositoryContract;

use Illuminate\Config\Repository as Config;

class Repository implements RepositoryContract
{
    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Constructor method.
     *
     * @param \Illuminate\Config\Repository     $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function version()
    {
        return $this->config->get('hstcms.version');
    }
}
