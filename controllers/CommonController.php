<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonController
 *
 * @author INCIPIO PHP SAi Harikrishna
 */
class CommonController extends ControllerBase{
    
    const MYSQL_DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    const MYSQL_DATE_FORMAT = 'Y-m-d';

    public function __construct() {
        parent::__construct();
//        $this->_model = new DesignModel();
    }
    
    public function dashboardAction() {
        parent::dashboardAction();
    }
    
}
