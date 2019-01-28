<?php

class APIHelper {
    
    public static function validateRequestParameters($requiredFields, $params) {

        foreach($requiredFields as $requiredField) {
            if(!isset($params[$requiredField]) || $params[$requiredField] == '') {
                self::sendResponse(new Response(Response::STATUS_FAILED, "'$requiredField' is required."));
            }
        }
    }
    
    public static function sendPostRequest($url, $data, $method = 'POST') : Response {
        
        $ch = curl_init(API_BASE_URL. $url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, base64_decode(JIRA_USER_NAME) . ":" . base64_decode(JIRA_USER_PWD));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8", "Content-Lenght: " . strlen(json_encode($data))));

        $curlResponse = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        
        $curlResponseArray = json_decode($curlResponse, true);
        
        if($curlInfo['http_code'] == 200) {
            $response = new Response(Response::STATUS_SUCCESS, '', $curlResponseArray);
        } else {
            $response = new Response(Response::STATUS_FAILED, self::getFormatedMessage($curlResponseArray));
        }
        
        return $response;
    }
    
    public static function sendGetRequest($url) : Response {
        
        $ch = curl_init(API_BASE_URL. $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, base64_decode(JIRA_USER_NAME) . ":" . base64_decode(JIRA_USER_PWD));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));

        $curlResponse = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        
        $curlResponseArray = json_decode($curlResponse, true);
        
        if($curlInfo['http_code'] == 200) {
            $response = new Response(Response::STATUS_SUCCESS, '', $curlResponseArray);
        } else {
            $response = new Response(Response::STATUS_FAILED, self::getFormatedMessage($curlResponseArray));
        }
        
        return $response;
    }

    public static function sendResponse($response) {
        ob_clean();
        $responseData = $response->getJson();
        echo $responseData;
        
        error_log('Response Details: ');
        error_log(print_r($responseData, true));
        exit;
    }
    
    public static function getFormatedMessage($response) {
        if(isset($response['parameters'])) {
            foreach($response['parameters'] as $key => $value) {
                if(is_int($key)) {
                    $key += 1;
                }
                
                $response['message'] = str_replace("%$key", $value, $response['message']);
            }
        }
        
        return $response['message'];
    }
}

/* This class maintain unique format for API response */
class Response {
    
    const STATUS_FAILED = 'failed';
    const STATUS_SUCCESS = 'success';
    
    private $_status;
    private $_message;
    private $_data;
    
    public function __construct($status, $message, $data = []) {
        
        if(!in_array($status, [self::STATUS_SUCCESS, self::STATUS_FAILED])) {
            throw new Exception('Invalid response status: '.$status);
        }
        
        $this->_status = $status;
        $this->_message = $message;
        $this->_data = $data;
    }
    
    public function getStatus() {
        return $this->_status;
    }
    
    public function getMessage() {
        return $this->_message;
    }
    
    public function getData() {
        return $this->_data;
    }
    
    public function getJson() {
        return json_encode(array('status' => $this->_status, 'message' => $this->_message, 'data' => $this->_data));
    }
    
}