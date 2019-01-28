<?php

class EmailTemplates {
    
    private $_poDetails = null;
    private $_tableStyles = 'background-color:#DDDDDD;width:100%; font-size: 14px;';
    private $_trStyles = 'padding:5px;';
    private $_tdStyles = 'padding:5px; background-color: #F9F9F9;';
    private $_auditDateFormat = 'l\, F j, Y @ H:i A \P\S\T';
    private $_buttonTdStyles =  "style='width: 70px;'";
    
    public function __construct($poRequestId) {
//        $poModel = new \incipio\front\models\POModel(); // get latest po data
//        $this->_poDetails = $poModel->getProjectRequest($poRequestId);;
    }

    
     // from the support ticket emails
    
    public static function ticketCreateTemplate() {
        $mailBody = "Hello {{REQUESTER}},<br/><br/>

This email confirms that your new Support Request has been submitted and is currently in status {{REQUESTER_STATUS}}. Please see the full details below. You may {{CLICK_HERE}} to add any additional comments as needed.<br/><br/>
Support Request Details:
{{TICKET_DETAILS}}<br/><br/>";
        return $mailBody;
    }

    public static function ticketCommentTemplate() {
        $mailBody = "Hello {{REQUESTER}},<br/><br/>

A new comment has been added to your Support Request. Please see the comment below and {{CLICK_HERE}} to access the full comment history.<br/><br/>
Comment: <br/><div>{{COMMENT}}</div><br/><br/>
Support Request Details:
{{TICKET_DETAILS}}<br/><br/>";
        return $mailBody;
    }

    public static function ticketStatusUpdateTemplate() {
        $mailBody = "Hello {{REQUESTER}},<br/><br/>

Your Support Request #{{ID}} has been updated to status {{REQUESTER_STATUS}}.<br/><br/>
{{CLICK_HERE}} to access the full Support Request history.<br/><br/>

Support Request Details:
{{TICKET_DETAILS}}<br/><br/>";
        return $mailBody;
    }
    
    public static function setParameters($template, array $params) {
        foreach ($params as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        return $template;
    }
}

class EmailTemplate {
    
    private $_subject;
    private $_body;
    
    public function __construct($subject, $body) {
        $this->_subject = $subject;
        $this->_body = $body;    
    }
    
    public function getSubject() {
        return $this->_subject;
    }
    
    public function getBody() {
        return $this->_body;
    }
    
    public function setParameters(array $params) {
        foreach($params as $key => $value) {
            $this->_subject = str_replace('{{'.$key.'}}', $value, $this->_subject);
            $this->_body = str_replace('{{'.$key.'}}', $value, $this->_body);
        }
    }
}
