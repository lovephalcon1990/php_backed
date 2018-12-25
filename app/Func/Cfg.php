<?php
/**
 * Created by PhpStorm.
 * User: zengyueming
 * Date: 2018/12/25
 * Time: 16:57
 */

namespace App\Func;

class Cfg
{
    /**
     * 脚本缓存
     */
    public static $comm = array();//公共配置
    public static $aCache = array();//其他配置缓存
    /**
     * 初始化配置 cfg::init()，在comm.php里调用
     */
    public static function init(){
        self::$comm = (array)self::load('msite', ENV, false, MSITE);
    }

    /**
     * 加载配置
     * @return array()
     */
    public static function load($name, $env = ENV , $reload = false , $site = SITE){
        $file = ROOT_CFG . $env .'/'. $name .'.php';
        if($reload && isset(self::$aCache[$file])){
            unset(self::$aCache[$file]);//重新加载的情况清除缓存
        }
        if(isset(self::$aCache[$file])){
            return self::$aCache[$file];
        }
        if(is_file($file)){
            self::$aCache[$file] = include($file);
        }else{
            self::$aCache[$file] = array();
        }
        return self::$aCache[$file];
    }
}