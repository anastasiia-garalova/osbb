<?php

define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');

require_once(ROOT.DS.'lib'.DS.'init.php');

//$router = new Router($_SERVER['REQUEST_URI']);
/*
echo "<pre>";
print_r('Route: '.$router -> getRoute().PHP_EOL);
print_r('Language: '.$router -> getLanguage().PHP_EOL);
print_r('Controller: '.$router -> getController().PHP_EOL);
print_r('Action to be called: '.$router -> getMethodPrefix().$router -> getAction().PHP_EOL);
echo 'Parms: ';
print_r($router->getParams());
*/
//$url = $_SERVER['REQUEST_URI'];

//Session::setFlash('Test message');
session_start();
App::run($_SERVER['REQUEST_URI']);

/*
$test = App::$db->query('select * FROM news');
echo "<pre>";
print_r($test);
*/

// Задание. Все исключения должны отлавливаться файликом index.php (видео "Контроллеры")