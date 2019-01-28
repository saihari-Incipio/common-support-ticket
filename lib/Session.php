<?php
/**
 * Description of Session
 *
 * @author Harikrishna<harikrishna@incipio.com>
 */
class Session {
    
    public static function setReadonly($param, $value) {
        
        self::checkReadOnlyExist($param);
        
        if(!isset($_SESSION[PROJECT_NAME])) {
            $_SESSION[PROJECT_NAME] = [];
        }
        
        if(!isset($_SESSION[PROJECT_NAME]['readonly'])) {
            $_SESSION[PROJECT_NAME]['readonly'] = [];
        }
        
        $_SESSION[PROJECT_NAME]['readonly'][$param] = $value;
    }
    
    public static function set($param, $value) {
        
        self::checkReadOnlyExist($param);
        
        if(!isset($_SESSION[PROJECT_NAME])) {
            $_SESSION[PROJECT_NAME] = [];
        }
        
        $_SESSION[PROJECT_NAME][$param] = $value;
    }
    
    public static function get($param) {
        if(isset($_SESSION[PROJECT_NAME][$param])) {
            return $_SESSION[PROJECT_NAME][$param];
        } else if(isset($_SESSION[PROJECT_NAME]['readonly'][$param])) {
            return $_SESSION[PROJECT_NAME]['readonly'][$param]; 
        } else {
            return '';
        }
    }
    
    public static function remove($param) {
        if(isset($_SESSION[PROJECT_NAME][$param])) {
            unset($_SESSION[PROJECT_NAME][$param]);
        }
    }
    
    public static function destroy() {
        unset($_SESSION[PROJECT_NAME]);
    }

    private static function checkReadOnlyExist($param) {
        if(isset($_SESSION[PROJECT_NAME]['readonly'][$param])) {
            throw new Exception("'$param' is readonly.");
        }
    }
}
