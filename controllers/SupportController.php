<?php

define('DEFAULT_REDIRECT_URL', 'https://projects.incipio.com');

class SupportController extends ControllerBase {

    public function __construct() {

        parent::__construct();
        $this->_model = new AdminUser();

        if (isset($_REQUEST['proj_jira_code']) && $_REQUEST['proj_jira_code'] != '') {
            $projJiraData = $this->_model->getProjectsDetails($_REQUEST['proj_jira_code']);
            if (empty($projJiraData)) {
                header('Location:' . DEFAULT_REDIRECT_URL);
                exit;
            }
            if (ENV == 'LIVE') {
                $projFolder = $projJiraData['live_project_folder'];
            } else {
                $projFolder = $projJiraData['dev_project_folder'];
            }
            $projectPath = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $projFolder . '/';
            define('PROJECT_NAME', $projFolder);
        } else {
            header('Location:' . DEFAULT_REDIRECT_URL);
            exit;
        }

//        App::pre($_SESSION);

        if (isset($_SESSION['common_requester_id']) && $_SESSION['common_requester_id'] != '') {
//            echo 456; exit;

        } else if (isset ($_SESSION['support_access']) && $_SESSION['support_access'] == 'TRUE') {
                        if ($_REQUEST['r'] == 'support/supportticketview' && isset($_REQUEST['key']) && $_REQUEST['key'] != '' && isset($_REQUEST['proj_jira_code']) && $_REQUEST['proj_jira_code'] != '') {
                Session::remove('redirectUrl');

                Session::set('redirectUrl', SITE_URL . $_REQUEST['r'] . '?key=' . $_REQUEST['key'] . '&proj_jira_code=' . $_REQUEST['proj_jira_code']);
//                App::pre($_SESSION);
                header('Location:' . $projectPath . 'front/login');
                exit;
            } else if ($_REQUEST['r'] == 'support/support') {
//                    Session::remove('redirectUrl');
            } else {
                Session::remove('redirectUrl');
            }
        } else {
                if ($_REQUEST['r'] == 'support/supportticketview' && isset($_REQUEST['key']) && $_REQUEST['key'] != '') {
                    Session::remove('redirectUrl');
                    Session::set('redirectUrl', SITE_URL . $_REQUEST['r'] . '?key=' . $_REQUEST['key'] . '&proj_jira_code=' . $_REQUEST['proj_jira_code']);
                    header('Location:' . $projectPath . 'front/login');
                } else if ($_REQUEST['r'] == 'support/support') {
//                    Session::remove('redirectUrl');
                } else {
                    Session::remove('redirectUrl');
                }

        }
    }

    public function indexAction() {
        header('Location:' . DEFAULT_REDIRECT_URL);
        exit;
    }

    public function supportAction() {
//        \App::pre($_SESSION);

        if (isset($_SESSION['common_requester_id']) && $_SESSION['common_requester_id'] != '') {

            $support_requester_name = $_SESSION['common_requester_display_name'];
            $support_requester_email = $_SESSION['common_requester_email'];
        } else {
            $support_requester_name = '';
            $support_requester_email = '';
        }
        $this->_view->addParam('support_requester_name', $support_requester_name);
        $this->_view->addParam('support_requester_email', $support_requester_email);
        $this->_view->addParam('jqueryValidation', $this->getJqueryValidation());
        $this->_view->addParam('dashboard_type', $_REQUEST['dashboard_type']);
        $this->_view->render(false);
    }

    public function supportSubmitAction() {
//        App::pre($_REQUEST);
        if (isset($_REQUEST['proj_jira_code']) && $_REQUEST['proj_jira_code'] != '') {
            $projJiraData = $this->_model->getProjectsDetails($_REQUEST['proj_jira_code']);

//        App::pre($projJiraData);
            if (isset($_REQUEST['title']) && !empty($projJiraData)) {
                if (ENV == 'LIVE') {
                    $projFolder = $projJiraData['live_project_folder'];
                } else {
                    $projFolder = $projJiraData['dev_project_folder'];
                }
                $projectPath = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $projFolder . '/';
                if ($_REQUEST['dashboard_type'] == 'Requester-Dashboard') {
                    $redirectUrl = $projectPath . 'front/dashboard';
                } else if ($_REQUEST['dashboard_type'] == 'Requester-Form') {
                    $redirectUrl = $projectPath . 'front';
                } else if ($_REQUEST['dashboard_type'] == 'Requester-Login') {
                    $redirectUrl = $projectPath . 'front';
                } else {
                    $redirectUrl = $projectPath . 'backadmin';
                }
                $title = $_REQUEST['title'];
                $url = $projJiraData['jira_api_url'] . "issue/";

                $username = base64_decode(JIRA_USER_NAME);
                $password = base64_decode(JIRA_USER_PWD);
                if ($_REQUEST['service_type'] == "Support Bug") {
//                $assigneename = "qm:1bf2940d-7799-40f7-a12d-8cc429580483:5bb242b3f3eb3806414d0caa";     // swetha JIRA Id
                    $sprintId = $projJiraData['support_sprint_id'];     // Support Bug Sprint Id : 98
                    $assigneename = $projJiraData['support_assignee'];
                } else {
                    $sprintId = $projJiraData['kevin_sprint_id'];     // Kevin's Backlog Sprint Id : 99
                    $assigneename = $projJiraData['kevin_assignee'];
                }
                $dataArray = array();
                $dataArray['fields']['project']['key'] = $_REQUEST['proj_jira_code'];
                $dataArray['fields']['summary'] = $_REQUEST['title'];
                $dataArray['fields']['description'] = trim($_REQUEST['description']);
                $dataArray['fields']['issuetype']['name'] = $_REQUEST['service_type'];
                $dataArray['fields']['customfield_11018'] = $_REQUEST['email'];
                $dataArray['fields']['assignee']['name'] = $assigneename;
                $dataArray['fields']['customfield_11020'] = $_REQUEST['requester_name'];
                $dataArray['fields']['customfield_11021'] = $_REQUEST['additional-cc'];
                $dataArray['fields']['customfield_11022'] = $_REQUEST['dashboard_type'];
                $dataArray['fields']['priority']['name'] = $_REQUEST['priority'];
                $dataArray['fields']['customfield_10024'] = (int) $sprintId;

                $txt = json_encode($dataArray, true);
//            error_log($txt);

                $headers = array();
                $headers[] = "Content-Type: application/json; charset=utf-8";

//            $reqData  = APIHelper::sendPostRequest( $url, $dataArray);
//            \App::pre($txt);

                $ch = curl_init();
//      $base64_usrpwd = base64_encode($username.':'.$password);
                // Set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $txt);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                // Grab URL and pass it to the browser
                $result = curl_exec($ch);
                $ch_error = curl_error($ch);
                curl_close($ch);
                error_log($result);
                if ($ch_error) {
                    error_log($ch_error);
                    exit;
//                echo "cURL Error: $ch_error";
                    $this->setResponseToSession(self::FAIL, 'Ticket generation failed. Please try Again');
                    header('Location:' . $redirectUrl);
                    exit;
                } else {
                    $data = json_decode(trim($result), true);
                    $issuenumber = $data['key'];
                    $issueid = $data['id'];
                    $no_files = count($_FILES["projectfiles"]['name']);

                    if ($no_files > 0 && $issuenumber != '') {
                        for ($i = 0; $i < $no_files; $i++) {
                            if ($_FILES["projectfiles"]["error"][$i] == 0) {
                                // Add atatchments

                                $attachmentsurl = API_BASE_URL . "issue/" . $issuenumber . "/attachments";

                                $ch2 = curl_init();
                                $file_name = Utility::getValidUploadedFileName($_FILES['projectfiles']['name'][$i]);
//                            $file_name = time() . '-' . basename($_FILES['projectfiles']['name'][$i]); //creating file name
                                $path = DOC_ROOT_PATH . '/tmp/' . $file_name; //creating temp path
                                file_put_contents($path, file_get_contents($_FILES['projectfiles']['tmp_name'][$i]));
                                $filename = $_FILES['projectfiles']['name'][$i];
                                $filedata = $_FILES['projectfiles']['tmp_name'][$i];
                                $filesize = $_FILES['projectfiles']['size'][$i];

//                            error_log("real path attachment" . realpath($_FILES['projectfiles']['name'][$i]));
//                            error_log($attachmentsurl);
                                $data = array("file" => "@$path", "filename" => $filename);
                                ;
                                $headers2 = array();
                                $headers2[] = "Accept:application/json; charset=utf-8";
                                $headers2[] = "X-Atlassian-Token:nocheck";
                                $headers2[] = "Content-Type:multipart/form-data; boundary=9876543212345678";

                                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch2, CURLOPT_POST, 1);
                                curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
                                curl_setopt($ch2, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch2, CURLOPT_INFILESIZE, $filesize);
                                curl_setopt($ch2, CURLOPT_URL, $attachmentsurl);
                                curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                                curl_setopt($ch2, CURLOPT_USERPWD, $username . ":" . $password);
                                $result2 = curl_exec($ch2);
                                $ch2_error = curl_error($ch2);
                                curl_close($ch2);
                                if ($ch2_error) {
//                                echo "CURL Error: $ch_error";
//                                error_log("CURL Error: $ch_error");
                                } else {
//                                error_log("CURL res:" . var_dump($result2));
//                                echo $result2;
                                }
                                unlink($path);
                            }
                        }
                    }
                    if (isset($issuenumber) && $issuenumber != "") {
                        $this->sendTicketCreateMail($issuenumber);
                        $this->setResponseToSession(self::SUCCESS, $issuenumber . ' Ticket generated successfully');
                    } else {
                        $this->setResponseToSession(self::FAIL, 'Ticket generation failed. Please try Again');
                    }
//                echo "<script>window.top.location.href = " . $redirectUrl.";</script>";
                    error_log("redirect url : " . $redirectUrl);
                    header('Location:' . $redirectUrl);
                    exit;
                }
            } else {
                header('Location:' . DEFAULT_REDIRECT_URL);
                exit;
            }
        } else {
            header('Location:' . DEFAULT_REDIRECT_URL);
            exit;
        }
    }
    public function sendTicketCreateMail($issuenumber) {
//        $issuenumber = 'WNSRF-325';
        if (isset($issuenumber) && $issuenumber != "") {
            $username = base64_decode(JIRA_USER_NAME);
            $password = base64_decode(JIRA_USER_PWD);
            $url = API_BASE_URL . 'issue/' . $issuenumber . '?expand=changelog';
//            $url = API_BASE_URL . 'issue/WNSRF-325?expand=changelog';
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
//            print_r($url);
//            \App::pre($completeIssueData);
            $requesterName = $completeIssueData['fields']['customfield_11020'];   // Requester Name
            $requesterEmail = $completeIssueData['fields']['customfield_11018'];   // Requester Email  
            $assigneeName = $completeIssueData['fields']['assignee']['name'];   //  Assignee Name 
            $assigneeEmail = $completeIssueData['fields']['assignee']['emailAddress'];   //  Assignee Email
            if (isset($completeIssueData['fields']['customfield_11021']) && $completeIssueData['fields']['customfield_11021'] != '') {
                $addReqEmails = explode(',', $completeIssueData['fields']['customfield_11021']);
                foreach ($addReqEmails as $email) {
                    $additionalCCs[$email] = '';
                }
            }
            $replyTocomment = '<a target="_blank" href="' . SITE_URL . 'support/supportticketview?key=' . base64_encode($issuenumber) . '">Click Here</a>';

            $ticketDetails = $this->getTicketDetailsEmailTemplate($completeIssueData, 'jira:issue_created');
            $parameters = array(
                'REQUESTER' => $requesterName,
                'ID' => $issuenumber,
                'CLICK_HERE' => $replyTocomment,
                'REQUESTER_STATUS' => $completeIssueData['fields']['status']['name'],
                'TICKET_DETAILS' => $ticketDetails
            );
            $subject = "Support Request #" . $issuenumber . " has been Created";
            $emailTemplate = EmailTemplates::ticketCreateTemplate();
            $toEmails[$requesterEmail] = $requesterName;
            $additionalCCs[$assigneeEmail] = '';
//            $additionalCCs['kevin@incipio.com'] = 'Kevin Suda';
            $body = EmailTemplates::setParameters($emailTemplate, $parameters);
            if (!empty($toEmails) && !empty($requesterEmail)) {
                $this->sendMail($toEmails, $subject, $body, $additionalCCs);
                return true;
            } else {
                error_log("No requester email " . $body . $requesterEmail);
                return true;
            }
        }
    }

    public function supportTicketViewAction() {
//        \App::pre($_SESSION);
//        print_r("test");exit;
        if (isset($_REQUEST['proj_jira_code']) && $_REQUEST['proj_jira_code'] != '') {
            $projJiraData = $this->_model->getProjectsDetails($_REQUEST['proj_jira_code']);
            if (ENV == 'LIVE') {
                $projFolder = $projJiraData['live_project_folder'];
            } else {
                $projFolder = $projJiraData['dev_project_folder'];
            }
            $projectPath = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $projFolder . '/';
            $this->_view->addParam('projJiraData', $projJiraData);
            $this->_view->addParam('projectPath', $projectPath);
            if (isset($_SESSION['common_requester_id']) && $_SESSION['common_requester_id'] != '') {


                if (isset($_REQUEST['key']) && $_REQUEST['key'] != '') {
                    $issueKey = base64_decode($_REQUEST['key']);
                    $username = base64_decode(JIRA_USER_NAME);
                    $password = base64_decode(JIRA_USER_PWD);
//        $reqData  = APIHelper::sendGetRequest('issue/'.$issueKey.'?expand=changelog');
//        $completeIssueData = $reqData->getData();
//        App::pre($commentData);

                    $url = API_BASE_URL . 'issue/' . $issueKey;
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
//            \App::pre($completeIssueData);
                    if (!isset($completeIssueData['id']) && isset($completeIssueData['errorMessages']) && $completeIssueData['errorMessages'] != '') {
//                echo 'fail';exit;
                        $this->setResponseToSession(self::FAIL, ' Ticket details not found');
                        header('Location:' . $projectPath . 'front/dashboard');
                        exit;
                    }
                    $this->_view->addParam('ticketsData', $completeIssueData);
                } else {
                    $this->setResponseToSession(self::FAIL, ' Ticket details not found');
                    header('Location:' . $projectPath . 'front/dashboard');
                    exit;
                }
                $UrlData = explode('/', $_REQUEST['r']);
                if ($UrlData[0] == 'front') {
                    $this->_view->addParam('viewtype', 'front');
                } else {
                    $this->_view->addParam('viewtype', 'backadmin');
                }

                $this->_view->render(false);
                exit;
            } else {
                header('Location:' . $projectPath);
                exit;
            }
        } else {

            header('Location:' . DEFAULT_REDIRECT_URL);
            exit;
        }
    }

    public function addCommentAction() {
//        \App::pre($_REQUEST);
        https://incipiogroup.atlassian.net/rest/api/latest/issue/ESD-122/comment
//         $reqData  = APIHelper::sendPostRequest($_REQUEST['key'].'/comment', $data);
            
            if (isset($_REQUEST['proj_jira_code']) && $_REQUEST['proj_jira_code'] != '') {
            $projJiraData = $this->_model->getProjectsDetails($_REQUEST['proj_jira_code']);
            if (ENV == 'LIVE') {
                $projFolder = $projJiraData['live_project_folder'];
            } else {
                $projFolder = $projJiraData['dev_project_folder'];
            }
            $projectPath = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $projFolder . '/';
            }else{
                header('Location:' . DEFAULT_REDIRECT_URL);
                exit;
            }
            
        if (!isset($_SESSION['common_requester_id']) || $_SESSION['common_requester_id'] == '') {
            header('Location:' . $projectPath . 'front');
            exit;
        }
        if (isset($_REQUEST['key']) && $_REQUEST['key'] != '') {
            if ($_REQUEST['type'] == 'front') {
                $redirectUrl = 'support/supportticketview';
            }
            $url = API_BASE_URL . '/issue/' . $_REQUEST['key'] . '/comment';

            $commentData = array();
            if (isset($_SESSION[PROJECT_NAME]['readonly']['requester_display_name']) && $_SESSION[PROJECT_NAME]['readonly']['requester_display_name'] != '') {
                $support_requester_name = $_SESSION[PROJECT_NAME]['readonly']['requester_display_name'];
                $support_requester_email = $_SESSION[PROJECT_NAME]['readonly']['requester_email'];
            } else {
                $support_requester_name = $_SESSION[PROJECT_NAME]['readonly']['admin_display_name'];
                $support_requester_email = $_SESSION[PROJECT_NAME]['readonly']['admin_email'];
            }
            $commentBody = "Commented By: " . $support_requester_name . " < " . $support_requester_email . " >\n \n ";
            $commentData['body'] = $commentBody . trim($_REQUEST['comment_text']);
//                   $commentData['fields']['description'] = $_REQUEST['description'];
//                   print_r(json_encode($dataArray));
//                   exit;
            $txt = json_encode($commentData, true);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $txt);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, base64_decode(JIRA_USER_NAME) . ":" . base64_decode(JIRA_USER_PWD));
            $headers = array();

            $headers[] = "Content-Type: application/json; charset=utf-8";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Grab URL and pass it to the browser
            $result = curl_exec($ch);
            $ch_error = curl_error($ch);
            curl_close($ch);

            if ($ch_error) {
                error_log("CURL Error: $ch_error");
                $this->setResponseToSession(self::FAIL, ' Comment not added . Please try again !');
            } else {
                $this->setResponseToSession(self::SUCCESS, ' Comment added successfully.');
            }
        } else {
            $this->setResponseToSession(self::FAIL, ' Ticket details not found');
            $redirectUrl = 'dashboard';
        }
        header('Location:' . SITE_URL . $redirectUrl . '?key=' . base64_encode($_REQUEST['key']) . '&proj_jira_code='.$_REQUEST['proj_jira_code']);
        exit;
    }

    function downloadJiraAttachmentsAction() {
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

        if ($result) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename(base64_decode($_REQUEST['file'])));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            ob_clean();
            echo ($result);
            exit;
        }
    }

    private function getJqueryValidation() {

        return [
            'rules' => [
                'title' => ['required' => true],
                'service_type' => ['required' => true],
//                'shipping_contact_email_id' => ['required' => true, 'email' => true],
                'priority' => ['required' => true]
            ],
            'messages' => [
                'title' => ['required' => 'Please enter Title.'],
                'service_type' => ['required' => 'Please enter Service Type.'],
//                'shipping_contact_email_id' => ['required' => 'Please enter email id.', 'email' => 'Please enter valid email id.'],
                'priority' => ['required' => 'Please select Severity']
            ]
        ];
    }

}
