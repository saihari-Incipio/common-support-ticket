<?php

class APIModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRequests($emailId) {
        
        $sql = 'SELECT cmr.*, cmroom.short_room_name AS room_name FROM ces_meeting_requests cmr '
                . 'LEFT JOIN ces_meeting_rooms cmroom ON cmroom.id = cmr.room_id '
                . 'WHERE cmr.requester_email_id = :requester_email_id '
                    . 'AND (cmr.dinner_status = "CONFIRMED" || cmr.scheduled = "YES") '
                    . 'AND cmr.status = "L" '
                . 'ORDER BY cmr.c_date DESC';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':requester_email_id' => $emailId]);
        return $stmt->fetchAll();
    }
    
    public function roomsAvailability($currentTime) {
        $sql = 'SELECT cm_rooms.id AS room_id, cm_rooms.short_room_name AS room_name, '
                . 'IF(count(cmr.id) != 0, "NO", "YES") AS is_available '
                . 'FROM ces_meeting_rooms cm_rooms '
                . 'LEFT JOIN ces_meeting_requests cmr On cm_rooms.id = cmr.room_id '
                    . 'AND (cmr.start_datetime <= :currentTime AND cmr.end_datetime > :currentTime) '
                    . 'AND cmr.request_type = "MEETING" AND cmr.scheduled = "YES" AND cmr.status = "L" '
                . 'WHERE cm_rooms.status = "L" '
                . 'GROUP BY cm_rooms.id';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':currentTime' => $currentTime]);
        return $stmt->fetchAll();
    }
    
    public function getRoomsList() {
        
        $sql = 'SELECT id as room_id, room_name FROM ces_meeting_rooms WHERE status = "L"';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getMeetingRoomsByID($room_id) {
        
        $sql = 'SELECT request_type, start_datetime, end_datetime, number_of_people, customers, comments FROM ces_meeting_requests WHERE room_id = :room_id AND scheduled = "YES" AND request_type = "MEETING" AND status = "L" AND date(start_datetime) =:start_datetime';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':room_id' => $room_id, ':start_datetime' => Utility::getPSTCurrentTime()->format(self::MYSQL_DATE_FORMAT)]);
        return $stmt->fetchAll();
    }
    
}
