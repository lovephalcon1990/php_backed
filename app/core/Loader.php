<?php
namespace App\Core;

use App\Func\Def;
/**
 * phalcon 服务引导入口
 * 采用设计模式模板方法
 * 利用继承来改变部分接口
 * @see http://www.phppan.com/2010/09/php-design-pattern-16-template-method/
 */
abstract class Loader
{
    public $config;

    /**
     * 执行
     */
    public function run()
    {
        $this->beforeRun();

        /*
         * PHP版本检测
         */
        version_compare(PHP_VERSION, '5.6.30', '>=') or die('PHP version must be at least 5.6.30');

        /*
         * 检测框架是否安装
         */
        extension_loaded('mysqli') or die('Phalcon framework extension is not installed');

        /*
         * 默认时区定义
         */
        if (date_default_timezone_get() != 'Asia/Shanghai') {
            date_default_timezone_set('Asia/Shanghai');
        }

        /*
         * 设置默认区域
         */
        setlocale(LC_ALL, 'zh_CN.utf-8');

        /*
         * 设置内部字符默认编码为 UTF-8
         */
        mb_internal_encoding('UTF-8');

        /**
         * Include defined constants.
         */
        Def::init();

        /*
         * use Phalcon Error handle
         *
         * @see http://php.net/manual/zh/function.set-error-handler.php
         * @see https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Error
         */
        Error::register();

        /**
         *  调用加载器
         */
        $this->load();
    }

    /**
     * 加载器，采用模板方法
     *
     * @return mixed
     */
    abstract protected function load();

    /**
     * 获取加载器
     */
    public function getLoader()
    {
    }

    /**
     * 设置配置
     *
     * @param $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * 注册自动加载
     */
    public static function register()
    {

    }
}
