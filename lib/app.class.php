<?php

class App{

    protected static $router;

    public static $db;

    public static function getRouter(){
        return self::$router;
    }

    public static function run($uri){
        self::$router = new Router($uri);

        self::$db = new DB(Config::get('db.host'), Config::get('db.user'),Config::get('db.password'),
        Config::get('db.name') );


        Lang::load(self::$router->getLanguage());

        $controller_class = ucfirst(self::$router->getController()).'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

        $layout = self::$router->getRoute();

        if ($layout == 'admin' ){
            if(Session::get('role')!='admin'){
                if( Session::get('role')!='editor'){
                    if($controller_method != 'admin_login'){
                        Router::redirect('/admin/users/login');
                    }
                }
            }
        }
        // Calling controller's method
        $controller_object = new $controller_class();

        if(method_exists($controller_object,$controller_method)){
            //Controller's actions may
            $view_path = $controller_object->$controller_method();
            $view_object = new View($controller_object->getData(),$view_path);
            $content =  $view_object->render();
        } else{
            throw new Exception('Method '.$controller_method.' or class '.$controller_class.' does not exist.');
        }
        $menu = $view_object->menu();

        $loyaut_path = VIEWS_PATH.DS.$layout.'.html';
        $layout_view_object = new View(compact('content','menu'),$loyaut_path );
        echo $layout_view_object->render();
    }
}