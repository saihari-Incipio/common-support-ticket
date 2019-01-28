<?php

class FrontController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        // Login check for front
        global $router;
        $action = strtolower($router->getAction());
        if ($action != 'login' && $action != 'downloadpdf' && $action != 'erpwebhook') {
            $this->loginCheck();
        }

        $this->_model = new FrontModel();
    }

    public function indexAction() {

        $this->_view->addparam('trackList', $this->_model->getTracksList());
        $this->_view->render();
    }

    public function loginAction() {
//                App::pre($_POST);

        if (isset($_SESSION['requester_id']) && $_SESSION['requester_id'] != "") {
            header('Location:' . SITE_URL . 'front/dashboard');
            exit;
        }

        if (isset($_POST['username']) && isset($_POST['password'])) {

            $user = new AdminUser();
            $userData = $user->frontloginAuthenticate($_POST['username'], $_POST['password']);
//            App::pre($userData);
            if (empty($userData)) {
                $this->setResponseToSession(self::FAIL, 'Invalid username or password!');
                header('Location:' . SITE_URL . 'front/login');
                exit;
            } else {
                session_destroy();
                session_start();
                $_SESSION['requester_id'] = $userData['id'];
                $_SESSION['requester_email'] = $userData['email'];
                $_SESSION['requester_dept_id'] = $userData['depart_id'];
                $_SESSION['requester_display_name'] = $userData['name'];
                $_SESSION['requester_department'] = $userData['depart_name'];
                $_SESSION['admin_type'] = 'Requester';
                header('Location: ' . SITE_URL . 'front/dashboard');
                exit;
            }
        }

        $this->_view->render(false);
    }

    public function dashboardAction() {

        $_SESSION['page'] = 0;
        $_SESSION['startAt'] = 0;

        $ticketsData = $this->getTicketsByRequester();

        if (!empty($ticketsData)) {
            Model::$TOTAL_RECORD_COUNT = $ticketsData['total'];
        }
        // App::pre($projectsData);
        $departments = $this->_model->getRecords(['*'], 'common_project_departments', ['status' => 'L', 'brand' => 'INCIPIO'], 'd_name ASC');
//        $designers = $this->_model->getRecords(['*'], 'projects_designers', ['STATUS' => 'active'], 'PDNAME ASC');
        $uniqueRequesters = $this->_model->getRecords(['CONCAT(first_name, " ", last_name) AS requester', 'status', 'id'], 'common_project_requesters', [], 'requester ASC');
//        $brands = $this->_model->getBrands();
//        $deliverables = $this->_model->getDeliverableNames();
//        $projecttype = $this->_model->getRecords(['*'], 'production_request_project_types', ['status' => 'L'], 'project_type ASC');
//        $projectdeli = $this->_model->getRecords(['*'], 'production_request_deliverables', ['status' => 'L'], 'deliverables ASC');
//        App::pre($this->_model->getRequestersList());

        $this->_view->addParam('ticketsData', $ticketsData);
        $this->_view->addParam('departments', $departments);
//        $this->_view->addParam('requesters', $this->_model->getRequestersList());
//        $this->_view->addParam('designers', $this->_model->getDesigners());
        $this->_view->addParam('requesters', $uniqueRequesters);
//        $this->_view->addParam('brands', $brands);
//        $this->_view->addparam('projecttype', $projecttype);
//        $this->_view->addparam('brandtype', $brandtype);
//        $this->_view->addparam('projectdeli', $projectdeli);
//        $this->_view->addParam('deliverables', $deliverables);
//        $this->_view->addParam('total_table_columns', unserialize(FRONT_TAB_COLUMNS));
//        $this->_view->addParam('isProjectList', true);

        $this->_view->render(false);
    }

    public function dashboardrequestfilterAction() {

        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 1) {
//            $_SESSION['page'] = $_REQUEST['page'] + 1;
            $_SESSION['startAt'] = (($_REQUEST['page'] - 1) * RECORDS_PER_PAGE);
        } else {
//            $_SESSION['page'] = 0;
            $_SESSION['startAt'] = 0;
        }
//        $_SESSION['page'] = $_REQUEST['page'];
        $ticketsData = $this->getTicketsByRequester();
        if (!empty($ticketsData)) {
            Model::$TOTAL_RECORD_COUNT = $ticketsData['total'];
        }
        $this->_view->addParam('ticketsData', $ticketsData);
        $this->_view->render(false);
    }

    private function sendEmailToAdmin($requestDetails) {

        $view = new View();
        $view->setTemplate('backadmin/event_details');
        $view->addParam('eventInfo', $requestDetails);
        $requestDetailsHtml = $view->getViewContent();

        // send email
        $subject = 'CES Meeting Room Requested by: ' . $requestDetails['requester_name'];
        $emailTemplate = $this->getEmailTemplete();
        $toEmails = [ADMIN_EMAIL_ID => ADMIN_EMAIL_NAME];

        $mailBody = 'A CES Meeting Room Request has been submitted. Please visit the <a href="' . SITE_URL . '/backadmin">CES Meeting Room Requests Dashboard</a> to manage request. <br><br>';
        $mailBody .= $requestDetailsHtml;

        $mailBody = str_replace('{{MSG_BODY}}', $mailBody, $emailTemplate);
        $this->sendMail($toEmails, $subject, $mailBody);
    }

    public function getSubTracksListAction() {

        $subTrackListHtml = '<option value="" disabled="" selected="">Please select a Sub Track</option>';
        if (isset($_REQUEST['track_id']) && $_REQUEST['track_id'] != '') {
            $subTrackListData = $this->_model->getSubTracksList($_REQUEST['track_id']);

            foreach ($subTrackListData as $subTrack) {
                $subTrackListHtml .= '<option value="' . $subTrack['id'] . '">' . $subTrack['sub_track_name'] . '</option>';
            }
        }
        echo $subTrackListHtml;
        exit;
    }

    public function submitTicketAction() {
        $trackName = '';
        $subTrackName = '';
//        print_r($_FILES);
//        App::pre($_REQUEST);
        if (isset($_REQUEST['title'])) {


            $validtionArray = array(
                'description' => ['type' => 'text'],
                'platform' => ['type' => 'text'],
                'track_type' => ['type' => 'text'],
                'sub_track_type' => ['type' => 'text'],
                'instance' => ['type' => 'text'],
                'phase' => ['type' => 'text'],
                'service_type' => ['type' => 'text'],
            );


//            App::pre($validtionArray);
            // validate input parameters
            $this->validateRequestParameters($validtionArray);
            $trackdata = $this->_model->getRecordById('erp_service_tracks', $_REQUEST['track_type'], ['track_name']);
            $subTrackdata = $this->_model->getRecordById('erp_service_subtracks', $_REQUEST['sub_track_type'], ['sub_track_name', 'business_sme_name', 'business_sme_email']);
            $subTrackdata = $this->_model->getSubTrackByIdData($_REQUEST['sub_track_type']);

//            print_r($trackdata);
//            print_r($subTrackdata);
//                    App::pre($_REQUEST);

            $title = $_REQUEST['title'];
            $url = "https://incipiogroup.atlassian.net/rest/api/latest/issue/";
//            $url = "https://incipiogroup.atlassian.net/servicedesk/customer/portal/42/create/208";

            $username = base64_decode(JIRA_USER_NAME);
            $password = base64_decode(JIRA_USER_PWD);
//            if ($_REQUEST['service_type'] == "Support Bug")
//                $assigneename = "akhil";
//            else
            $assigneename = "akhil";
            $dataArray = array();
            $dataArray['fields']['project']['key'] = JIRA_PROJ_KEY;
            $dataArray['fields']['summary'] = $_REQUEST['title'];
            $dataArray['fields']['description'] = $_REQUEST['description'];
            $dataArray['fields']['issuetype']['name'] = $trackdata['track_name'];
            $dataArray['fields']['assignee']['name'] = $subTrackdata['assignee_uname'];
            $dataArray['fields']['customfield_11304']['value'] = $_REQUEST['platform'];
            $dataArray['fields']['customfield_11305']['value'] = $trackdata['track_name'];
            $dataArray['fields']['customfield_11306']['value'] = $subTrackdata['sub_track_name'];
            $dataArray['fields']['customfield_11307']['value'] = $_REQUEST['instance'];
            $dataArray['fields']['customfield_11308']['value'] = $_REQUEST['phase'];
            $dataArray['fields']['customfield_11309']['value'] = $_REQUEST['service_type'];
            $dataArray['fields']['customfield_11310'] = $_SESSION['requester_email'];
            $dataArray['fields']['customfield_11311'] = $_SESSION['requester_department'];
            $dataArray['fields']['customfield_11312'] = $_SESSION['requester_display_name'];
//                   print_r(json_encode($dataArray));
//                   exit;
            $txt = json_encode($dataArray, true);

//            error_log("json request Data :" . $txt);
//            $result = APIHelper::sendPostRequest('issue', $dataArray);
//            $data = $result->getData();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $txt);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            $headers = array();

            $headers[] = "Content-Type: application/json; charset=utf-8";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Grab URL and pass it to the browser
            $result = curl_exec($ch);
            $ch_error = curl_error($ch);
            curl_close($ch);

            $data = json_decode(trim($result), true);

            if (!isset($data['key']) || $data['key'] == '') {
                error_log("Creation failed : ");
                error_log("curl response : " . $result);
                error_log("curl error : " . $ch_error);
                $this->setResponseToSession(self::FAIL, 'Ticket creation failed. Please try Again');
                header('Location:' . SITE_URL);
                exit;
            } else {
                $issuenumber = $data['key'];
                $issueid = $data['id'];
                $no_files = count($_FILES["fileToUpload"]['name']);

                if ($no_files > 0 && $issuenumber != '') {
                    for ($i = 0; $i < $no_files; $i++) {
                        if ($_FILES["fileToUpload"]["error"][$i] == 0) {

                            // Add atatchments

                            $attachmentsurl = "https://incipiogroup.atlassian.net/rest/api/latest/issue/" . $issuenumber . "/attachments";

                            $ch2 = curl_init();
                            $file_name = time() . '-' . basename($_FILES['fileToUpload']['name'][$i]); //creating file name
                            $path = DOC_ROOT_PATH . '/tmp/' . $file_name; //creating temp path
                            file_put_contents($path, file_get_contents($_FILES['fileToUpload']['tmp_name'][$i]));
                            $filename = $_FILES['fileToUpload']['name'][$i];
                            $filedata = $_FILES['fileToUpload']['tmp_name'][$i];
                            $filesize = $_FILES['fileToUpload']['size'][$i];

                            error_log("real path attachment" . realpath($_FILES['fileToUpload']['name'][$i]));
                            error_log($attachmentsurl);
                            $data = array("file" => "@$path", "filename" => $filename);
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
                                echo "CURL Error: $ch_error";
                                error_log("CURL Error: $ch_error");
                            } else {
                                error_log("CURL res:" . var_dump($result2));
                                echo $result2;
                            }
                            unlink($path);
                        }
                    }
                } else {
                    if ($issuenumber == '') {
                        $this->setResponseToSession(self::FAIL, 'Ticket creation failed. Please try Again');
                        header('Location:' . SITE_URL);
                        exit;
                    }
                }
                //end Add attachments
                $this->setResponseToSession(self::SUCCESS, $issuenumber . ' Ticket created successfully');
                header('Location:' . SITE_URL);
                exit;
            }
        }
    }

    public function viewRequestAction() {

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
//            App::pre($completeIssueData);
            if (isset($completeIssueData['key']) && $completeIssueData['key'] != '') {
                $url = API_BASE_URL . 'issue/' . $issueKey . '?expand=changelog';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                curl_setopt($ch, CURLOPT_HEADER, 0);

                $logResult = curl_exec($ch);
                $ch_error = curl_error($ch);
                curl_close($ch);
//            App::pre($logResult);
                $logResult = json_decode(trim($logResult), true);
//                App::pre($logResult);
                $this->_view->addParam('ticketsData', $completeIssueData);
                $this->_view->addParam('logResult', $logResult['changelog']['histories']);
//            print_r($completeIssueData);
                $this->_view->render(false);
            } else {
                $this->setResponseToSession(self::FAIL, ' Ticket details not found');
                header('Location:' . SITE_URL);
            }
        } else {
            $this->setResponseToSession(self::FAIL, ' Ticket details not found');
            header('Location:' . SITE_URL);
        }
        $this->_view->render(false);
//            error_log("Complete Data : ".$completeIssueData['fields']['assignee']['emailAddress']);
    }

    public function editRequestAction() {

        if (isset($_REQUEST['key']) && $_REQUEST['key'] != '') {
            $issueKey = base64_decode($_REQUEST['key']);
            $username = base64_decode(JIRA_USER_NAME);
            $password = base64_decode(JIRA_USER_PWD);


            $url = 'https://incipiogroup.atlassian.net/rest/api/latest/issue/' . $issueKey;
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
//            App::pre($completeIssueData);
            if($completeIssueData['fields']['status']['statusCategory']['name'] == 'To Do'){
            if (isset($completeIssueData['key']) && $completeIssueData['key'] != '') {
                $this->_view->addParam('ticketsData', $completeIssueData);
                $this->_view->addparam('trackList', $this->_model->getTracksList());
                $trackList = $this->_model->getTracksList();
                foreach ($trackList as $track) {
                    if ($completeIssueData['fields']['customfield_11305']['value'] == $track['track_name']) {
                        $trackId = $track['id'];
                    }
                }
                $this->_view->addparam('subtrackList', $this->_model->getSubTracksList($trackId));
//                App::pre($this->_model->getSubTracksList($trackId));
                $this->_view->render(false);
            } else {
                $this->setResponseToSession(self::FAIL, ' Ticket details not found Ticket updation failed. please try again');
                header('Location:' . SITE_URL . 'front/dashboard');
            }
        } else {
            $this->setResponseToSession(self::FAIL, ' Ticket not allowed to edit due to status has changed to '. $completeIssueData['fields']['status']['statusCategory']['name']);
            header('Location:' . SITE_URL . 'front/dashboard');
        }
        }else {
            $this->setResponseToSession(self::FAIL, ' Ticket details not found');
            header('Location:' . SITE_URL . 'front/dashboard');
        }
        $this->_view->render(false);
//            error_log("Complete Data : ".$completeIssueData['fields']['assignee']['emailAddress']);
    }

    public function submitEditRequestAction() {
//        print_r($_REQUEST);
//        App::pre(file_get_contents($_FILES['myfile']['tmp_name']));
        if (isset($_REQUEST['key']) && $_REQUEST['key'] != '') {
            $issueKey = $_REQUEST['key'];
            $username = base64_decode(JIRA_USER_NAME);
            $password = base64_decode(JIRA_USER_PWD);
            $url = 'https://incipiogroup.atlassian.net/rest/api/latest/issue/' . $issueKey;

            $dataArray = array();
            $trackdata = $this->_model->getRecordById('erp_service_tracks', $_REQUEST['track_type'], ['track_name']);
            $subTrackdata = $this->_model->getRecordById('erp_service_subtracks', $_REQUEST['sub_track_type'], ['sub_track_name', 'business_sme_name', 'business_sme_email']);
            $subTrackdata = $this->_model->getSubTrackByIdData($_REQUEST['sub_track_type']);

            $dataArray['fields']['summary'] = $_REQUEST['title'];
            $dataArray['fields']['description'] = trim($_REQUEST['description']);
//            $dataArray['fields']['issuetype']['name'] = $trackdata['track_name'];
            $dataArray['fields']['customfield_11304']['value'] = $_REQUEST['platform'];
            $dataArray['fields']['customfield_11305']['value'] = $trackdata['track_name'];
            $dataArray['fields']['customfield_11306']['value'] = $subTrackdata['sub_track_name'];
            $dataArray['fields']['customfield_11307']['value'] = $_REQUEST['instance'];
            $dataArray['fields']['customfield_11308']['value'] = $_REQUEST['phase'];
            $dataArray['fields']['customfield_11309']['value'] = $_REQUEST['service_type'];


            $txt = json_encode($dataArray, true);
            error_log($url);
            error_log($txt);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $txt);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            $headers = array();

            $headers[] = "Content-Type: application/json; charset=utf-8";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Grab URL and pass it to the browser
            $result = curl_exec($ch);
            $ch_error = curl_error($ch);
            curl_close($ch);
            

                $no_files = count($_FILES["myfile"]['name']);

                if ($no_files > 0 && $issueKey != '') {
//                    for ($i = 0; $i < $no_files; $i++) {
                        if ($_FILES["myfile"]["error"] == 0) {

                            // Add atatchments

                            $attachmentsurl = API_BASE_URL."/issue/" . $issueKey . "/attachments";
                           
                            
                            $file_name = time() . '-' . basename($_FILES['myfile']['name']); //creating file name
                            $path = DOC_ROOT_PATH.'/tmp/'.$file_name;//creating temp path
                            file_put_contents($path, file_get_contents($_FILES['myfile']['tmp_name']));
                            $filename = $_FILES['myfile']['name'];
                            $filedata = $_FILES['myfile']['tmp_name'];
                            $filesize = $_FILES['myfile']['size'];
                            
//                            error_log("real path attachment" . realpath($_FILES['myfile']['name']));
                            error_log($attachmentsurl);
                            $data = array("file" => "@$path", "filename" => $filename);
//                            error_log("Files Data :".$_FILES);
//                          error_log("Data :".$data);
                            $headers2 = array();
                    $headers2[] = "Accept:application/json; charset=utf-8";
                    $headers2[] = "X-Atlassian-Token:nocheck";
                    $headers2[] = "Content-Type:multipart/form-data; boundary=9876543212345678" ;
                     $ch2 = curl_init();
                    
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
//                                echo "CURL Error: $ch2_error";
                                error_log("CURL Error: $ch2_error");
                            } else {
//                                error_log("CURL res:" . var_dump($result2));
//                                echo $result2;
                            }
                            unlink($path);
                        }
//                    }
                }
                
            if (empty($ch_error)) {
//                App::pre($result2);
                $response = array('status' => 1, 'message' => 'Ticket updated successfully');
                
                $this->setResponseToSession(self::SUCCESS, ' Ticket updated successfully');
//                header('Location:' . SITE_URL . 'front/dashboard');
            } else {
                $response = array('status' => 2, 'message' => 'Ticket details not found Ticket updation failed. Please try again');
                
                $this->setResponseToSession(self::FAIL, ' Ticket details not found Ticket updation failed. Please try again');
//                header('Location:' . SITE_URL . 'front/dashboard');
            }
       
        }else{
            $response = array('status' => 2, 'message' => 'Ticket Id not found Ticket updation failed. Please try again');
                
                $this->setResponseToSession(self::FAIL, ' Ticket details not found Ticket updation failed. Please try again');
        }
         echo json_encode($response);
        exit;
    }
    
    public function deleteAttachmentAction($Aid){
        if($_REQUEST['id'] != ''){
            
            $username = base64_decode(JIRA_USER_NAME);
            $password = base64_decode(JIRA_USER_PWD);
            $url = 'https://incipiogroup.atlassian.net/rest/api/latest/attachment/' . $_REQUEST['id'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $result = curl_exec($ch);
            $ch_error = curl_error($ch);
            curl_close($ch);
            $this->setResponseToSession(self::SUCCESS, ' Attachment deleted successfully');
               
            header('Location:' . SITE_URL . 'front/viewrequest?key='.base64_encode($_REQUEST['key']));
            
        }else{
            $this->setResponseToSession(self::FAIL, ' Attachment not found. Please try again');
               
            header('Location:' . SITE_URL . 'front/dashboard');
        }
    }

    public function emailsAction() {
        $emailRecords = $this->_model->getEmailRecords();
        $this->_view->addParam('emailRecords', $emailRecords);
        $this->_view->addParam('isEmailHistory', true);
        $this->_view->render(false);
    }

    public function addCommentAction() {
//        App::pre($_REQUEST);
        https://incipiogroup.atlassian.net/rest/api/latest/issue/ESD-122/comment
//         $reqData  = APIHelper::sendPostRequest($_REQUEST['key'].'/comment', $data);
        if (isset($_REQUEST['key']) && $_REQUEST['key'] != '') {
            $url = API_BASE_URL . '/issue/' . $_REQUEST['key'] . '/comment';

            $commentData = array();
            $commentData['body'] = $_REQUEST['comment_text'];
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
        }
        header('Location:' . SITE_URL . 'front/viewrequest?key=' . base64_encode($_REQUEST['key']));
    }

}
