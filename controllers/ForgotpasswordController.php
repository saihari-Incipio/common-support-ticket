<?php

class ForgotpasswordController extends ControllerBase {

    use UtilityHtml; // defined common html inside UtilityHtml class

//    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = new CESModel();
    }

    public function indexAction() {
	if(isset($_REQUEST['submit'])){
//	    App::pre($_REQUEST);
	    $adminUser = $this->_model->checkEmailExists($_REQUEST);
            $existsEmail = $adminUser['email'];
            $existsName = $adminUser['name'];
            //$secure_code = $adminUser['secure_code'];

	    if(!$existsEmail){
                $_SESSION['error'] = 'Invalid Username!';
		header('Location:'.SITE_URL.'forgotpassword');
                exit;
	    }
	    else{

		$secure_code = md5(rand(1000, 9999).time());

                $this->_model->updateSecureCode($secure_code, $existsEmail);
                $this->sendSecureCodeMail($secure_code, $existsEmail, $existsName);

            }
        }

        $this->_view->render(FALSE);
	
    }

    public function sendSecureCodeMail($secure_code, $existsEmail, $existsName){
        $projectBody = 'Hi '.$existsName .', <br><br>'
		.'Please click below button to change your password for ERP Service Ticket. <br><br>';
        $projectBody .= '<table style=\"padding-left:5px; font-size: 13px; margin-top: 5px;\">';

	$projectBody .= '<tr><td style="width:100px;"> </td> <td> <a style="background-color:#00aeef; border-radius:5px; color:#ffffff; font-size:12px; padding:10px 25px; text-decoration:none; font-weight:bold; text-transform:uppercase" target="_blank" href="'.SITE_URL.'forgotpassword/reset?scode='.$secure_code.'">CHANGE PASSWORD</a> </td></tr><tr></tr><tr><td>Thanks,<br/>ERP Service Ticket.</td></tr>';

        $projectBody .= '</table>';

//        $emailTemplate = $this->getEmailTemplete(); // make email tamplete with body
//        $projectBody = str_replace('{{MSG_BODY}}', $projectBody, $emailTemplate);


        //send mail 
        $subject = 'Forgot Password';
        $toEmails = [$existsEmail => $existsEmail];

        $this->sendMail($toEmails, $subject, $projectBody);
	
//	$_SESSION['message'] = '<span style="color:green">Reset password link has need sent to <span style="color:blue">' . $existsEmail . '</span>. Please check your email id.</span>';
	$this->setResponseToSession(self::SUCCESS, '<span>Instructions on how to reset your password have been emailed to the address on file for this user. If you do not receive your email, please contact your site administrator for assistance.<span>');
	    header('Location:'.SITE_URL.'backadmin');
	    exit;

    }

    public function resetAction(){

        $scode = $_REQUEST['scode'];
	
	$forgetPwdDate = $this->_model->getForgotPasswordDate($scode);	
	$existsforgetPwdDate = strtotime($forgetPwdDate['forget_password_request_date']);
//	App::pre($existsforgetPwdDate);
	if($existsforgetPwdDate + (24*60*60) > time() ) {

	    if(isset($_REQUEST['submit'])){
		if($_REQUEST['new_password'] == $_REQUEST['confirm_password']){
    //		App::pre($_REQUEST);
		    $this->_model->forgotPassword($_REQUEST); 
		    header('Location:'.SITE_URL.'login?status=1');
		}
		else{
		    $_SESSION['error'] = 'Incorrect New password and Confirm password!';
		    header('Location:'.SITE_URL.'forgotpassword/reset?scode='.$_REQUEST['scode']);
		    exit;
		}
	    }
	}
	else{
	    $_SESSION['error'] = 'Reset password link is expired!';
	    header('Location:'.SITE_URL.'backadmin');
	    exit;
	}
        $this->_view->render(FALSE);
	
    }

    
}

