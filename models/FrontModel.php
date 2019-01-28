<?php

class FrontModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getTracksList(){
        
        $sql = 'SELECT * FROM erp_service_tracks where status ="L" ORDER BY track_name ASC';
         $stmt = $this->conn->prepare($sql);
         $stmt->execute();
         return $stmt->fetchAll();
    }
    
    public function getSubTracksList($trackId){
        
        $sql = 'SELECT * FROM erp_service_subtracks where track_id=:track_id AND status ="L" ORDER BY sub_track_name ASC';
         $stmt = $this->conn->prepare($sql);
         $stmt->execute(array(':track_id'=> $trackId));
         return $stmt->fetchAll();
    }
       
   public function getSubTrackByIdData($subTrackId){
        
        $sql = 'SELECT ess.*, et.track_name, esu.uname AS assignee_uname, esu.name AS assignee_name, esu.email AS assignee_email  FROM erp_service_subtracks ess '
                . 'LEFT JOIN erp_service_users esu ON esu.id = ess.business_sme_id '
                . ' LEFT JOIN erp_service_tracks et ON et.id = ess.track_id where ess.id=:sub_track_id AND et.status ="L" ORDER BY et.track_name ASC';
         $stmt = $this->conn->prepare($sql);
         $stmt->execute([':sub_track_id' => $subTrackId]);
         return $stmt->fetch();
    }

    public function addMeeting($params) {

        $sql = 'INSERT INTO ces_meeting_requests (requester_name, requester_email_id, requester_phone_number, request_type, restaurant_1, restaurant_1_other, restaurant_2, restaurant_2_other, company_representing, number_of_people, scheduled, customers, comments, meeting_title, start_datetime, end_datetime, room_id, c_date, status) '
                . 'VALUES (:requester_name, :requester_email_id, :requester_phone_number, :request_type, :restaurant_1, :restaurant_1_other, :restaurant_2, :restaurant_2_other, :company_representing, :number_of_people, :scheduled, :customers, :comments, :meeting_title, :start_datetime, :end_datetime, :room_id, :c_date, "L")';

        $stmt = $this->conn->prepare($sql);
        
        $datetTimeOfMeeting = date(self::MYSQL_DATE_TIME_FORMAT, strtotime($params['date_of_meeting']));

        $sqlData = array(
            ':requester_name'         => htmlspecialchars($params['requester_name']),
            ':requester_email_id'     => htmlspecialchars($params['requester_email_id']),
            ':requester_phone_number' => htmlspecialchars($params['requester_phone_number']),
            ':request_type'           => htmlspecialchars($params['request_type']),
            ':restaurant_1'           => isset($params['restaurant_name_1']) ? htmlspecialchars($params['restaurant_name_1']) : '',
            ':restaurant_1_other'     => isset($params['restaurant_1_other']) ? htmlspecialchars($params['restaurant_1_other']) : '',
            ':restaurant_2'           => isset($params['restaurant_name_2']) ? htmlspecialchars($params['restaurant_name_2']) : '',
            ':restaurant_2_other'     => isset($params['restaurant_2_other']) ? htmlspecialchars($params['restaurant_2_other']) : '',
            ':company_representing'   => isset($params['company_representing']) ? htmlspecialchars($params['company_representing']) : '',
            ':number_of_people'       => htmlspecialchars($params['number_of_people']),
            ':customers'              => htmlspecialchars($params['customers']),
            ':scheduled'              => isset($params['meeting_room']) ? 'YES' : 'NO',
            ':comments'               => htmlspecialchars($params['comments']),
            ':meeting_title'          => htmlspecialchars($params['requester_name']), // for now added requester name
            ':start_datetime'         => $datetTimeOfMeeting,
            ':end_datetime'           => date(self::MYSQL_DATE_TIME_FORMAT, strtotime($datetTimeOfMeeting) + 3600),
            ':room_id'                => isset($params['meeting_room']) ? $params['meeting_room'] : '0' ,
            ':c_date'                 => Utility::getPSTCurrentTime()->format(self::MYSQL_DATE_TIME_FORMAT)  
        );
        
        if ($stmt->execute($sqlData)) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    public function updateMeeting($params, $requestId) {

        $sql = 'UPDATE ces_meeting_requests SET '
                . 'requester_name         = :requester_name, '
                . 'requester_email_id     = :requester_email_id, '
                . 'requester_phone_number = :requester_phone_number, '
                . 'date_of_meeting        = :date_of_meeting, '
                . 'time_of_meeting        = :time_of_meeting, '
                . 'number_of_people       = :number_of_people, '
                . 'customers              = :customers, '
                . 'comments               = :comments, '
                . 'm_date                 = :m_date, '
                . 'm_by                   = :m_by '
                . 'WHERE id=:id';
        
        $stmt = $this->conn->prepare($sql);

        $sqlData = array(
            ':requester_name'         => htmlspecialchars($params['requester_name']),
            ':requester_email_id'     => htmlspecialchars($params['requester_email_id']),
            ':requester_phone_number' => htmlspecialchars($params['requester_phone_number']),
            ':date_of_meeting'        => date(self::MYSQL_DATE_FORMAT, strtotime($params['date_of_meeting'])),
            ':time_of_meeting'        => '',
            ':number_of_people'       => htmlspecialchars($params['requester_phone_number']),
            ':customers'              => htmlspecialchars($params['customers']),
            ':comments'               => htmlspecialchars($params['comments']),
            ':m_date'                 => Utility::getPSTCurrentTime()->format(self::MYSQL_DATE_TIME_FORMAT),
            ':m_by'                   => $_SESSION['ces_user_id'],
            ':id'                     => $requestId
        );
        
        if ($stmt->execute($sqlData)) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    public function getEmailRecords() {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM erp_service_emails ORDER BY id DESC " . self::getPageLimitQuery();
        $stmt = $this->conn->query($sql);

        $this->saveTotalRecordCount();
        return $stmt->fetchAll();
    }
    
}
