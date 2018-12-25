<?php
/**
 * Created by PhpStorm.
 * User: zengyueming
 * Date: 2018/12/25
 * Time: 16:19
 */

namespace App\Core;

class Route
{
    public function __construct()
    {
        self::_addSlashesForGPC();
    }


    public function parseRequest()
    {

    }

    /**
     * 递归将数组字符串元素中的特殊字符转义（单引号（'）、双引号（"）、反斜线（\）、NUL（NULL字符））
     * @param array $arr 数组
     * @return array
     */
    public static function addSlashes($arr) {
        foreach ($arr as &$val) { // 注意这里的$val一定要是引用
            if (is_string($val)) {
                $val = addslashes($val);
            } else if (is_array($val)) {
                call_user_func(__METHOD__, $val);
            }
        }
        return $arr;
    }

    /**
     * 对GET/POST/COOKIE超全局数组中的特殊字符进行转义处理
     */
    private static function _addSlashesForGPC() {
        // 如果系统没有开启对超全局变量中的特殊字符自动转义，则手动进行转义之
        if (!get_magic_quotes_gpc() && !defined('GPC_SLASHES_ADDED')) {
            define('GPC_SLASHES_ADDED', 1);
            !empty($_GET) && $_GET = self::addSlashes($_GET);
            !empty($_POST) && $_POST = self::addSlashes($_POST);
            !empty($_COOKIE) && $_COOKIE = self::addSlashes($_COOKIE);
        }
    }
}