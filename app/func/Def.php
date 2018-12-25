<?php
namespace App\Func;

class Def
{
    /**
     * 初始化
     */
    public static function init()
    {

        define('ENV', get_cfg_var('my.env'));
        defined('PRO')  or define('PRO', ENV==='prd');

        define('ROOT_DATA', ROOT."data/");

        define('IS_CLI', (PHP_SAPI === 'cli'));

        if (IS_CLI) {
            define('IS_AJAX', false);
            define('IS_CURL', false);
        } else {
            // 定义是否 AJAX 请求
            define('IS_AJAX',
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
            );

            // 定义是否 cURL 请求
            define('IS_CURL',
                isset($_SERVER['HTTP_USER_AGENT']) &&
                stripos($_SERVER['HTTP_USER_AGENT'], 'curl') !== false
            );
        }

        /*
         * 打开/关闭错误显示
         * 在 OA 系统中显示错误
         */
        ini_set('display_errors', !PRO);

        /*
         * 避免 cli 或 curl 模式下 xdebug 输出 html 调试信息
         */
        ini_set('html_errors', !(IS_CLI || IS_CURL));
        /*
         * 设置错误报告模式
         */
        error_reporting(PRO ? 0 : (E_ALL | E_STRICT));
    }
}
