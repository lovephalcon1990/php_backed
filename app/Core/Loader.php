<?php
namespace App\Core;

use App\Func\Cfg;
use App\Func\Def;

/**
 * 继承来改变部分接口
 */
abstract class Loader
{
    /**
     * 执行
     */
    public function run()
    {
        /*
         * PHP版本检测
         */
        version_compare(PHP_VERSION, '5.6.30', '>=') or die('PHP version must be at least 5.6.30');

        /*
         * 检测框架是否安装
         */
        extension_loaded('mysqli') or die('Phalcon framework extension is not installed');

        $this->beforeRun();

        /*
         * 默认时区定义
         */
        if (date_default_timezone_get() != Cfg::$comm["timeZone"]) {
            date_default_timezone_set(Cfg::$comm["timeZone"]);
        }

        /*
         * 设置默认区域
         */
        setlocale(LC_ALL, Cfg::$comm["area"]);

        /*
         * 设置内部字符默认编码为 UTF-8
         */
        mb_internal_encoding(Cfg::$comm["coding"]);


        /*
         * use Phalcon Error handle
         * @see https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Error
         */
        Error::register();

    }

    /**
     * 加载器，采用模板方法
     *
     * @return mixed
     */
    abstract protected function load();

    /**
     * 设置配置
     */
    public static function before()
    {
        /**
         * Include defined constants.
         */
        Def::init();
        /**
         * Include site config.
         */
        Cfg::init();
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
}
