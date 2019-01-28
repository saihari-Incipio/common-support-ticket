<?php

class View {

    private $_renderPath;
    private $_layoutPath;
    private $_params;

    public function __construct($template = null) {

        global $router;
        $controller = strtolower($router->getController());
        $action = strtolower($router->getAction());

        $viewPath = DOC_ROOT_PATH . DS . 'views' . DS . $controller . DS;
        $commonViewPath = DOC_ROOT_PATH . DS . 'views' . DS . 'common' . DS;
        $this->_layoutPath = $viewPath . 'layout.php';

        if (!empty($template)) {
            $templatePath = DOC_ROOT_PATH .DS . 'views'.DS . $template . '.php';
        } else {
            $templatePath = $viewPath . $action . '.php';
              if(!file_exists($templatePath)) {
                $templatePath = $commonViewPath . $action . '.php';
            }
        }

        $this->_renderPath = $templatePath;
    }

    public function addParam($paramKey, $paramValue) {
        $this->_params[$paramKey] = $paramValue;
    }

    public function render($withLayout = true) {
        if (!file_exists($this->_renderPath)) {
            throw new Exception('Rendering view "' . $this->_renderPath . '" is not exist');
        }

        if ($withLayout) {
            $this->_params['templatePath'] = $this->_renderPath;
            extract($this->_params);
            include_once $this->_layoutPath;
        } else {
            if (!empty($this->_params))
                extract($this->_params);
            include_once $this->_renderPath;
        }
    }
    
    public function setTemplate($template) {
        $this->_renderPath = DOC_ROOT_PATH .DS . 'views'.DS . $template . '.php';
    }
    
    public function getViewContent() {
        if (!file_exists($this->_renderPath)) {
            throw new \Exception('Rendering view "'.$this->_renderPath.'" is not exist');
        }

        if (!empty($this->_params))
            extract($this->_params);
        
        ob_start(); @ob_clean();
        include $this->_renderPath;
        $opData = ob_get_clean();
        @ob_end_clean();
        return $opData;
    }

}
