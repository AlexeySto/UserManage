<?php

namespace Alexey\MyProdject\Application;

use Alexey\MyProdject\Domain\Controllers\AbstractController;
use Alexey\MyProdject\Infrastructure\Config;
use Alexey\MyProdject\Infrastructure\Storage;
use Alexey\MyProdject\Application\Auth;


class Application {

    private const APP_NAMESPACE = 'Alexey\MyProdject\Domain\Controllers\\';

    private string $controllerName;
    private string $methodName;

    public static Config $config;

    public static Storage $storage;

    public static Auth $auth;

    public function __construct(){
        Application::$config = new Config();
        Application::$storage = new Storage();
        Application::$auth = new Auth();
    }

    public function runApp(): string {
        $result = $this->run();
        return $result;
    }


    private function run() : string {
        session_start();
        Application::$auth->restoreSession();

        $routeArray = explode('/', $_SERVER['REQUEST_URI']);
        
        // Определяем имя контроллера
        if ($controllerName = self::getRouteValue($routeArray, 1, "page")) {
            $methodName = self::getRouteValue($routeArray, 2, "index");
        }
        
        self::setControllerName($controllerName);
        self::setMethodName($methodName);

        if(!class_exists($this->controllerName)){
            self::setControllerName("error");
        }

        if(!method_exists($this->controllerName, $this->methodName)){
            self::setControllerName("error");
            self::setMethodName("index");
        }
        
        $controllerInstance = new $this->controllerName();
        if(!self::checkAccessToMethod($controllerInstance, $this->methodName)){
            self::setControllerName("error");
            self::setMethodName("notRules");
        }
        
        // return $this->controllerName . ' ' . $this->methodName;
        return call_user_func_array(
    [$controllerInstance, $this->methodName], []);
    }
    
    private function setControllerName(string $controllerName) : void {
        $this->controllerName = Application::APP_NAMESPACE . ucfirst($controllerName) . "Controller";
    }

    private function setMethodName(string $methodName) : void {
        $this->methodName = "action" . ucfirst($methodName);
    }

    private static function getRouteValue(array $routeArray, int $index, string $defaultValue): string {
        if (isset($routeArray[$index]) && $routeArray[$index] != '') {
            return $routeArray[$index];
        }
        return $defaultValue;
    }

    private function checkAccessToMethod($controllerInstance, $methodName): bool {
        if($controllerInstance instanceof AbstractController){
            $userRules = $controllerInstance->getUserRules();
            $methodRules = $controllerInstance->getActionsPermissions($methodName);

            if(!empty($methodRules)){
                foreach($methodRules as $rulePermission){
                    if(in_array($rulePermission, $userRules)){
                        return true;
                    }
                }
                return false;
            }
            else {
                return true;
            }        
        }
        else {
            return true;
        }
    }
}
