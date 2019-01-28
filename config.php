<?php
require 'server_config.php';


define('DS', DIRECTORY_SEPARATOR);
define('DOC_ROOT_PATH', dirname(__FILE__));
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/' . basename(DOC_ROOT_PATH) . '/');

define('CONN_DRIVER', 'mysql');
define('CONN_HOST', 'localhost');


// live
//define('CONN_USER', 'euutugaqnr');
//define('CONN_PASSWORD', 'UG4ADNdUtr');
//define('DATABASE_NAME', 'euutugaqnr');

define('DEFAULT_CONTROLLER', 'front');
define('DEFAULT_ACTION', 'index');

define('RECORDS_PER_PAGE', 15);
define('CURRENT_DATE', date('Y-m-d H:i:S'));

/* Cache and Log settings */
define('LOG_FILE_PATH', 'tmp' . DS . 'logs' . DS);
define('FILE_UPLOAD_PATH', 'uploads');

// Email setting
define('ADMIN_EMAIL_FROM_ID', 'donotreply@incipio.com');
define('ADMIN_EMAIL_FROM_NAME', 'No Reply - Support Tickets');

// Jira User credentials harikrishna@incipio.com
//print_r($_SESSION);exit;
//if($_SESSION['PROJECT_NAME'] == 'netsuite-sample-request-portal'){
//  define('JIRA_PROJ_KEY', 'WNSRF');
//  define('SUPPORT_SPRINT_ID', 98);
//  define('SUPPORT_ASSIGNEE', 'pradeep');
//  define('KEVIN_SPRINT_ID', 99);
//  define('KEVIN_ASSIGNEE', 'harikrishna');
//  
//}else if($_SESSION['PROJECT_NAME'] == 'po-requisition'){
//  define('JIRA_PROJ_KEY', 'WPRF');
//  define('SUPPORT_SPRINT_ID', 104);
//  define('SUPPORT_ASSIGNEE', 'pradeep');
//  define('KEVIN_SPRINT_ID', 103);
//  define('KEVIN_ASSIGNEE', 'harikrishna');
//}


//define('JIRA_USER_NAME', 'aGFyaWtyaXNobmFAaW5jaXBpby5jb20=');
//define('JIRA_USER_PWD', 'Y2guc2FpZ2FuZXNoNTIx');


define('API_BASE_URL', 'https://incipio.atlassian.net/rest/api/latest/');      // JIRA API call base url 


// Jira Auth User credentials incipiodev@incipio.com enyc base64
define('JIRA_USER_NAME', 'aW5jaXBpb2RldkBpbmNpcGlvLmNvbQ===');
define('JIRA_USER_PWD', 'WDVlU2YmRWVLKmc1');