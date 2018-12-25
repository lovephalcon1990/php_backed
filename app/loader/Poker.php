<?php
namespace App\Loader;

use App\Core\Loader;

/**
 * Class App
 * @package App\Loader
 */
class Poker extends Loader
{

    /**
     * 执行钩子
     */
    public function beforeRun()
    {
        self::register();
    }

    /**
     * 加载器
     */
    protected function load()
    {
        
    }
}
