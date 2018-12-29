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
    public $module = "Home";

    public $ctrl = "IndexCtrl";

    public $action="ActionIndex";

    public $ctrlNameSpace = "App\Module\\";

    public function __construct()
    {

    }


    public function handle(){

        $request_uri = $_SERVER["REQUEST_URI"];
        $arr = parse_url($request_uri);
        $preg = "/^\/([a-z]*)\/([a-z]*)\/([a-z]*)$/i";

        preg_match($preg, $arr["path"], $mathes);
        if(isset($mathes[1]) && $mathes[1]){
            $this->module = $this->toBigHump($mathes[1]);
        }
        if(isset($mathes[2]) && $mathes[2]){
            $this->ctrl = $this->toBigHump($mathes[2]);
        }
        if(isset($mathes[3]) && $mathes[3]){
            $this->action = $this->toBigHump($mathes[3]);
        }
        $ctrlNameSpace = $this->ctrlNameSpace. $this->module."\\Ctrl\\".$this->ctrl;
        if(!class_exists($ctrlNameSpace)){
            $ctrlNameSpace = $this->ctrlNameSpace. "Home\\Ctrl\\IndexCtrl";
        }
        $ctrlObj = new $ctrlNameSpace();
        if(!method_exists($ctrlObj, $this->action)){
            throw new \Exception("uri not exit",404);
        }
        call_user_func([$ctrlObj, $this->action]);
    }

    /**
     * 转大驼峰结构
     * @param $str
     * @param string $type
     * @return string
     */
    private function toBigHump($str, $type='m')
    {
        $str = strtolower($str);
        switch ($type){
            case 'm': $str = ucfirst($str);break;
            case 'c': $str = ucfirst($str)."Ctrl";break;
            case 'a': $str = "Action".ucfirst($str);break;
        }
        return $str;
    }


}