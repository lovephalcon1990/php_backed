<?php
namespace App\Loader;

use App\Core\Container;
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
        self::$app = Container::getInstance();
        self::$app->request();
    }

}
