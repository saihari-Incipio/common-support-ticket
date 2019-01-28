<?php

class RequesterforgotpasswordController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->_model = new AdminUser();
    }

    public function indexAction() {
        if (isset($_REQUEST['username'])) {
            $adminUsers = $this->_model->getRequesterEmail();
            
            if (empty($adminUsers['email'])) {
                $this->setResponseToSession(self::FAIL, 'Email is not existing!');
                header('Location:' . SITE_URL.'/requesterforgotpassword');
                exit;
            } else {
                $secure_code = md5(rand(1000, 9999) . time());
                $this->_model->updateSecureCode($secure_code, $adminUsers['id']);
                $this->mailforgotpasswordAction($secure_code, $adminUsers['email'], $adminUsers['name']);
                
                $this->setResponseToSession(self::SUCCESS, 'Instructions on how to reset your password have been emailed to the address on file for this user. If you do not receive your email, please contact your site administrator for assistance.');
                header('Location:' . SITE_URL . '/front');
                exit;
            }
        }
        $this->_view->render(FALSE);
    }

//    
    public function mailforgotpasswordAction($secure_code, $existsEmail, $username) {
        
        $projectBody = 'Hi ' . ucfirst($username) . ', <br><br> Please <a target="_blank" href="' . SITE_URL . 'requesterforgotpassword/reset?scode=' . $secure_code . '">click here</a> to reset your password for ERP Service Ticket Portal.<br>';
        $projectBody .= '<table style=\"padding-left:5px; font-size: 13px; margin-top: 5px;\">';

//        $projectBody .= '<tr><td colspan="2">Thank you,<br/>Incipio Support.</td></tr>';

        $projectBody .= '</table>';
//        $emailTemplate = $this->getEmailTemplete(); // make email tamplete with body
//        $projectBody = str_replace('{{MSG_BODY}}', $projectBody, $emailTemplate);

        //send mail 
        $subject = 'ERP Service Ticket Portal: Password Reset';
        $toEmails = [$existsEmail => $username];
//        $fromMails = ['fromEmail' => 'noreply@incipio.com', 'fromName' => 'No Reply'];
//        App::pre($fromMails);
        return $this->sendMail($toEmails, $subject, $projectBody, [], [], []);
    }

    public function resetAction() {
        
        if(!isset($_REQUEST['scode']) || $_REQUEST['scode'] == '') {
            $this->setResponseToSession(self::FAIL, 'Your reset password URL has been expired!');
            header('Location:' . SITE_URL . 'front');
            exit;
        }
        
        $scode = $_REQUEST['scode'];
        
        $fg_password_date = $this->_model->getForgotPasswordRequestDate($scode);
        if ($fg_password_date) {
            $fg_psw_request_date = strtotime($fg_password_date['forget_password_request_date']);
        } else {
            $this->setResponseToSession(self::FAIL, 'Your reset password URL has been expired!');
            header('Location:' . SITE_URL . 'front');
            exit;
        }

        if ($fg_psw_request_date + (24 * 60 * 60) > time()) {
            if (isset($_REQUEST['newpassword'])) {
                if ($_REQUEST['newpassword'] == $_REQUEST['confirmnewpassword']) {
                    $this->_model->updatePassword($_REQUEST['newpassword'], $scode);
                    $this->setResponseToSession(self::SUCCESS, 'Your new password is saved successfully.');
                    header('Location:' . SITE_URL . 'front');
                    exit;
                } else {
                    $this->setResponseToSession(self::FAIL, 'New password and confirm password is not matching!');
                    header('Location:' . SITE_URL . 'requesterforgotpassword/reset?scode=' . $_REQUEST['scode']);
                    exit;
                }
            }
        } else {
            $this->setResponseToSession(self::FAIL, 'Your reset password URL has been expired!');
            header('Location:' . SITE_URL . 'front');
            exit;
        }
        $this->_view->render(FALSE);
    }

}