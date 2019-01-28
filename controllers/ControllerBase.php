<?php

abstract class ControllerBase {

    const SUCCESS = 'success';
    const FAIL = 'fail';

    protected $_view;

    public function __construct() {
        $this->_view = new View();
    }

    protected static function ajaxResponse($status, $message, $setInSession = false) {
        $responseData = array('status' => $status, 'text' => $message);
        if ($setInSession) {
            $_SESSION['message'] = $responseData;
        }
        return json_encode($responseData);
    }

    protected static function setResponseToSession($status, $message) {
//        $_SESSION['message'] = ['status' => $status, 'text' => $message];
         Session::set('message', ['status' => $status, 'text' => $message]);
    }

    protected static function loginCheck() {
        if (!isset($_SESSION['requester_id']) || $_SESSION['requester_id'] == "") {
            echo '<script>window.location = "' . SITE_URL . 'front/login";</script>';
            exit;
        }
    }

    public function logoutAction() {
        session_destroy();
        header('Location:' . SITE_URL . 'login');
        exit;
    }

        public function frontlogoutAction() {
        session_destroy();
        header('Location:' . SITE_URL . 'front/login');
        exit;
    }
    protected function sendMail(array $toEmails, $subject, $body, $additionalCCs = []) {
        $emailTemplate2 = $this->getEmailTemplete();
        $mailBody = str_replace('{{MSG_BODY}}', $body, $emailTemplate2);
        error_log("send mail fun : ". print_r($additionalCCs) );
        $mail = new PHPMailer();
        $mail->Subject = $subject;
        $mail->SetFrom(ADMIN_EMAIL_FROM_ID, ADMIN_EMAIL_FROM_NAME);
        $mail->MsgHTML($mailBody);

        foreach ($toEmails as $toEmail => $toEmailName) {
            $mail->AddAddress($toEmail, $toEmailName); //To address who will receive this email
        }

        if (!empty($additionalCCs)) {
            foreach ($additionalCCs as $cc) {
                $mail->AddCC($cc);
            }
        }
        
        $this->_model->saveEmailData($mail);
        if (ENV == 'LIVE') {
            $mail->Send();
            return true;
        }
//        if($mail->Send()) {
////            $this->_model->saveEmailData($mail);
//            return true;
//        }
        
        return false;
    }

    protected function getEmailTemplete() {
       return '<div style="background-color: #eaeaea; padding: 20px; font-family: Arial, Helvetica, sans-serif">
            <div style="background-color: #ffffff; margin: 10px auto; padding: 4px 32px 26px;">
                <div style="margin-top: 20px; font-size: 15px;">{{MSG_BODY}}
        <div style="margin-top: 20px; font-size: 15px;"><br/>Thank you,<br/><br/>
        ERP Service Ticket Admin<br/><br/>
        For problems or issues related to this notification, 
        please contact the system administrator at <mailto: incipiodev@incipio.com>incipiodev@incipio.com<br/></div>
        </div>
            </div>   
        </div>';
    }
    
    protected function uploadAttachedFiles() {
        $itemFiles = array();
        
        if (isset($_FILES['projectfiles']['name'])) {
            $uploadedItemIndexes = array_keys($_FILES['projectfiles']['name']);
            foreach($uploadedItemIndexes as $index) {
                
                $filesUploaded = array();
                
                $totalFiles = count($_FILES['projectfiles']['name'][$index]);
                for ($i = 0; $i < $totalFiles; $i++) {
                    if ($_FILES['projectfiles']['error'][$index][$i] == 0) {

                        // generate unique file name
                        $filename = time() . '-' . rand(100, 999) . '-' . $_FILES['projectfiles']['name'][$index][$i];

                        // create destination path
                        $destination = FILE_UPLOAD_PATH . '/' . $filename;

                        // save file to server
                        move_uploaded_file($_FILES['projectfiles']['tmp_name'][$index][$i], $destination);

                        $filesUploaded[] = $filename;
                    }
                }
                
                $itemFiles[$index] = implode(':', $filesUploaded);
            }
        }

        //App::pre($itemFiles);
        return $itemFiles;
    }
    
    public function validateRequestParameters($filters, $params = null) {
        
        if($params === null) { $params = $_REQUEST; }
        
        $errors = [];
        foreach($filters as $fieldName => $filter) {
            $fieldLabel = ucfirst(str_replace('_', ' ', $fieldName));
            
            // check whether parameter is set
            if(empty($filter['not-required']) && (!isset($params[$fieldName]) || $params[$fieldName] == "")) {
                $errors[] = '"'.$fieldLabel.'" is required.';
                break;
            } else if(!empty($params[$fieldName])) {
                $validate = false;
                switch($filter['type']) {
                    case 'text' : $validate = true; break; // nothing to check
                    case 'date' : 
                        $validate = (strtotime($params[$fieldName]) !== false); 
                        break;
                    case 'options' : 
                        $validate = (isset($filter['options']) && is_array($filter['options']) && in_array($params[$fieldName], $filter['options']));
                        break;
                }
                
                if(!$validate) {
                    $errors[] = 'Invalid value for "'.$fieldLabel.'".';
                    break;
                }
            }
        }
        
        if(!empty($errors)) {
            
            // this should be fix as javascript level validation
            error_log(PHP_EOL."== Server side validation errors ==".PHP_EOL
                    . print_r($errors, true)
                    .'Request Details: '.PHP_EOL.print_r($_REQUEST, true)
                    . '===================================================='
            );
            
            $errorMessage = implode('<br/>', $errors);
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // set as json response if request is came from ajax
                echo $this->ajaxResponse(self::FAIL, $errorMessage); exit;
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_REFERER'])) {
                    // redirect to current page
                    $this->setResponseToSession(self::FAIL, $errorMessage);
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                    exit;
                } else {
                    $this->redirectTo404();
                }
            }
        }
    }
    
    public function erpWebHookAction(){
          error_log("wprWebHook Content :  " . file_get_contents('php://input'));
        $data = json_decode(trim(file_get_contents('php://input')), true);
        error_log("wprWebHook Data:  " . print_r($data));
//        print_r();
        if (isset($data) && !empty($data)) {
            $issuedata = $data['issue'];
            $toEmails = array();
            $additionalCCs = array();
            $comment = '';
            // Getting the Issue Data fromth Curl
            $username = base64_decode(JIRA_USER_NAME);
            $password = base64_decode(JIRA_USER_PWD);
            $url = 'https://incipiogroup.atlassian.net/rest/api/latest/issue/'.$issuedata['key'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $result = curl_exec($ch);
            $ch_error = curl_error($ch);
            curl_close($ch);
            $completeIssueData = json_decode(trim($result), true);
            error_log("Complete Data : ".$completeIssueData['fields']['assignee']['emailAddress']);
            
            $requesterName = $completeIssueData['fields']['customfield_11310'];   // Requester Name
            $requesterEmail = $completeIssueData['fields']['customfield_11312'];   // Requester Email        
            $assigneeName = $completeIssueData['fields']['assignee']['name'];   //  Assignee Name 
            $assigneeEmail = $completeIssueData['fields']['assignee']['emailAddress'];   //  Assignee Email
            
//            if(isset($completeIssueData['fields']['customfield_11021']) && $completeIssueData['fields']['customfield_11021'] != ''){
//                $addReqEmails = explode(',', $completeIssueData['fields']['customfield_11021']);
//                foreach ($addReqEmails as $email){
//                   $additionalCCs[] =  $email;
//                }  
//            }
//            
            if($data['webhookEvent'] == 'jira:issue_created'){
                $subject = "New Service Request ". $issuedata['key'] ." has been created . ";
            }else if ($data['webhookEvent'] == 'jira:issue_updated'){
                $subject = "update on Issue ". $issuedata['key'] ;
            }else if($data['webhookEvent'] == 'comment_created'){
                $subject = "New Comment on Issue ". $issuedata['key'];
               
            }else if($data['webhookEvent'] == 'comment_updated'){
                $subject = "Comment Edited on Issue ". $issuedata['key'];
            }else{
               $subject = $issuedata['key'] . " " . $data['webhookEvent'];
            }
            
                $toEmails[$requesterName] = $requesterEmail;  
                $additionalCCs[] = $completeIssueData['fields']['assignee']['emailAddress'];
//            $subject = $issuedata['key'] . " " . $data['webhookEvent'];
            $summary = $completeIssueData['fields']['summary'];
            $status = $completeIssueData['fields']['status']['statusCategory']['name'];
            $priority = $completeIssueData['fields']['priority']['name'];
            $taskDesc = $completeIssueData['fields']['description'];
            if(isset($data['comment']['body']) && $data['comment']['body'] !='') {
            $comment = $data['comment']['body']; 
            }
            $body = "Hi,<br/> 
            <p>The issue " . $completeIssueData['key'] . " is: " . $data['webhookEvent'] . " </p>";
            $rowStyle = 'style="background-color: #fff;"';
            $colStyleHead = 'style="vertical-align: top; padding: 5px; font-weight: bold"';
            $colStyleValue = 'style="vertical-align: top; padding: 5px;"';
            $body .= '<table style="margin-left:10px; margin-top: 10px; font-size: 14px; background-color: #ddd;">
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Title: </td><td ' . $colStyleValue . '>' . $summary . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Description: </td><td ' . $colStyleValue . '>'.$taskDesc .'</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Type: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['issuetype']['name'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '> Platform: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11304']['value'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '> Track: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11305']['value'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Sub Track: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11306']['value'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '> Instance: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11307']['value'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '> Phase: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11308']['value'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '> Service Type: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11309']['value'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Requester Name: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11312'] . ' </td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Requester Department: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11311'] . ' </td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Requester Email: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['customfield_11310'] . ' </td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '> Status: </td><td ' . $colStyleValue . '>' . $status . '</td></tr>';
            if($comment != ''){
             $body .= '<tr ' . $rowStyle . '><td ' . $colStyleHead . '>Comment: </td><td ' . $colStyleValue . '>'.$comment .'</td></tr>';
            }
            $body .= '</table>';

//            App::pre($body);
            if (empty($toEmails)) {
                $toEmails['akhil@incipio.com'] = 'Akhil';
            }
            
            $this->sendMail($toEmails, $subject, $body, $additionalCCs);
        }
        exit;
//        $this->_view->render(false);
    }
    
    public function getTicketsByRequester(){
//        App::pre($_SESSION);
        $username = base64_decode(JIRA_USER_NAME);
            $password = base64_decode(JIRA_USER_PWD);
            $url = 'https://incipiogroup.atlassian.net/rest/api/latest/search?jql=project='.JIRA_PROJ_KEY.'+AND+cf[11310]~"'.$_SESSION['requester_email'].'"&maxResults='.RECORDS_PER_PAGE.'&startAt='.$_SESSION['startAt'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $result = curl_exec($ch);
            $ch_error = curl_error($ch);
            curl_close($ch);
            $completeIssueData = json_decode(trim($result), true);
            return $completeIssueData;            
        
    }
    
      function downloadattachmentsAction() {
//          App::pre($_REQUEST);
        if (!isset($_REQUEST['file']) || $_REQUEST['file'] == "") {
            header('Location: ' . SITE_URL . 'front');
            exit;
        }
        $username = base64_decode(JIRA_USER_NAME);
        $password = base64_decode(JIRA_USER_PWD);
        $url = base64_decode($_REQUEST['file']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);     
        $result = curl_exec($ch);
        $ch_error = curl_error($ch);
        curl_close($ch);
        
        if($result){
             header('Content-Description: File Transfer');
             header('Content-Type: application/octet-stream');
             header('Content-Disposition: attachment; filename='. basename(base64_decode($_REQUEST['file'])));
             header('Expires: 0');
             header('Cache-Control: must-revalidate');
             header('Pragma: public');
             ob_clean();
             echo ($result);
             exit;
        }

    }
    
    public function getTicketDetailsEmailTemplate($completeIssueData, $webHookData) {
//        error_log("JIra update status :" .$webHookData);
//        // Getting the Issue Data fromth Curl
//        $username = base64_decode(JIRA_USER_NAME);
//        $password = base64_decode(JIRA_USER_PWD);
//        $url = API_BASE_URL . 'issue/WPR-1036?expand=changelog';
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//
//        $result = curl_exec($ch);
//        $ch_error = curl_error($ch);
//        curl_close($ch);
//        $completeIssueData = json_decode(trim($result), true);
//        App::pre($completeIssueData);

        $requesterName = $completeIssueData['fields']['customfield_11020'];   // Requester Name
        $requesterEmail = $completeIssueData['fields']['customfield_11018'];   // Requester Email        
        $assigneeName = $completeIssueData['fields']['assignee']['name'];   //  Assignee Name 
        $assigneeEmail = $completeIssueData['fields']['assignee']['emailAddress'];   //  Assignee Email
//        $ActivityLog = $completeIssueData['changelog']['histories'][0]['items'];
//        $logFiledArr = Utility::arrayColumnFind($ActivityLog, 'field');
//        $key = array_search('status', $logFiledArr);
        $summary = $completeIssueData['fields']['summary'];
        if($webHookData == 'jira:issue_created'){
            $status = $completeIssueData['fields']['status']['name'];
        
        }else{
            $status = $completeIssueData['fields']['status']['name'];
        }
        $priority = $completeIssueData['fields']['priority']['name'];
        $taskDesc = $completeIssueData['fields']['description'];
        $attachments = $completeIssueData['fields']['attachment'];
        if($completeIssueData['fields']['customfield_11021'] != ''){ 
            $addReqEmails = explode(',', $completeIssueData['fields']['customfield_11021']);
            $AdditionalCCs = '';
                foreach ($addReqEmails as $email) {
                   $AdditionalCCs .= $this->getActiveEmailLink($email);                    
                }
//            $AdditionalCCs = $completeIssueData['fields']['customfield_11021'];
        }else{
            $AdditionalCCs = 'NA'; 
                
        } 

        $rowStyle = 'style="background-color: #fff;"';
        $colStyleHead = 'style="vertical-align: top; padding: 5px; font-weight: bold"';
        $colStyleValue = 'style="vertical-align: top; padding: 5px;"';
        $body = '<table style="margin-left:10px; margin-top: 10px; font-size: 14px; background-color: #ddd;">
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Subject: </td><td ' . $colStyleValue . '>' . $summary . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Service Type: </td><td ' . $colStyleValue . '> ' . $completeIssueData['fields']['issuetype']['name'] . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Severity: </td><td ' . $colStyleValue . '> ' . $priority . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Description: </td><td ' . $colStyleValue . '>' . htmlspecialchars_decode(nl2br($taskDesc)) . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Status: </td><td ' . $colStyleValue . '>' . $status . '</td></tr>';
        
        if(isset($completeIssueData['fields']['resolution']['name']) && $completeIssueData['fields']['resolution']['name'] !=''){
        $resolution = $completeIssueData['fields']['resolution']['name'];
            
        }else{
            $resolution = 'NA';
        }
            $body.='<tr ' . $rowStyle . '><td ' . $colStyleHead . '>Resolution: </td><td ' . $colStyleValue . '>' . $resolution . '</td></tr>';
            $body.='<tr ' . $rowStyle . '><td ' . $colStyleHead . '>Requester Name: </td><td ' . $colStyleValue . '>' . $requesterName . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Requester Email: </td><td ' . $colStyleValue . '>' . $this->getActiveEmailLink($requesterEmail) . '</td></tr>
                    <tr ' . $rowStyle . '><td ' . $colStyleHead . '>Additional CC\'s: </td><td ' . $colStyleValue . '> ' . $AdditionalCCs. ' </td></tr>';
        
        if ( $webHookData == 'jira:issue_created' && !empty($attachments)) {
            $downloadLinks = '';
            foreach ($attachments as $index => $attachment) {
                $attachement = $attachment['content'];
                $fileExp = explode('.', basename($attachement));
                $fileNameTrim = substr($fileExp[0], 0, 10).'...'.substr($fileExp[0], -10).'.'.$fileExp[1];
                $downloadLinks .= '<div><a style="color:#000;" target="_blank" href="'.SITE_URL.'support/index/downloadJiraAttachments?file='. base64_encode($attachement) .'" title="' .basename($attachement). '" >'.$fileNameTrim.'</a></div>';
            }
            $body .= '<tr ' . $rowStyle . '><td ' . $colStyleHead . '>Attachments: </td><td ' . $colStyleValue . '>' . $downloadLinks . '</td></tr>';
        }
        $body .= '</table>';

        $body .= '<br/><p>Should you have any questions or issues with accessing the support page, please contact your System Administrator as '.$this->getActiveEmailLink('incipiodev@incipio.com').'. </p>';

        $body .= '<p>Thank you,<br />Incipio Development <br />  '. $this->getActiveEmailLink('incipiodev@incipio.com').'</p>';
//        print_r($body);
        return $body;
    }
    
    private function getActiveEmailLink($emailId)
    {
        return "&lt;<a href=\"mailto:$emailId\" >$emailId</a>&gt;";
    }
}
