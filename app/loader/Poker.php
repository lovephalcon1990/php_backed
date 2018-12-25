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
        $error = false;
        try {
            //获取模块
            $hll_module = $module = 'Index';
            if (array_key_exists("_m", $_GET)) { //指定mod
                $hll_module =   trim($_GET['_m']);
                $module = \Lib_Func::toBigHump($_GET['_m']);
            }
            defined('HLL_MODULE') || define('HLL_MODULE', strtolower($hll_module));

            //获取动作
            $hll_action = $action = 'Index';
            if (array_key_exists("_a", $_GET)) { //指定mod
                $hll_action = trim($_GET['_a']);
                $action = \Lib_Func::toLittleHump($_GET['_a']);
            }
            defined('HLL_ACTION') || define('HLL_ACTION', strtolower($hll_action));

            //获取分组
            $hll_group = $group = 'Index';
            if (array_key_exists("_g", $_GET)) { //指定mod
                $hll_group = trim($_GET['_g']);
                $group = \Lib_Func::toBigHump($_GET['_g']);
            }
            defined('HLL_GROUP') || define('HLL_GROUP', strtolower($hll_group));

            //路由
            $className = 'Ctrller_' . $module;
            $className = !class_exists($className) && $group?'Ctrller_' . $group . '_' . $module:$className;
            if (!class_exists($className)) {
                $className = 'Ctrller_Index';   //这个必须要有
            }
            if (!method_exists($className, $action)) {
                $action = 'index';
            }
            $classObj = new $className;
            $classObj->setOriginalModuleAction($module, $action);

            //php先设置没有缓存
            header('Cache-Control: max-age=0');
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: no-cache");
            $stime  = microtime(true);
            call_user_func(array($classObj, $action));
            $etime  = microtime(true);
            \App_Log::add('request_time', ($etime-$stime). '|'.$stime.'|'.$etime);
        } catch (\Exception $exc) {
            $error = [];
            $error['ret'] = -1;
            $error['error'] = 999;
            $error['data'] = "";
            $error['msg'] = !(defined('PRO') && PRO)? HLL_ENV . " 程序错误 " . $exc->getMessage() . ' ' . var_export($exc->getTraceAsString(), true):'内部异常500';
            \App_Log::error('error.log', ['input' => $_REQUEST, 'output' => $error]);
            \App_Log::add('www/index.php', 'Input:'.  var_export($_REQUEST, true). ' | Exception'.$exc->getMessage());
            $error = \App_Func::jsonEncode($error);
        }
        \App_Log::save($className.'_'.$action);
        if ($error) {
            die($error);
        }
    }
}
