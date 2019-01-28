<?php

class App {

    private $_router;

    public function initialize($router) {
        $this->_router = $router;
        $this->setIncludePath();
        $this->registerAutoLoad();
        
        CustomErrorHandler::enable();
        //$this->setErrorLog();
    }

    private function setIncludePath() {
        set_include_path(implode(PATH_SEPARATOR, array(
            realpath(DOC_ROOT_PATH . DS . 'controllers'),
            realpath(DOC_ROOT_PATH . DS . 'models'),
            realpath(DOC_ROOT_PATH . DS . 'lib'),
            realpath(DOC_ROOT_PATH . DS . 'lib/mailer'),
            get_include_path()
        )));
    }

    private function registerAutoLoad() {
        spl_autoload_register(array('App', 'loadObject'));
    }

    private function loadObject($className) {
        include_once($className . '.php');
    }

    private function setErrorLog() {

        if (ENV == 'LOCAL') {
            ini_set('display_errors', true);
        } else {
            ini_set('display_errors', false);
        }

        ini_set("log_errors", 1);
        ini_set("error_log", LOG_FILE_PATH . date('Ymd') . "-php-error.log");
    }

    public function run() {
        $controller = ucfirst($this->_router->getController());
        $action = $this->_router->getAction();

        if (method_exists($controller . 'Controller', $action . 'Action')) {

            $controllerClass = $controller . 'Controller';
            $object = new $controllerClass;

            call_user_func(array($object, $action . 'Action'));
        } else {
            //App::pre($this->_router);

            header('Location: ' . SITE_URL . 'pagenotfound');
            exit;
            //throw new Exception("Invalid Request");
        }
    }

    public static function pre($data, $exit = true) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($exit) {
            exit('print r exit');
        }
    }

}
