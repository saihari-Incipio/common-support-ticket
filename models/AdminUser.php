<?php

class AdminUser extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Authenticate user
     * @param string $userName username for login
     * @param string $password password for login
     * @return array user details | empty array
     */
    public function authenticate($userName, $password) {

        $sql = 'SELECT id, uname, type, name, last_reset_password_date FROM ces_meeting_admin_users WHERE uname=:username AND pwd=:password AND status="active"';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':username' => $userName, ':password' => md5($password)));
        return $stmt->fetch();
    }

    public function frontloginAuthenticate($userName, $password) {
        $sql = 'SELECT reqst.id, CONCAT(reqst.first_name, " ", reqst.last_name) AS name, reqst.email, dept.d_name AS depart_name, dept.id AS depart_id '
                . ' FROM common_project_requesters reqst '
                . ' LEFT JOIN common_project_departments dept ON ( dept.id = reqst.department_id) '
                . ' WHERE reqst.email=:username AND reqst.password=:password AND reqst.status="L"';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':username' => $userName, ':password' => md5($password)));
        return $stmt->fetch();
    }


    public function getRequesterEmail() {

        $sql = 'SELECT id, CONCAT(first_name, " ", last_name) AS name, email FROM common_project_requesters WHERE email=:email';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':email' => $_POST['username']));

        return $stmt->fetch();
    }
        public function updateSecureCode($secure_code, $existsUserID) {

        $sql = 'UPDATE common_project_requesters SET secure_code=:secure_code, forget_password_request_date=:forget_password_request_date WHERE id=:id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':secure_code' => $secure_code, 'forget_password_request_date' => CURRENT_DATE, ':id' => $existsUserID));

        return true;
    }
    
        public function getForgotPasswordRequestDate($secure_code) {
//        \App::pre($_SESSION);
        $sql = 'SELECT forget_password_request_date FROM common_project_requesters WHERE secure_code=:secure_code AND secure_code != ""';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':secure_code' => $secure_code));

        return $stmt->fetch();
//        \App::pre($_REQUEST);
    }

    public function updatePassword($newpassword, $scode) {
        $sql = 'UPDATE common_project_requesters SET password=:pwd, last_reset_password_date=:last_reset_password_date, secure_code = NULL WHERE secure_code=:secure_code';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':pwd' => md5($newpassword), ':last_reset_password_date' => CURRENT_DATE, ':secure_code' => $scode));

        return true;
    }
    
    public function getProjectsDetails($projectCode){
        $sql = 'SELECT * FROM support_tickets_projects_settings WHERE project_jira_code=:project_jira_code AND project_jira_code != ""';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(':project_jira_code' => $projectCode));

        return $stmt->fetch();
    }
}
?>
