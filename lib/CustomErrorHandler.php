<?php

define('E_FATAL', E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);

class CustomErrorHandler {
    
    public static function enable($errorLogPath='tmp/logs/') {
        
        if (ENV == 'LOCAL') {
            ini_set('display_errors', true);
        } else {
            ini_set('display_errors', false);
        }
        
        //error_reporting(E_ALL);
        
        // set error log file for all type of errors
        ini_set('log_errors', true);
        ini_set('error_log', $errorLogPath.date('Ymd')."-php-error.log");
        
        // Handle fatal errors
        //register_shutdown_function('lib\CustomErrorHandler::shutdownTracker');
        register_shutdown_function(array("CustomErrorHandler", "shutdownTracker"));
    }
    
    public static function shutdownTracker() {
        $error = error_get_last();
        if(!empty($error) && ($error['type'] & E_FATAL)) {
            echo '<pre>';
            self::sendMail($error);
            //echo '<span style="color: red;">Internal server error</span>';exit;
        }
    }
    
    private static function sendMail($errorData) {
        
        $body = array();
        
        $requestProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
        $requestUrl = $requestProtocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        
        // make file path clean
        $errorData['file'] = str_replace(DOC_ROOT_PATH, '', $errorData['file']);
        
        $body['Error Details'] = '<span style="color: red;">'.print_r($errorData, 1).'</span>';
        $body['Request Url'] = $requestUrl;
        $body['Request Method'] = $_SERVER['REQUEST_METHOD'];
        $body['Request Parameters'] = $_REQUEST;
        $body['Request File Parameters'] = $_FILES;
        $body['Browser Info'] = '<span style="color: blue;">'.$_SERVER['HTTP_USER_AGENT'].'</script>';

        $subject = 'Invite Portal: Application Error';
        
        $body = '<div style="background-color: #eaeaea; padding: 20px; font-family: Arial, Helvetica, sans-serif">
            <div style="background-color: #ffffff; margin: 10px auto; padding: 4px 32px 26px;">
                <div style="margin-top: 20px; font-size: 15px;"><pre>'.print_r($body, true).'</pre></div>
            </div>
        </div>';
    
        
        //print_r($body);exit;
            //============================================================================//
        //echo $body;exit;
        $mail = new PHPMailer(); 
        $mail->CharSet = 'UTF-8'; // Fix some unfamilier charecter issue
        $mail->Encoding = "base64"; // Fix html body spacing issue
        $mail->Subject = $subject;
        $mail->SetFrom('donotreply@incipio.com', 'No Reply - Invite Portal');
        $mail->MsgHTML($body);
        $mail->AddAddress('harikrishna@incipio.com', 'Sai Harikrishna');
        return $mail->Send();
    }
}