<?php

class Router {

    private $_module;
    private $_controller;
    private $_action;

    public function __construct() {

        $path = isset($_REQUEST['r']) ? $_REQUEST['r'] : '';
        //echo '<pre>';print_r($path);exit;

        $routes = include_once 'routes.php';

        if (!empty($routes[$path])) {
            $paths = explode('/', $routes[$path]);
        } else {
            $paths = explode('/', $path);
        }

        //$this->_module = (isset($paths[0]) && $paths[0] != '') ? $paths[0] : DEFAULT_MODULE;
        $this->_controller = (isset($paths[0]) && $paths[0] != '') ? $paths[0] : DEFAULT_CONTROLLER;
        $this->_action = (isset($paths[1]) && $paths[1] != '') ? $paths[1] : DEFAULT_ACTION;

        //echo '<pre>';print_r($this);exit;
    }

    public function getModule() {
        return $this->_module;
    }

    public function getController() {
        return $this->_controller;
    }

    public function getAction() {
        return $this->_action;
    }

}
