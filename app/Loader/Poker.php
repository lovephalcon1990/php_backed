<?php
namespace App\Loader;

use App\Core\Loader;

/**
 * Class App
 * @package App\Loader
 */
class Poker extends Loader
{


    public static $app="";

    /**
     * 执行before
     */
    public function beforeRun()
    {
        self::before();
    }

    /**
     * 加载器
     */
    protected function load()
    {

    }
}
