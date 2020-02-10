<?php

namespace modules\core;

use modules\core\View;

/**
 * Class MController
 * @package modules\core
 */
class MController
{
    protected $view;
    protected $model;

    /**
     * MController constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->view = new View($params);
        $this->model = $this->loadModel($params);
    }

    /**
     * @param  $params
     * @return mixed
     */
    public function loadModel($params)
    {
        $pathToClass = 'modules\\' . $params['module'] . '\Model';
        if (class_exists($pathToClass)) {
            return new $pathToClass();
        }
    }

}