<?php
/**
 * Created by PhpStorm.
 * User: zengyueming
 * Date: 2018/12/24
 * Time: 14:22
 */

try {
    define("ROOT",dirname(__DIR__)."/");
    /**
     * Register the autoloader of composer.
     */
    $vendorLoader = ROOT . 'vendor/autoload.php';
    if (is_file($vendorLoader)) {
        require_once $vendorLoader;
    }
    $app = new \App\Loader\Poker();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}