<?php

class BackadminController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->loginCheck();
        $this->_model = new CESModel();
    }
    
    public function indexAction() {
	if(isset($_SESSION['password_expired']) && $_SESSION['password_expired'] == 'YES'){ 
	    $_SESSION['error'] = 'Your password is expired!';
	    header('Location: ' . SITE_URL . 'backadmin/resetpassword');
	    exit;
	} 
        $this->_view->addParam('list', true);
        $this->_view->addParam('requestFields', $this->_model->getAllMeetingRequests());
        $this->_view->render();
    }
    
   
    
    public function resetPasswordAction(){
//	App::pre($_REQUEST);
	if(isset($_REQUEST['submit'])){
	    $userid = $_SESSION['ces_user_id'];
	    $currentpass = md5($_REQUEST['current_password']);
	    $changepass = md5($_REQUEST['change_password']);
	    $confirmpass = md5($_REQUEST['confirm_password']);
	    
	    if($changepass != $confirmpass){
		$_SESSION['error'] = 'Incorrect New password and Confirm password!';
		header('Location:'.SITE_URL.'backadmin/resetpassword');
		exit;
	    }
	    
	    $adminUser = $this->_model->getRecordById('ces_meeting_admin_users', $userid, ['pwd']);
	    $existsPass = $adminUser['pwd'];
	    
	    if($existsPass != $currentpass){
		$_SESSION['error'] = 'Invalid Current Password!';
		header('Location:'.SITE_URL.'backadmin/resetpassword');
		exit;
	    }
	    $this->_model->resetPassword($_POST);    
	       
	    $this->setResponseToSession(self::SUCCESS, 'Password Changed successfully'); 
	    unset($_SESSION['password_expired']);	    
	}	
	$this->_view->render();
    } 
 
    public function refreshSessionAction() {
        
        // store session data
        if (isset($_SESSION['session_active_refresh'])) {
            $_SESSION['session_active_refresh'] = $_SESSION['session_active_refresh'];
        } else {
            $_SESSION['session_active_refresh'] = 1;
        }
        echo 'session refreshed';exit;
    }
}
