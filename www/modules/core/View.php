<?php

namespace modules\core;

/**
 * Class View
 * @package modules\core
 */
class View
{
    /**
     * @var
     */
    protected $route;
    /**
     * @var string
     */
    protected $path;

    /**
     * View constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['module'] . '/' . $route['action'];
        $this->layout = 'default';

    }

    /**
     * @param $title
     * @param array $vars
     */
    public function render($title, $vars = [])
    {
        $path = ROOT . '/templates/' . $this->path . '.php';
        // print_r($path);die;
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require ROOT . '/templates/layouts/' . $this->layout . '.php';
        }
    }

    public function redirect($url) {
        header('location: /'.$url);
        exit;
    }
}