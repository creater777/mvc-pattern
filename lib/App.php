<?php
/**
 * Created by PhpStorm.
 * Users: Professional
 * Date: 06.08.2021
 * Time: 11:13
 */

namespace Lib;

use RedBeanPHP\Facade;

class App
{
    public static $getRequest;
    public static $requestArguments;

    public static $controllerName;
    public static $method;

    public static $config;

    public static $appRoot;
    public static $webRoot;

    private static $DB;

    public static $user;

    /**
     * @throws \Exception
     */
    private static function configureRequest(){
        self::$getRequest = count($_GET) <= 0 ? [
            'c' => 'main',
            'm' => 'index'
        ] : $_GET;

        if (!is_array($_SESSION['errors'])) {
            $_SESSION['errors'] = [];
        };

        self::$controllerName = "App\\controllers\\".ucfirst(self::$getRequest['c'])."Controller";
        if (empty(self::$getRequest['c']) ||
            !class_exists(self::$controllerName) ||
            !in_array(self::$getRequest['m'], get_class_methods(self::$controllerName))
        ) {
            header("HTTP/1.0 404 Not Found");
            die("HTTP/1.0 404 Not Found");
        }
        self::$method = self::$getRequest['m'];
        self::$requestArguments = $_GET;
        unset(self::$requestArguments['c']);
        unset(self::$requestArguments['m']);
        self::$requestArguments = array_values(self::$requestArguments);
    }

    /**
     * @throws \Exception
     */
    private static function initConfig(){
        try{
            self::$config = require_once("../config.php");
            if (empty(self::$config)){
                throw new \Exception("No configuration found");
            }
            self::$appRoot = APP_ROOT;
            self::$webRoot = self::$config['WebRoot'];
        } catch (\Exception $e){
            throw $e;
        }
    }

    private static function initUser(){
        self::$user = $_SESSION['user'];
    }

    /**
     * @param $config
     * @throws \Exception
     */
    public static function init(){
        self::initConfig();
        self::configureRequest();
        self::initUser();
    }

    /**
     * @throws \Exception
     */
    private static function configureDB() {
        if (empty(self::$config['DB']) || empty(self::$config['DB']['provider']) || !class_exists(self::$config['DB']['provider'])) {
            throw new \Exception("Database is not configure");
        }
        self::$DB = new self::$config['DB']['provider']();
        if (!self::$DB->configure(self::$config['DB'])) {
            throw new \Exception("Unable connect to DB server");
        };
    }

    /**
     * @return Facade
     * @throws \Exception
     */
    public static function getDBInstance(){
        if (self::$DB === null){
            self::configureDB();
        }
        return self::$DB;
    }

    public static function getView($view){
        $fileName = self::$appRoot."/app/views/$view.php";
        if (!file_exists($fileName)){
            throw new \Exception("No view $view found");
        }
        return $fileName;
    }

    public static function goHome(){
        header('Location: /web/');
    }

    public static function pushError($error){
        $_SESSION['errors'][] = $error;
    }

    public static function shiftErrors(){
        $errors = count($_SESSION['errors']) ? $_SESSION['errors'] : [];
        $_SESSION['errors'] = [];
        return $errors;
    }

    public static function login($user){
        $_SESSION['user'] = $user;
        self::initUser();
    }

    public static function logout(){
        $_SESSION['user'] = null;
        self::initUser();
    }

    public static function userIsLogged(){
        return isset(self::$user);
    }
}