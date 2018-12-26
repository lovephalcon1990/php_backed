<?php
/**
 * Created by PhpStorm.
 * User: zengyueming
 * Date: 2018/12/25
 * Time: 20:12
 */

namespace App\Core;


class Container
{

    private static $_app=[];

    private static $contain;

    private function __construct()
    {

    }

    public static function getInstance(){
        if(self::$contain){
            return self::$contain;
        }
        return self::$contain = new self();
    }

    /**
     * @var Request
     */
    public function request(){
        if(isset(self::$_app['Request']) && self::$_app['Request']){
            return self::$_app['Request'];
        }
        self::$_app["Request"] = new Request();
        return self::$_app["Request"];
    }

    /**
     * @var Route
     */
    public function route(){
        if(isset(self::$_app['Route']) && self::$_app['Route']){
            return self::$_app['Route'];
        }
        self::$_app["Route"] = new Route();
        return self::$_app["Route"];
    }
}