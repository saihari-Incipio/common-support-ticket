<?php

Class LoginController extends ControllerBase {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {

        if (isset($_SESSION['ces_user_id']) && $_SESSION['ces_user_id'] != "") {
            header('Location:' . SITE_URL . 'backadmin/allschedules');
            exit;
        }

        if (isset($_POST['username']) && isset($_POST['username'])) {
            $user = new AdminUser();
            $userData = $user->authenticate($_POST['username'], $_POST['password']);
            if (empty($userData)) {
                $this->setResponseToSession(self::FAIL, 'Invalid username or password!'); 
                header('Location:' . SITE_URL . 'login/');
                exit;
            } else {
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['admin_type'] = $userData['type'];
                $_SESSION['admin_uname'] = $userData['uname'];
                $_SESSION['admin_display_name'] = $userData['name'];
//                $_SESSION['admin_last_reset_password_date'] = $userData['last_reset_password_date'];
//		$resetPwdDate = $_SESSION['admin_last_reset_password_date'];
	                 
		header('Location: ' . SITE_URL );
		     exit;

//                header('Location:' . SITE_URL . 'backadmin/allschedules');
                exit;
            }
        }

        $this->_view->render(false);
    }

    public function pagenotfoundAction() {
        echo '404 Error: Page not found';
        exit;
    }

}

?>