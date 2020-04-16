<?php 
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms;

use Leizhishang\Lzscms\Contracts\Repository;

use Illuminate\Foundation\Application;

class Lzscms
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Create a new Modules instance.
     *
     * @param Application         $app
     * @param Repository $repository
     */
    public function __construct(Application $app, Repository $repository)
    {
        $this->app        = $app;
        $this->repository = $repository;
    }

    /**
     * Oh sweet sweet magical method.
     *
     * @param  string  $method
     * @param  mixed  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->repository, $method], $arguments);
    }
}
