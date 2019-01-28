<?php

class CESModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getMeetingRequest() {

	if((isset($_REQUEST['date'])) && $_REQUEST['date'] == 'all'){
	    $conditionSql = '';
            $conditionData = [];
	} else {
	    $date = ((isset($_REQUEST['date'])) && $_REQUEST['date'] != '') ? date(self::MYSQL_DATE_FORMAT, strtotime($_REQUEST['date'])) : '2017-01-04';
	    
	    $conditionSql = ' AND date(start_datetime) = :start_datetime  ';
	    $conditionData[':start_datetime'] = $date;
	}
	
	$sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM ces_meeting_requests WHERE scheduled = "NO" AND request_type = "MEETING" '.$conditionSql.' ORDER BY id DESC '.self::getPageLimitQuery();

        $stmt = $this->conn->prepare($sql);
//        $stmt->execute([':start_datetime' => $date]);
	$stmt->execute($conditionData);
        
        $this->saveTotalRecordCount();
        return $stmt->fetchAll();
    }
    
    public function getAllMeetingRequests() {
        $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM ces_meeting_requests WHERE status = "L" ORDER BY id DESC '.self::getPageLimitQuery();
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $this->saveTotalRecordCount();
     
        return $stmt->fetchAll();
    }
    
    public function getMeetingRoomsJsonData() {
        
        $meetingRooms = $this->getRecords(['*'], 'ces_meeting_rooms', ['status' => 'L']);
        
        $roomsData = [];
        foreach($meetingRooms as $room) {
            $roomsData[] = array(
                'id'         => $room['id'],
                'title'      => $room['room_name'],
                'eventColor' => '#'.$room['status_color']
            );
        }
        
        return json_encode($roomsData);
    }
    
    public function getMeetingRoomByIdJsonData($roomId) {
                
        $meetingRoom = $this->getRecordById('ces_meeting_rooms', $roomId, ['*']);
        $roomsData = array(
            'id'         => $meetingRoom['id'],
            'title'      => $meetingRoom['room_name'],
            'eventColor' => '#'.$meetingRoom['status_color']
        );
        
        return json_encode([$roomsData]);
    }
    
    public function getEventsJsonData($type = "MEETING") {
        
        $conditions = ['status' => 'L', 'request_type' => $type];
        
        if($type === 'MEETING') {
            $conditions['scheduled'] = 'YES';
        }
        
        if(isset($_REQUEST['room_id']) && $_REQUEST['room_id'] != '') {
            $conditions['room_id'] = $_REQUEST['room_id'];
        }
        
        //App::pre($conditions);
        $events = $this->getRecords(['*'], 'ces_meeting_requests', $conditions);
        
        //App::pre($events);
        
        $eventsData = [];
        foreach($events as $event) {
            $eventsDetails = array(
                'id' => $event['id'],
                'resourceId' => $event['room_id'],
                'title' => $event['request_type'].' - '.$event['requester_name'],
                'start' => str_replace(' ', 'T', $event['start_datetime']),
                'end' => str_replace(' ', 'T', $event['end_datetime']),
            );
            
            // set background color for dinner
            if($event['request_type'] == 'DINNER') {
                $eventsDetails['backgroundColor'] = $event['dinner_status'] == 'REQUESTED' ? 'gray' : 'green';
            }
            
            $eventsData[] = $eventsDetails;
        }
        
        return json_encode($eventsData);
    }
    
    public function updateEvents($events) {
        $sql = 'UPDATE ces_meeting_requests SET scheduled="YES", start_datetime=:start_datetime, end_datetime=:end_datetime, room_id=:room_id WHERE id=:id';
        $stmt = $this->conn->prepare($sql);
        
        foreach($events as $event) {
        
            $sqlData = array(
                ':start_datetime' => date(self::MYSQL_DATE_TIME_FORMAT, strtotime($event['start_datetime'])),
                ':end_datetime' => date(self::MYSQL_DATE_TIME_FORMAT, strtotime($event['end_datetime'])),
                ':room_id' => $event['room_id'],
                ':id' => $event['event_id']
            );
            
            $stmt->execute($sqlData);
        }
        
        return true;
    }
    
    public function getEventsInfo($info) {
        
        $conditions = ['status' => 'L', 'id' => $info['event_id'] ];
//        
//        if(isset($_REQUEST['room_id']) && $_REQUEST['room_id'] != '') {
//            $conditions['room_id'] = $_REQUEST['room_id'];
//        }
//        
        $events = $this->getRecords(['*'], 'ces_meeting_requests', $conditions);
        
        $eventsData = 
            $eventsData[] = array(
                'id' => $info['event_id'],
                'resourceId' => $info['room_id'],
                'start' => str_replace(' ', 'T', $info['start_datetime']),
                'end' => str_replace(' ', 'T', $info['end_datetime']),
            );
//            App::pre($events); exit;
        return $events;
    }
    
    
    public function updateEventById($event) {
//        App::pre($event);
        //$sql = 'UPDATE ces_meeting_requests SET request_type=:request_type, restaurant_1=:restaurant_1, restaurant_2=:restaurant_2, number_of_people=:number_of_people, customers=:customers, comments=:comments WHERE id=:id';
        $sql = 'UPDATE ces_meeting_requests SET restaurant_1=:restaurant_1, restaurant_1_other=:restaurant_1_other, restaurant_2=:restaurant_2, restaurant_2_other=:restaurant_2_other, company_representing=:company_representing, number_of_people=:number_of_people, customers=:customers, comments=:comments, dinner_status=:dinner_status WHERE id=:id';
        $stmt = $this->conn->prepare($sql);
        
            $sqlData = array(
//                ':request_type' => $event['request_type'],
                ':restaurant_1' => $event['restaurant_name_1'],
                ':restaurant_1_other' => $event['restaurant_1_other'],
                ':restaurant_2' => $event['restaurant_name_2'],
                ':restaurant_2_other' => $event['restaurant_2_other'],
                ':company_representing' => $event['company_representing'],
                ':number_of_people' => $event['number_of_people'],
                ':customers' => $event['customers'],
                ':comments' => $event['comments'],
                ':dinner_status' => $event['dinner_status'],
                ':id' => $event['event_id'],
            );
            
            $stmt->execute($sqlData);
       
        return true;
    }
    
    public function deleteEventById($eventID) {
//        App::pre($eventID);
        $sql = 'UPDATE ces_meeting_requests SET status = "D" WHERE id=:id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':id' => $eventID['eventID']));
        return true;
    }
    
    public function getRequestsDataWithKey() {
        //$requests = $this->getRecords(['*'], 'ces_meeting_requests', ['status' => 'L']);
        
        $sql = 'SELECT cmr.*, cmroom.room_name FROM ces_meeting_requests cmr '
                . 'LEFT JOIN ces_meeting_rooms cmroom ON cmroom.id = cmr.room_id '
                . 'WHERE cmr.status = "L"';
        
        $requests = $this->conn->query($sql)->fetchAll();
        
        $requestData = [];
        foreach($requests as $request) {
            $requestData[$request['id']] = $request;
        }
        
        return $requestData;
    }
    
    public function getEventDetails($eventId) {
        //$eventInfo = $this->_model->getRecords(['*'], 'ces_meeting_requests', ['id' => $eventId]);
        $sql = 'SELECT cmr.*, cmroom.room_name FROM ces_meeting_requests cmr '
                . 'LEFT JOIN ces_meeting_rooms cmroom ON cmroom.id = cmr.room_id '
                . 'WHERE cmr.id = :id';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $eventId]);
        
        return $stmt->fetch();
    }
    
    public function getAllMeetingRooms() {
        //$eventInfo = $this->_model->getRecords(['*'], 'ces_meeting_requests', ['id' => $eventId]);
        $sql = 'SELECT * FROM ces_meeting_rooms WHERE status = "L"';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getAvailableRooms($fromDateTime, $toDateTime) {
        $sql = 'SELECT cmr.* FROM ces_meeting_rooms cmr WHERE cmr.id NOT IN ('
                . 'SELECT cmreq.room_id FROM ces_meeting_requests cmreq WHERE cmreq.scheduled = "YES" AND '
                . '(cmreq.start_datetime BETWEEN "'.$fromDateTime.'" AND "'.$toDateTime.'" || cmreq.end_datetime BETWEEN "'.$fromDateTime.'" AND "'.$toDateTime.'")'
                . ') AND cmr.status = "L"';
        
        //echo $sql;exit;
        
        return $this->conn->query($sql)->fetchAll();
    }
    
    public function checkEmailExists($params){

	$sql = 'SELECT email, secure_code, name FROM ces_meeting_admin_users WHERE uname = :uname';

	$stmt = $this->conn->prepare($sql);
	$stmt->execute([':uname' => $params['username']]);
	return $stmt->fetch();
    }
    
     public function updateSecureCode($scode, $email){
	$updateUser = 'update ces_meeting_admin_users set secure_code = :secure_code, forget_password_request_date = :forget_password_request_date where email = :email';
	$stmtUpdate = $this->conn->prepare($updateUser);
	$currentDateTime = Utility::getPSTCurrentTime()->format(self::MYSQL_DATE_TIME_FORMAT);
	$stmtUpdate->execute([':secure_code' => $scode, ':forget_password_request_date' => $currentDateTime, ':email' => $email]);

	return TRUE;
    }
    
    public function forgotPassword($params){
//	App::pre($params);
	$secure_code = $params['scode'];
	$newpass = md5($params['new_password']);
	
	$updateUser = 'update ces_meeting_admin_users set pwd = :pwd where secure_code = :secure_code';
	$stmtUpdate = $this->conn->prepare($updateUser);
	$stmtUpdate->execute([':pwd' => $newpass, ':secure_code' => $secure_code]);

	return TRUE;	
    }
    
    public function getForgotPasswordDate($scode){
	$sql = 'SELECT forget_password_request_date FROM ces_meeting_admin_users WHERE secure_code = :secure_code';

	$stmt = $this->conn->prepare($sql);
	$stmt->execute([':secure_code' => $scode]);
	return $stmt->fetch();
	
    }
    
    public function checkExistingPassword($param){
	$sql = 'SELECT pwd FROM ces_meeting_admin_users WHERE secure_code = :secure_code AND pwd=:pwd';

	$stmt = $this->conn->prepare($sql);
    $stmt->execute([':secure_code' => $param['scode'], 'pwd'=>md5($param['new_password'])]);
	return $stmt->fetch();
	
    }
    
     public function resetPassword($params){
//	App::pre($params);
	$userid = $_SESSION['ces_user_id'];
	$changepass = md5($params['change_password']);
	
	$updateUser = 'update ces_meeting_admin_users set pwd = :pwd, last_reset_password_date = :last_reset_password_date where id = :id';
	$stmtUpdate = $this->conn->prepare($updateUser);
	$currentDateTime = Utility::getPSTCurrentTime()->format(self::MYSQL_DATE_TIME_FORMAT);
	$stmtUpdate->execute([':pwd' => $changepass, 'last_reset_password_date' => $currentDateTime, ':id' => $userid]);

	return TRUE;	
    }
    
}
