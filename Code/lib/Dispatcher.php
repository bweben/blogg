<?php
// Manages the navigation over the website

session_start();

class Dispatcher
{
    /**
     * used to check which controller, method and arguments must called
     * created in a previous project
     */
    public static function dispatch()
    {
        error_reporting(0);
        ini_set('display_errors',0);

        $url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        $controllerName = !empty($url[0]) ? $url[0] . 'Controller' : 'LoginController';
        $method = !empty($url[1]) ? $url[1] : 'index';
        $args = array_slice($url, 2);
		$controllerName = ucfirst($controllerName);
        require_once("controller/$controllerName.php");
        $controller = new $controllerName();

        //call_user_func(array('BlogController','notfound'));
        call_user_func_array(array($controller, $method), $args);

        unset($controller);
    }
}
