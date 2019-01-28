<?php

class ApiController {
    
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';

    public function __construct() {
        $this->_model = new APIModel();
    }
    
    public function getRoomNamesAction() {
        $roomsList = $this->_model->getRoomsList();
        self::sendResponse(self::STATUS_SUCCESS, 'Rooms List', $roomsList);
    }
    
    public function getRoomMeetingsAction() {
        
        if(isset($_REQUEST['room_id']) && $_REQUEST['room_id'] != '') {
            $meetingsList = $this->_model->getMeetingRoomsByID($_REQUEST['room_id']);
        } else {
            self::sendResponse(self::STATUS_FAIL, 'Room id is required');
        }
        
        if($meetingsList) {
            self::sendResponse(self::STATUS_SUCCESS, 'Meeting Rooms For Today', $meetingsList);
        } else {
            self::sendResponse(self::STATUS_FAIL, 'No Meeting Rooms For Today', $meetingsList);
        }
        
    }
    
    public static function sendResponse($status, $message, $data = []) {
        ob_clean();
        echo json_encode(array('status' => $status, 'message' => $message, 'data' => $data));
        exit;
    }

    public function requestsAction() {
        //self::sendResponse(self::STATUS_SUCCESS, 'API working');
        
        if(!isset($_REQUEST['email_id']) && !isset($_REQUEST['email_id'])) {
            self::sendResponse(self::STATUS_FAIL, 'Email id is required');
        }
        
        $requests = $this->_model->getRequests($_REQUEST['email_id']);
        //App::pre($requests);
        
        if(empty($requests)) {
            self::sendResponse(self::STATUS_FAIL, 'No requests found');
        }
        
        $response = [];
        foreach($requests as $request) {
            
            $requestData = array(
                'request_type' => $request['request_type'],
                'start_datetime' => $request['start_datetime'],
                'end_datetime' => $request['end_datetime'],
//                'number_of_people' => $request['number_of_people'],
                'customers' => $request['customers'],
                'comments'  => $request['comments']
            );
            
            if($request['request_type'] == "DINNER") {
                $requestData['location'] = $request['restaurant_1_other'] != '' ? $request['restaurant_1_other'] : $request['restaurant_1'];
                //$requestData['restaurant_2'] = $request['restaurant_2_other'] != '' ? $request['restaurant_2_other'] : $request['restaurant_2'];
            } else if($request['scheduled'] == "YES") {
//                $requestData['company_representing'] = $request['company_representing'];
                $requestData['location'] = $request['room_name'];
            }
            
            $response[] = $requestData;
        }
        
        self::sendResponse(self::STATUS_SUCCESS, 'Requests found', $response);
    }
    
    public function roomsAvailabilityAction() {
        
//        echo '{"status":"success","message":"Success","data":[{"room_id":"1","room_name":"Room 1","is_available":"YES"},{"room_id":"2","room_name":"Room 2","is_available":"YES"},{"room_id":"3","room_name":"Room 3","is_available":"NO"},{"room_id":"4","room_name":"Room 4","is_available":"YES"},{"room_id":"5","room_name":"Room 5","is_available":"NO"},{"room_id":"6","room_name":"Room 6","is_available":"YES"},{"room_id":"7","room_name":"Room 7","is_available":"YES"},{"room_id":"8","room_name":"Incase","is_available":"NO"},{"room_id":"9","room_name":"Griffin\/Incase","is_available":"YES"}]}';
//        exit;
        
        $currentTime = Utility::getPSTCurrentTime()->format(APIModel::MYSQL_DATE_TIME_FORMAT);
        $response = $this->_model->roomsAvailability($currentTime);
        
        self::sendResponse(self::STATUS_SUCCESS, 'Success', $response);
    }
    
//    private function _validateInput($params, $requireFields) {
//        foreach ($requireFields as $field) {
//            if(!isset($params[$field]) || $params[$field] == '') {          
//                self::sendResponse(self::STATUS_FAIL, "'$field' parameter is required");
//            }
//        }
//    }
    
}
