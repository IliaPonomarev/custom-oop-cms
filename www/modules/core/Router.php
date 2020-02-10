<?php

namespace modules\core;

use modules\core\View;

/**
 * Class Router
 * @package modules\core
 */
class Router
{
    /**
     * @var string
     */
    public $uri;
    /**
     * @var mixed
     */
    public $routes;
    /**
     * @var
     */
    public $params;

    /**
     * Router constructor.
     */
    public function __construct()
    {

        $this->routes = require 'data/config/routes.php';
        $this->uri = $this->getUri();
    }

    /**
     * @return string
     */
    public function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * @return bool
     */
    public function match()
    {
        foreach ($this->routes as $key => $route) {
            $uri = strtok( $this->uri, '?');
            if (preg_match('#^' . $key . '$#', $uri, $matches)) {
                $this->params = $route;
                return true;
            }
        }

        return false;
    }


    public function run()
    {
        if ($this->match()) {
            $modulePath = ROOT . '/modules/' . $this->params['module'];
            if (file_exists($modulePath)) {
                $pathToClass = 'modules\\' . $this->params['module'] . '\Controller';
                if (class_exists($pathToClass)) {
                    $actionName = 'action_' . $this->params['action'];
                    if (method_exists($pathToClass, $actionName)) {
                        $controller = new $pathToClass($this->params);
                        $controller->$actionName();
                    } else {
                        echo 'ошибка 404';
                        die;
                    }
                } else {
                    echo 'ошибка 404';
                    die;
                }
            } else {
                echo 'ошибка 404';
                die;
            }
        } else {
            echo 'ошибка 404';
            die;
        }
    }
}
