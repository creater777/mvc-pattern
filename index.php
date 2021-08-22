<?php
include "vendor/autoload.php";

use Lib\App;

define("APP_ROOT", __DIR__);

session_start();

try{
    App::init();
} catch (\Exception $e){
    App::pushError($e->getMessage());
}

ob_start();
try {
    $result = App::run(new App::$controllerName(), App::$method, App::$requestArguments);
    $view = $result['view'];
    $model = $result['model'];
    $result && require App::getView($view);
} catch (Exception $e) {
    App::pushError($e->getMessage());
}

$content = ob_get_clean();
$errors = App::shiftErrors();

require_once App::$webRoot."/index.php";
?>