
<script type="text/javascript">
    var usStateNames = $.parseJSON('<?= json_encode($usStateNames);?>');
    var jqueryValidation = $.parseJSON('<?= json_encode($jqueryValidation);?>');
</script>

<?php

use incipio\lib\Session;
use incipio\lib\Utility;

// echo "sessions <pre>"; print_r($_SESSION);
// echo "edit_request_data <pre>"; print_r($edit_request_data);  exit;



if (!empty($edit_request_data)) {


    if (!empty($edit_request_data['request_created_by'])) {
        $requester_name = $edit_request_data['request_created_by']['name'];
        $requester_email = $edit_request_data['request_created_by']['email'];
        $requester_department = $edit_request_data['request_created_by']['department'];
    } else {
        $requester_name = Session::get('requester_display_name');
        $requester_email = Session::get('requester_email');
        $requester_department = Session::get('requester_dept_name');
    }
    // $edit_requester_name=$edit_request_data[0]['requester_name']; 

    $edit_rid = $edit_request_data[0]['sample_request_id'];
    $formatted_id=$edit_request_data[0]['formatted_request_id'];
           $formattedRequestId = !empty($formatted_id) ? $formatted_id : Utility::getFormatedPOId($edit_rid, $edit_request_data[0]['requester_department'][0]);   
     $splittedFormatId=explode("-",$formattedRequestId); 
     $edit_formatted_id=$splittedFormatId[1];
     
    $unique_key = $edit_request_data[0]['unique_request_key'];
    $edit_brand = $edit_request_data[0]['brand'];
    $edit_billing_account = $edit_request_data[0]['billing_account'];
    $edit_purpose = $edit_request_data[0]['purpose'];
    $edit_customer_event_name = $edit_request_data[0]['customer_event_name'];
    $edit_is_sample_returnable = $edit_request_data[0]['is_sample_returnable'];
    $edit_shipping_country = $edit_request_data[0]['shipping_country'];
    $edit_shipping_address = $edit_request_data[0]['shipping_address'];
    $edit_ship_address_street1 = $edit_request_data[0]['street_1'];
    $edit_ship_address_street2 = $edit_request_data[0]['street_2'];
    $edit_ship_address_city = $edit_request_data[0]['city'];
    $edit_ship_address_state = strtolower($edit_request_data[0]['state']);
    $edit_ship_address_zipcode = $edit_request_data[0]['zip_code'];


    $edit_phone = $edit_request_data[0]['phone'];

    $edit_shipping_date = Utility::getFormatedDate($edit_request_data[0]['shipping_date'], 'm/d/Y');
    $edit_start_date = Utility::getFormatedDate($edit_request_data[0]['start_date'], 'm/d/Y');
    $edit_requested_delivery_date = Utility::getFormatedDate($edit_request_data[0]['requested_delivery_date'], 'm/d/Y');
    $edit_special_preparation_instructions = $edit_request_data[0]['special_preparation_instructions'];
    $edit_attachments = $edit_request_data[0]['attachments'];
    $edit_b_stock_acceptable = $edit_request_data[0]['b_stock_acceptable'];
    $edit_ship_charges_to_customer = $edit_request_data[0]['ship_charges_to_customer'];
    $edit_customer_shipping_charges_account = $edit_request_data[0]['customer_ship_charges_account'];
    $edit_status = $edit_request_data[0]['status'];
    $edit_skudata = $edit_request_data[0]['skudata'];
    $edit_request_type = htmlspecialchars_decode($edit_request_data[0]['request_type']);
    $edit_shipping_carrier = $edit_request_data[0]['shipping_carrier'];
    $edit_company_or_customer_name = NULL;
    
    switch ($edit_request_type) {
        case('media/seeding'):$edit_request_type_label = 'Company name';
            $edit_request_type_placeholder = 'Enter Company name';
            $edit_company_or_customer_name = htmlspecialchars_decode($edit_request_data[0]['company_or_customer_name']);
            break;
        case('sales event'):$edit_request_type_label = 'Event name';
            $edit_request_type_placeholder = 'Enter Event name';
            break;
        case('customer meeting'):$edit_request_type_label = 'Customer name';
            $edit_request_type_placeholder = 'Enter Customer name';
            $edit_company_or_customer_name = htmlspecialchars_decode($edit_request_data[0]['company_or_customer_name']);
            break;
        case('giveaway/gift'):$edit_request_type_label = 'Description';
            $edit_request_type_placeholder = 'Enter Sample request type description';
            break;
        case('donation'):$edit_request_type_label = 'Description';
            $edit_request_type_placeholder = 'Enter Sample request type description';
            break;
        case('R&D'):$edit_request_type_label = 'Description';
            $edit_request_type_placeholder = 'Enter Sample request type description';
            break;
        case('marketing'):$edit_request_type_label = 'Description';
            $edit_request_type_placeholder = 'Enter Sample request type description';
            break;
        case('visuals'):$edit_request_type_label = 'Description';
            $edit_request_type_placeholder = 'Enter Sample request type description';
            break;
    }

    if ($edit_request_type == 'media/seeding' || $edit_request_type == 'customer meeting' || $edit_request_type == 'sales event') {
        $edit_request_type_dependent_field = 'input';
        
    } else {
        $edit_request_type_dependent_field = 'textarea';
    }

    $edit_request_type_dependent_field_value = htmlspecialchars_decode($edit_request_data[0]['request_type_dependent_field']);
    $edit_requester_other_name = $edit_request_data[0]['requester_other_name'];
    $edit_requester_other_email = $edit_request_data[0]['requester_other'];
    $edit_additional_cc_emails = $edit_request_data[0]['additional_cc_emails'];

    $edit_someone_else = $edit_request_data[0]['on_behalf_of'];

    $submit_text = 'UPDATE REQUEST';
    $form_submit_action = SITE_URL . "front/index/updateRequest";

    $file_attachments = (!empty($edit_request_data[0]['attachments'])) ? explode(':', $edit_request_data[0]['attachments']) : array();

    } else {

    $requester_name = Session::get('requester_display_name');
    $requester_email = Session::get('requester_email');
    $requester_department = Session::get('requester_dept_name');
    $unique_key = $edit_requester_name = $edit_rid =$edit_formatted_id= $edit_brand = $edit_billing_account = $edit_purpose = $edit_customer_event_name = $edit_is_sample_returnable = $edit_shipping_country = $edit_shipping_address =$edit_ship_address_street1=$edit_ship_address_street2=$edit_ship_address_city=$edit_ship_address_state=$edit_ship_address_zipcode = $edit_phone = $edit_shipping_date = $edit_start_date = $edit_requested_delivery_date = $edit_special_preparation_instructions = $edit_attachments = $edit_b_stock_acceptable = $edit_ship_charges_to_customer = $edit_customer_shipping_charges_account = $edit_status = $edit_skudata = $edit_request_type = $edit_requester_other_email = $edit_additional_cc_emails = $edit_requester_other_name = $edit_request_type_dependent_field = $edit_request_type_dependent_field_value = $edit_request_type_label = $edit_request_type_placeholder = $edit_company_or_customer_name = NULL;
   
    $edit_someone_else = 'no';
    $submit_text = 'SUBMIT REQUEST';
    $form_submit_action = SITE_URL . "front/index/saveRequest";
    $file_attachments = array();

    $edit_shipping_carrier = '';
}
$sku_count = ($edit_skudata != NULL) ? count($edit_skudata) : 1;
$uploads_count = (!empty($file_attachments)) ? count($file_attachments) : 0;
 $company_customer_selected=1;

// echo "file_attachments<pre>"; print_r($file_attachments); exit;
?>
<link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?= SITE_PUBLIC_URL ?>css/selectize.default.css" />
<script type="text/javascript" src="<?= SITE_PUBLIC_URL ?>js/selectize.js"></script>
<script type="text/javascript" src="<?= SITE_PUBLIC_URL ?>js/main.js"></script>
<script type="text/javascript" src="<?= SITE_PUBLIC_URL ?>js/chosen/chosen.jquery.js"></script>
<link type="text/css" rel="stylesheet" href="<?= SITE_PUBLIC_URL ?>js/chosen/chosen.css" />
<script type="text/javascript" src="<?= SITE_PUBLIC_URL ?>js/daterange/daterangepicker.js"></script>
<!--<script src="<?= SITE_URL ?>views/js/external/jquery.hotkeys.js"></script>-->

<style>

    ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #4DA9EB;
    }
    ::-moz-placeholder { /* Firefox 19+ */
        color: #4DA9EB;
    }
    :-ms-input-placeholder { /* IE 10+ */
        color: #4DA9EB;
    }
    :-moz-placeholder { /* Firefox 18- */
        color: #4DA9EB;
    }

    .spanfilename{
        text-overflow: ellipsis;overflow: hidden; width: 85%;display: inline-block;  white-space: nowrap; vertical-align: middle;float:unset;margin-left: 0%;
    }
    .hero-unit {
        padding: 0px;
    }

    .selectize-control.multi .selectize-input [data-value] .email {
        opacity: 0.5;
    }
    .selectize-control.multi .selectize-input [data-value] .name + .email {
        margin-left: 5px;
    }
    .selectize-control.multi .selectize-input [data-value] .email:before {
        content: ' <';
    }
    .selectize-control.multi .selectize-input [data-value] .email:after {
        content: '>';
    }
    .selectize-control.multi .selectize-dropdown .caption {
        /*font-size: 12px;*/
        float: right;
        /*display: block;*/
        /*opacity: 0.5;*/
        color: #000 !important;
        font-size: 16px;
        font-weight: bold;
    }

    .selectize-dropdown-content{
        background-color: #C0C0C0;
        color:#000 !important; 
        font-size: 16px;
        font-weight: bold; 
    }
    .selectize-dropdown-content div:nth-child(2n) {
        /*background-color: #DCDCDC;*/
        /*color:black;*/
        
    }
     .selectize-dropdown-content div span {
        /*background-color: #DCDCDC;*/
        color:black;
        
    }

    .sku-field td {
        position: relative;
        padding:10px 5px 2px 10px !important;
        vertical-align: unset !important;
        min-width:200px;
    }
    .sku-other-fields td{
        position: relative;
        padding:5px 5px 10px 10px !important;
        /*vertical-align: unset !important;*/
    }
    .all-filenames-span {
        /*background-color: red;*/
        width: 100%;
        margin-left: 0px;
    }

    div.all-filenames-span > div:nth-of-type(odd) {
        background: #CBCBCB;
    }

    .singlefile {
        background-color: #DFE0DF;
        width: 100%;
        padding: 8px;
        color: black;
    }
    .previoussinglefile {
        background-color: #DFE0DF;
        width: 100%;
        padding: 8px;
        color: black;
    }
    .image-upload {
        border: 1px solid #000000;
        border-radius: 28px;
        /*padding: 8px;*/
        overflow: hidden;
    }
    .div-file {    
        background-color: #7bc3f7;
        padding: 8px;
    }
    .sku-div-file {    
        background-color: #7bc3f7;
        padding: 8px;       

    }
    .sku-singlefile {
        background-color: #DFE0DF;
        width: 100%;
        padding: 8px;
        color: black;

    }
    div.sku-all-filenames-span > div:nth-of-type(odd) {
        background: #CBCBCB;
    }
    .sku-all-filenames-span {
        /*background-color: red;*/
        width: 99%;
        margin-left: 0px;
    }
    .sku-image-upload{
        border: 1px solid #000000;
        border-radius: 28px;
        /* padding: 8px; */
        margin-top: 20px;
        overflow: hidden;

    }
    .upload_img {
        opacity: 0;
        position: absolute;
        top: 0px;
        left: 0px;
        width: 37px;
        height: 30px;
    }
    .ui-selectmenu-menu {
        border-bottom: 1px solid #555;
        box-shadow: 1px 12px 20px #888888;
        /*width: 54%;*/
        overflow-x: hidden;
        /*overflow-y: scroll;*/
        width:771px;
    }

    .ui-dropdownchecklist-dropcontainer {
        border-bottom: 1px solid #555;
        box-shadow: 1px 12px 20px #888888;
        /*width: 94%;*/
    }

    #project_subtype-menu #ui-id-2{
        font-weight: bold;
    }

    label.errors, span.errors {
        color: red;
        font-size: 16px;
        margin-left: 8px;
        text-transform: none;
    }

    .tooltips {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
    }

    .tooltips .tooltiptext {
        visibility: hidden;
        width: 400px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        top: -5px;
        left: 110%;
    }

    .tooltips .tooltiptext::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 100%;
        margin-top: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent black transparent transparent;
    }
    .tooltips:hover .tooltiptext {
        visibility: visible;
        z-index:9999;
        overflow: auto;
    }
    .ui-dropdownchecklist-text{
        position: relative;
        display: inline-block;
        /*border-bottom: 1px dotted black;*/
    }
    .label_act{
        position: absolute;
        display: inline-block;
        margin-top: -4px;
        padding-right: 250px;
    }
    .ui-dropdownchecklist-text .tooltiptext {
        visibility: hidden;
        width: 300px;
        background-color: #4da9eb;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        top: -5px;
        left: 110%;
    }

    .ui-dropdownchecklist-text .tooltiptext::after {
        content: "";
        position: absolute;
        top: 8%;
        right: 100%;
        margin-top: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent deepskyblue transparent transparent;
    }
    .ui-dropdownchecklist-text:hover .tooltiptext {
        visibility: visible;
    }
    .ui-state-hover, .ui-widget-content .ui-state-hover{
        /*background: green;*/

    }
    .star-class{
        color:red;
    }
    .skusearch{
        /*width:120%;*/
        -webkit-appearance: none;
        -moz-appearance: none;
        /*text-indent: 1px;*/
        /*text-overflow: '';*/
        border-radius: 10px;
        background-color: #dbdbe6;
        height: 45px;
        pointer-events:none;
        /*margin-left: -20%;*/
        color:#4da9eb;
    }
    
    td {
        padding-top: .5em;
        padding-bottom: .5em;
        vertical-align: top;
    }

    .myul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        max-height:120px;/*The important part*/
        overflow-y:auto;/*Also...*/
        overflow-x:hidden;
        max-width: 80%;
    }

    .myul li a {
        border: 1px solid #ddd;
        margin-top: -1px; /* Prevent double borders */
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        color: black;
        display: block
    }

    .myul li a:hover:not(.header) {
        background-color: #eee;
    }
    .ui-dropdownchecklist-item.ui-state-default input[type="radio"]{
        display:none;
    }
    .inputskusearch {
        /*width:80%;*/
        border: none;
        border-radius: 10px;
        background-color: #dbdbe6;

    }

    .inputqtyrequested {
        width:80%;
        border: none;
        border-radius: 10px;
        background-color: #dbdbe6;
    }
    .inputbrandrequested{
        width:80%;
        border: none;
        border-radius: 10px;
        background-color: #dbdbe6;
        vertical-align: bottom;
    }
    .skusearchimg{
        cursor: pointer;
    }
    .skusearchimg img{
        max-width: 25px;
        right: 2px;
        position: absolute;
        padding: 7px;
        top: 15px;
    }

    .btnAddItem{

        /*padding: 0;*/
        border: none;
        background: none;
        margin:1%;

        cursor: pointer;
        max-height: 30px;
        max-width: 120px;
        display:inline-block;
    }
    .btnAddItem img{
        max-width: 29px;
        vertical-align: middle;
    }
    .imgskuloader{
        max-width: 25px; position: absolute;display:none; padding:10px;
        border-radius: 20px;
        /*margin-left:16.5%;*/
        right: 10;
    }

    #imgbusinessloader {
        max-width: 25px; position: absolute;
        display:none; 
        padding:10px;
        border-radius: 20px;
        /*margin-left:16.5%;*/
        right: 5;
        top: 37;
    }

    .imglocationloader{
        max-width: 20px;
        position: absolute;
        display: none;
        padding: 13px 0px 0px 0px;
        border-radius: 20px;
        /*margin-left: 16.5%;*/
        right: 10;
    }
    #additemspan{
        font-size: 14pt;
        font-weight: bold;
        vertical-align:middle;
    }
    .styled-select{  border: none; font-family:Roboto Condensed; font-size:20px; display: block; float: none; margin-top: 9px; border:1px solid; color: #6589f8; padding: 8px 20px; }

    .ui-menu .ui-widget .ui-widget-content .ui-corner-bottom ul{
        width:753.5px;
    }
    .inputskudescription_old{
        border-radius: 10px;
        background-color: #dbdbe6 !important;
        /*cursor:not-allowed;*/ 
        /*max-height: 43px;*/
        padding:10px !important;
        max-height: 45px !important;
        /*overflow-y:auto !important;*/
        resize: none  !important;
        margin-bottom: 3px;
        /*white-space: nowrap;*/
        /*font-size: 15px !important;*/
        line-height: 1.4 !important;
    }
    
   
/*
::-webkit-scrollbar-track{
	background-color: #e2e2e2;
}

::-webkit-scrollbar{
	height: 6px !important;
	background-color: #CBCBCB;
        cursor:pointer;
}

::-webkit-scrollbar-thumb{
	border-radius: 10px;
	background-color: #545454;
}*/


    .calicon{
        position: absolute;display: block;right:5px; top:48px; cursor:pointer;
        max-width: 28px;
    }.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus{
        color: #4DA9EB;
    }

    #ddShippingCountry-menu li:nth-child(3)
    {
        height: 15px;
        margin-top:-15px;
    }

    .lblsechead{
        font-size: 24px;
        font-style: normal;
        text-align: center;

    }

    ul.search-result {
        list-style: none;
        margin: 0;
        padding: 0;
        max-height: 200px;
        overflow: auto;
    }

    ul.search-result li {
        background-color: #fff;
        color: #333;
        border: 1px solid #fff;
        cursor: pointer;
        padding: 3px 20px;
    }

    ul.search-result li:hover {
        border: 1px solid #cccccc;
        background: #ededed;
        font-weight: normal;
        color: #2b2b2b;
    } 
    .tblskus{
        border-collapse: collapse; 
        border-radius: 10px 10px 0px 0px;
        background-color: white; 
        width:100%;
        margin-bottom: 30px;
        position:relative;
    }
    .tblskus tr:first-child{
        text-align: center;
        background-color:#CBCBCB;
        font-size: 13pt;
    }
    .removeskuitem{
        border-collapse: collapse; 
        padding:0px; 
        max-width: 25px;
        position:absolute;
        top:-13;
        right:-12;
        cursor:pointer;
    } 
    .skusearch option:first-child{
        color:#4DA9EB !important;
    }
    .skusearch option[value=""] {
        color: #4DA9EB;
    }
    .hide{display:none;}
        option {
              color: black;
            } 
           :-moz-placeholder,
::-moz-placeholder {
color: #4DA9EB;
opacity: 1;
} 
.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
             height:260px;
                
}    
.chosen-with-drop {
width:770px !important;
font-size:20px !important;;
}
.chosen-container-single .chosen-single span {
padding: 8px 0px 8px 0px !important;
color: #4DA9EB !important;
font-size:20px !important;
}

.chosen-container-single .chosen-single div b { 
  background-position:0px 14px !important;
  
}
.chosen-container-active.chosen-with-drop .chosen-single div b{
    background-position: -17px 14px !important;
}
.chosen-container .chosen-results {
    font-size: 20px!important;
}
.chosen-container .chosen-results li.active-result {
    padding: 10px 0px 10px 10px !important;
}
</style> 
<?php if (!empty($edit_rid)) { ?>
    <div style="color:white;font-size: 22px;">Sample request id: <?= $edit_formatted_id ?></div>
<?php } ?>
<div id="container"></div>
<form enctype="multipart/form-data" id="project-quotation" action="<?= $form_submit_action ?>" method="post" novalidate="novalidate" name="form1" autocomplete="off">
    <input type="hidden" name="dashboard_type" id="dashboard_type" value="FRONT" />
    <input type="hidden" name="hid_rid" id="hid_rid" value="<?= $edit_rid ?>" />
    <input type="hidden" name="hid_usaid" id="hid_usaid" value="<?= UNITED_STATES_COUNTRY_ID ?>" />
    <input type="hidden" name="hid_selected_country_id" id="hid_selected_country_id" value="<?= $edit_shipping_country ?>" />
    
    <div class="form-text">
<!--    <span class="form-field">
        <p class="contact"><label for="project-category">New/Revision</label></p> 
        <span class="roboto-bold-14">
            
            <input type="radio" name="project-category" value="revision" id="project-category-rev"  onclick="chkbx_change(this.value)" /> Revision
            <input type="radio" name="project-category" value="copy" id="project-copy" class="css-checkbox" onclick="chkbx_change(this.value)" /><label for="project-copy" class="css-label radGroup2" style="margin-left: 0px;"><span class="label-text">COPY</span></label>
            <input type="radio" name="project-category" value="new" checked="checked" id="project-category-new" class="css-checkbox" onclick="chkbx_change(this.value)"  /> <label for="project-category-new" class="css-label radGroup2"><span class="label-text">DESIGN</span></label>  
            <input type="radio" name="project-category" value="both" id="project-both"  class="css-checkbox" onclick="chkbx_change(this.value)" /> <label for="project-both" class="css-label radGroup2"><span class="label-text">BOTH</span></label>
        </span>

        <span id="project-category-error" ></span>  
    </span>-->
        <hr style="margin: 10px 0;"/>


        <span class="roboto-bold-14 design-selector">
            <span>
                <p class="contact lblsechead">Requester Details</p> 

            </span>
        </span>
        <span class="form-field">      
            <span id="cat2-requester">
                <p class="contact" id="requester-drpdwn-p"><label for="requester-drpdwn">Requester Name</label></p> 

                <input type="text" value="<?= $requester_name ?>" readonly="readonly" />
            </span>
        </span>

        <span class="form-field">      
            <span id="cat2-requester">
                <p class="contact" id="requester-drpdwn-p"><label for="requester-drpdwn">Requester Email</label></p> 
                <input type="text" value="<?= $requester_email ?>" readonly="readonly" />
            </span>
        </span>

        <span class="form-field">
            <p class="contact"><label for="project_deparments">Requester Department</label></p> 
            <input type="text" value="<?= $requester_department ?>" readonly="readonly" />
            <?php /*
              <!--<select id="project_deparments" class="styled-select" name="project_deparments" class="required">-->
              <select name="project_deparments[]" id="project_deparments" class="dept-checklist" multiple="multiple" style="width:100%;height: 160px;">
              <!--<option value="" disabled selected>Please select departments</option>-->
              <?php foreach($departments as $dept) { ?>
              <option value="<?=$dept['id']?>" <?php if($_SESSION['requester_dept_id'] == $dept['id']) {?>selected="selected" <?php } ?>  ><?=$dept['d_name']?></option>
              <?php } ?>
              <option value="Other">Other</option>
              </select>
             */ ?>
        </span>    
        <div id="deparment-other-label"></div>

        <span class="roboto-bold-14 design-selector">
            <span>
                <p class="contact"><label for="req_info">Are you submitting this request on behalf of someone else?</label></p> 
                <input type="radio" name="another_info" value="yes" id="yes-requesters" class="css-checkbox show_req"  <?php if ($edit_someone_else == 'yes') echo 'checked=checked'; ?>/> <label for="yes-requesters" class="css-label radGroup2" style="margin-left: 0px;"><span class="label-text">YES</span></label>  
                <input type="radio" name="another_info" value="no" id="no-requesters" class="css-checkbox show_req" <?php if ($edit_someone_else == 'no') echo 'checked=checked'; ?>/><label for="no-requesters" class="css-label radGroup2"><span class="label-text">NO</span></label>  
            </span>
        </span>

        <span class="form-field">  
            <span id="another-requesters" <?php if ($edit_someone_else == 'no') { ?>style='display:none;'<?php } ?>>
                <p class="contact" id="requester-drpdwn-p"><label for="additional-names">Requester’<span style="text-transform: lowercase;" >s </span> Full Name<span class="star-class"> * </span></label> &nbsp;&nbsp;<span class="errors" id="otherRequesterFullNameError"></span><span class="errors" id="otherRequesterselectionError"></span></p> 
                <input type="text" name="additional-names" id="additional-names" placeholder="Please Enter Reqester full Name" onkeypress ="get_requesters()" onpaste="this.onkeypress();" onchange="this.onkeypress();" onblur="this.onkeypress();"  value="<?php echo $edit_requester_other_name; ?>"/>
                <input type="hidden" id="oth-requester" name="oth-requester" value='' />
                <input type="hidden" id="mandate_other_requester" value='0' />
                <label >
                    <div style="padding: 10px 0;"><span style="display:none; color:red; font-size: 15px;" id="allow-add-requester" >Requesters not existing in this list have not been approved for access to this portal. Please contact <a href="mailto:incipiodev@incipio.com" style="color: #fff;">incipiodev@incipio.com</a> along with approval from your manager for any updates to this list.<span class="star-class">*</span><span id="validEmail_error" style="color:red"></span>
        <!--            <input type="radio" name="add_req_info" value="yes" id="yes-add-requesters" class="css-checkbox show_text" onchange="changereqinfo=(this.value)"/> <label for="yes-add-requesters" class="css-label radGroup2" style="margin-left: 0px;"><span class="label-text">YES</span></label>  
                    <input type="radio" name="add_req_info" value="no" id="no-add-requesters" class="css-checkbox show_text"/><label for="no-add-requesters" class="css-label radGroup2"><span class="label-text">NO</span></label>  
                            -->
                    </div>
                    <input  <?php
                    if ($edit_someone_else == 'yes' && !empty($edit_requester_other_email)) {
                        
                    } else {
                        ?>style='display:none;'<?php } ?>type="text" name="requester-other" id="requester-other" placeholder="Please Enter Reqester Email address" value="<?php echo $edit_requester_other_email ?>" />
            </span>
        </span>

        </span>

        <span class="form-field">      
            <span id="cat2-requester">
                <p class="contact" id="requester-drpdwn-p"><label for="additional-cc">ADDITIONAL EMAIL CC’<span style="text-transform: lowercase;" >s </span> <span style="text-transform: lowercase;" >( separate by commas )</span></label></p> 
                <input type="text" name="additional-cc" id="additional-cc"  placeholder="Please enter Additional Email addresses to be included." autocomplete="off" value="<?php echo $edit_additional_cc_emails ?>"/>
                <!--<textarea name="additional-cc" id="additional-cc" placeholder="Please enter proper email addresses for additional parties \n that need to be included on the project alerts." ></textarea>-->
            </span>
        </span>
        <hr style="margin: 20px 0;"/>


        <span class="roboto-bold-14 design-selector">
            <span>
                <p class="contact lblsechead"> Sample Reasoning</p> 

            </span>
        </span>

        <span class="form-field">
            <p class="contact"><label for="requestType">Sample Request Type <span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="ddRequestTypeError"></span></p> 
            <!--<select id="brand" class="required styled-select" name="brand" >-->
            <select name="ddRequestType" id="ddRequestType" class="styled-select">
                <option value="" style="display:none;" disabled selected>Select Type</option>
                <option value="media/seeding" <?php if ($edit_request_type == 'media/seeding') echo 'selected'; ?> >Media/Seeding</option>
                <option value="sales event" <?php if ($edit_request_type == 'sales event') echo 'selected'; ?> >Sales event</option>
                <option value="customer meeting" <?php if ($edit_request_type == 'customer meeting') echo 'selected'; ?> >Customer meeting</option>
                <option value="giveaway/gift" <?php if ($edit_request_type == 'giveaway/gift') echo 'selected'; ?> >Giveaway/Gift</option>
                <option value="donation" <?php if ($edit_request_type == 'donation') echo 'selected'; ?> >Donation</option>
                <option value="R&D" <?php if ($edit_request_type == 'R&D') echo 'selected'; ?> >R&D</option>
                <option value="marketing" <?php if ($edit_request_type == 'marketing') echo 'selected'; ?> >Marketing</option>
                <option value="visuals" <?php if ($edit_request_type == 'visuals') echo 'selected'; ?> >Visuals</option>
                <!-- <option value="0">Other</option> -->
            </select>  
        </span>
 
        <span class="form-field" id="spanSampleRequestTypeTextDiv"  style="<?php if (empty($edit_request_type)) { ?> display: none;<?php } ?> position: relative;">
            <p class="contact"><label for="textCompanyName" id="labeltextCompanyName"><?= $edit_request_type_label ?></label> <span class="star-class"> *</span>
                &nbsp;<span class="errors form-field-error" id="textCompanyNameError"></span></p>  

            <input type="text" placeholder="<?= $edit_request_type_placeholder ?>" name="textCompanyName" id="textCompanyName" maxlength="200" autocomplete="off"  value='<?= $edit_request_type_dependent_field_value ?>'  <?php if (!empty($edit_request_type_dependent_field_value) && ($edit_request_type == 'media/seeding' || $edit_request_type == 'customer meeting')) { ?> readonly="readonly" style="background-color: rgb(219, 219, 230);" <?php } if ($edit_request_type_dependent_field == 'input') {
                
            } else {
                ?> style="display: none;"<?php } ?> />
            <a id="clear_business"  <?php if (!empty($edit_request_type_dependent_field_value) && ($edit_request_type == 'media/seeding' || $edit_request_type == 'customer meeting')) { } else { ?> style="display: none;" <?php }  ?> class="skusearchimg" >
                <img style="border-collapse: collapse; top: auto; bottom: 3px;" src="<?php echo SITE_URL; ?>public/images/delete_request_form.png">
            </a>
            <a id="search_business" class="skusearchimg" <?php if (empty($edit_request_type_dependent_field_value)) { } else {?> style="display: none;" <?php }  ?>>
                <img style="border-collapse: collapse; top: 40px;" src="<?php echo SITE_URL; ?>public/images/search-image.png">
            </a>
  
            <textarea class="apply-jquery-validation" name="textareaRequestTypeDescription" maxlength="200" id="textareaRequestTypeDescription" placeholder="<?= $edit_request_type_placeholder ?>" maxlength="5000" autocomplete="off"  <?php if ($edit_request_type_dependent_field == 'textarea') {
                          
                      } else { 
                        ?> style="display: none;"<?php } ?> ><?= $edit_request_type_dependent_field_value ?></textarea>
            <input type="hidden" name="netsuite_business_id" id="netsuite_business_id" value="<?php
                   if (isset($edit_request_data[0]['netsuite_business_id'])) {
                       echo $edit_request_data[0]['netsuite_business_id'];
                   }
                    ?>" />
            <div id="business-search-result"></div>
        <input type="hidden" id="mandate_company_customer_selection" value='<?=$company_customer_selected?>' />
        </span>




        <?php /* ?>
          <span class="form-field">
          <p class="contact"><label for="ddAccountBilled">Which account should this be billed to?<span class="star-class"> *</span></label>
          &nbsp;&nbsp;<span class="errors" id="ddAccountBilledError"></span></p>
          <select id="ddAccountBilled" class="styled-select" name="ddAccountBilled">
          <option value='' style="display:none;" disabled selected>Select account</option>
          <option value='corporate'  <?php if ($edit_billing_account == 'corporate') echo 'selected'; ?>>Corporate</option>
          <option value='marketing' <?php if ($edit_billing_account == 'marketing') echo 'selected'; ?>>Marketing</option>
          <option value='product' <?php if ($edit_billing_account == 'product') echo 'selected'; ?>>Product</option>
          <option value='public relations' <?php if ($edit_billing_account == 'public relations') echo 'selected'; ?>>Public Relations</option>
          <option value='sales' <?php if ($edit_billing_account == 'sales') echo 'selected'; ?>>Sales</option>
          <!-- <option value="0">Other</option> -->
          </select>
          </span>



          <span class="form-field" >
          <p class="contact"><label for="ddSamplePurpose">Sample purpose<span class="star-class"> *</span></label>
          &nbsp;&nbsp;<span class="errors" id="ddSamplePurposeError"></span></p>
          <select id="ddSamplePurpose" class="styled-select" name="ddSamplePurpose">
          <option value='' style="display:none;" disabled selected>Why do you need this?</option>
          <option value='promotion' <?php if ($edit_purpose == 'promotion') echo 'selected'; ?>>Promotion</option>
          <option value='seeding' <?php if ($edit_purpose == 'seeding') echo 'selected'; ?> >Seeding</option>
          <option value='tradeshow samples' <?php if ($edit_purpose == 'tradeshow samples') echo 'selected'; ?> >Tradeshow Samples</option>
          <!-- <option value="0">Other</option> -->
          </select>
          </span>

          <span class="form-field">
          <p class="contact"><label for="textCustomerOrEventName"> Customer (Event) Name <span class="star-class"> *</span></label>
          &nbsp;&nbsp;<span class="errors" id="textCustomerOrEventNameError"></span></p>

          <input type="text" placeholder="Customer (Event) name" name="textCustomerOrEventName" id="textCustomerOrEventName" maxlength="100" autocomplete="off" value="<?= $edit_customer_event_name ?>" />


          </span>
          <span class="form-field">
          <p class="contact"><label for="returnSample"> Will you return these samples?</label></p>
          <span class="roboto-bold-14">
          <input type="radio" name="returnSample" id="returnSample-yes" class="css-checkbox" value="yes" onclick="statusToggle(this.value)" <?php if ($edit_is_sample_returnable == 'yes') echo 'checked=checked'; ?>/><label for="returnSample-yes" class="css-label radGroup2" style="margin-left: 0px;"><span class="label-text">Yes</span></label>
          <input type="radio" name="returnSample" id="returnSample-no" class="css-checkbox" value="no"  <?php if ($edit_is_sample_returnable == 'no' || $edit_is_sample_returnable == NULL) echo 'checked=checked'; ?> onclick="statusToggle(this.value)"/><label for="returnSample-no" class="css-label radGroup2"><span class="label-text">No</span></label>
          </span>
          <span id="returnSampleError" ></span>
          </span>


          <?php */ ?>
        <hr style="margin: 20px 0;"/>


        <span class="roboto-bold-14 design-selector">
            <span>
                <p class="contact lblsechead"> Shipping Info</p>
            </span>
        </span>
        
        <span class="form-field" >
            <p class="contact"><label for="shipping_contact_first_name">First Name</label> <span class="star-class"> *</span>
                &nbsp;&nbsp;<span class="errors form-field-error"></span></p>  
            <input class="apply-jquery-validation" type="text" placeholder="Enter First Name" name="shipping_contact_first_name" id="shipping_contact_first_name" maxlength="100" autocomplete="off" value="<?php if(isset($edit_request_data[0]['shipping_contact_first_name'])) { echo $edit_request_data[0]['shipping_contact_first_name']; }?>">
        </span>
        
        <span class="form-field" >
            <p class="contact"><label for="shipping_contact_last_name">Last Name</label> <span class="star-class"> *</span>
                &nbsp;&nbsp;<span class="errors form-field-error"></span></p>  
            <input class="apply-jquery-validation" type="text" placeholder="Enter Last Name" name="shipping_contact_last_name" id="shipping_contact_last_name" maxlength="100" autocomplete="off" value="<?php if(isset($edit_request_data[0]['shipping_contact_last_name'])) { echo $edit_request_data[0]['shipping_contact_last_name']; }?>">
        </span>
        
        <span class="form-field" >
            <p class="contact"><label for="shipping_contact_email_id">Email Id</label> <span class="star-class"> *</span>
                &nbsp;&nbsp;<span class="errors form-field-error"></span></p>  
            <input class="apply-jquery-validation" type="text" placeholder="Enter Email" name="shipping_contact_email_id" id="shipping_contact_email_id" maxlength="100" autocomplete="off" value="<?php if(isset($edit_request_data[0]['shipping_contact_email_id'])) { echo $edit_request_data[0]['shipping_contact_email_id']; }?>">
        </span>
       
        <span class="form-field">               
            <p class="contact"><label for="ddShippingCountry">Country<span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="ddShippingCountryError"></span></p>  
            <select id="ddShippingCountry" class="search-dropdown" name="ddShippingCountry" onchange="validateState(this); setMinimumDeliveryDate();">
                <option value='' data-zip_code="<?='no'?>" style="display:none;" disabled selected>Select Country</option>
                <option value='<?php echo UNITED_STATES_COUNTRY_ID; ?>' data-zip_code="<?='yes'?>" <?php if ($edit_shipping_country == UNITED_STATES_COUNTRY_ID) echo 'selected'; ?> >United States</option>

                <?php
                foreach ($countries as $country) {
                    if ($country['id'] != UNITED_STATES_COUNTRY_ID) {
                        ?>
                        <option value="<?= $country['id'] ?>"  data-zip_code="<?=$country['zip_code']?>" <?php if ($edit_shipping_country == $country['id']) echo 'selected'; ?>><?= ucfirst($country['country_name']) ?></option> 
        <?php
    }
}
?>
            </select>
        </span>

        <span class="form-field" style="display:none;"> 
            <p class="contact"><label for="textareaShippingAddress">Shipping Address<span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="textareaShippingAddressError"></span></p> 
            <!--<input type="text" name="project_name" id="project_name" placeholder="Enter a name for your project" class="required txtfield"  />-->
            <textarea maxlength="200" id="textareaShippingAddress" placeholder="Enter full shipping Address" maxlength="1000" autocomplete="off"><?= $edit_shipping_address ?></textarea>
        </span>


        <span class="form-field" >
            <p class="contact"><label for="textStreet1" id="labeltextStreet1">Address Street 1</label> <span class="star-class"> *</span>
                &nbsp;&nbsp;<span class="errors form-field-error" id="textStreet1Error"></span></p>  

            <input type="text"  class="apply-jquery-validation"  placeholder="Enter Address Street 1" name="textStreet1" id="textStreet1" maxlength="200" autocomplete="off"  value="<?= $edit_ship_address_street1 ?>">
        </span>
        <span class="form-field" >
            <p class="contact"><label for="textStreet2" id="labeltextStreet2">Address Street 2</label> 
                &nbsp;&nbsp;<span class="errors" id="textStreet2Error"></span></p>  

            <input type="text" placeholder="Enter Address Street 2" name="textStreet2" id="textStreet2" maxlength="200" autocomplete="off"  value="<?= $edit_ship_address_street2 ?>">
        </span>
        <span class="form-field" >
            <p class="contact"><label for="textCity" id="labeltextCity">City</label> <span class="star-class"> *</span>
                &nbsp;&nbsp;<span class="errors form-field-error" id="textCityError"></span></p>  

            <input type="text" placeholder="Enter City" class="apply-jquery-validation" name="textCity" id="textCity" maxlength="200" autocomplete="off"  value="<?= $edit_ship_address_city ?>">
        </span>
        <span class="form-field" >
            <p class="contact"><label for="textState" id="labeltextCity">State</label> <span class="star-class"> *</span>
                &nbsp;&nbsp;<span class="errors form-field-error" id="textStateError"></span></p>  
            
            <input type="text" class="apply-jquery-validation" placeholder="Enter State" name="textState" id="textState" maxlength="200" autocomplete="off"  value="<?= $edit_ship_address_state ?>" <?php if ($edit_shipping_country == UNITED_STATES_COUNTRY_ID){ ?>style="display:none;" <?php } ?> >
        
            <select name="ddState" id="ddState" class="search-dropdown"  <?php if ($edit_shipping_country == UNITED_STATES_COUNTRY_ID){} else { ?> style="display:none;" <?php } ?> onchange="setMinimumDeliveryDate();" >
            <option  value='' style="display:none;" disabled selected>Please select state</option>
            <?php foreach ($usStateNames as $state => $stateDetails) { ?>
                <option value="<?=$state?>" <?php if(strtolower($state)==$edit_ship_address_state){ echo "selected=selected";}?>><?=$state?></option>
            <?php } ?>
	</select>
        </span>
        <span class="form-field" > 
            <p class="contact"><label for="textZipCode" id="labeltextCity">ZIP Code</label> <span class="star-class hide" id="spanStarZip"> *</span>
                &nbsp;&nbsp;<span class="errors" id="textZipCodeError"></span></p>  

            <input type="text" placeholder="Enter ZIP Code" name="textZipCode" id="textZipCode" maxlength="10" autocomplete="off"  value="<?= $edit_ship_address_zipcode ?>">
        </span>






        <span class="form-field">
            <p class="contact"><label for="textPhone"> Phone # (INTL Requests) <span class="star-class hide" id="spanStarPhone"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="textPhoneError"></span></p>  

            <input type="text" placeholder="+Area code e.g. +1-###-###-####" name="textPhone" id="textPhone" value="<?= $edit_phone ?>"  maxlength="20" autocomplete="off"  />

        </span>

        <?php /* These fields are no more required
        <span class="form-field" style="position:relative;display:none;">
            <p class="contact"><label for="textStartDate"> Start Date <span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="textStartDateError"></span></p>  
            <input type="hidden" name="hiddenStartDate" value="EOD" />
            <input type="text" style="color: transparent; text-shadow: 0 0 0 #4DA9EB;" placeholder="Select start date" name="textStartDate" readonly="true" id="textStartDate" class="textStartDate" value="<?= $edit_start_date ?>" style="position:relative;" />
            <img class="calicon" src="<?php echo SITE_PUBLIC_URL; ?>images/calendar.png" onclick="" />

        </span>
        <span class="form-field" style="position:relative;">
            <p class="contact"><label for="textShipByDate"> Ship By Date <span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="textShipByDateError"></span></p>  
            <input type="hidden" name="hiddenShipByDate" value="EOD" />
            <input type="text" style="color: transparent; text-shadow: 0 0 0 #4DA9EB;" placeholder="Select ship by date" name="textShipByDate" readonly="true" id="textShipByDate" class="textShipByDate" value="<?= $edit_shipping_date ?>" style="position:relative;" />
            <img class="calicon" src="<?php echo SITE_PUBLIC_URL; ?>images/calendar.png" onclick="" />

        </span>
         */?>
       
        
        <span class="form-field" id="delivery_date_field"  style="position:relative; <?php if(empty($edit_requested_delivery_date)) { ?> display: none; <?php } ?>">
            <p class="contact"><label for="textRequestedDeliveryDate"> Requested Delivery Date <span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors form-field-error" id="duedate_datetime_error"></span></p>  
            <input type="hidden" name="hiddenRequestedDeliveryDate" value="EOD" />
            <input type="text" placeholder="Select delivery date to customer (MABD)" name="textRequestedDeliveryDate" class="textRequestedDeliveryDate apply-jquery-validation"  readonly="true" id="textRequestedDeliveryDate" value="<?= $edit_requested_delivery_date ?>"  style="position:relative;"/>
            <img class="calicon" src="<?php echo SITE_PUBLIC_URL; ?>images/calendar.png" />

            <p id="deliver_date_disclaimer_text" style="color: red;font-weight: normal;font-size: 16px;">
                DISCLAIMER: All sample requests require at least 48hrs to process. Same day requests need to be submitted by 2pm PST.  Please reach out to <a href="mailto:sampleescalation@incipio.com" style="color: #fff;">sampleescalation@incipio.com</a> for any urgent requests/escalations.
            </p>
            
        </span>

        <span class="form-field">
            <p class="contact"><label for="shipChargesToCustomer"> Bill Shipping Charges to Customer's Account? (For expedited requests)<span class="star-class"> *</span></label></p> 
            <span class="roboto-bold-14"> 
                <input type="radio" name="shipChargesToCustomer" id="shipChargesToCustomer-yes" class="css-checkbox" value="yes"  <?php if ($edit_ship_charges_to_customer == 'yes') echo 'checked=checked'; ?> /><label for="shipChargesToCustomer-yes" class="css-label radGroup2" style="margin-left: 0px;"><span class="label-text">Yes</span></label>
                <input type="radio" name="shipChargesToCustomer" id="shipChargesToCustomer-no" class="css-checkbox" value="no" <?php if ($edit_ship_charges_to_customer == 'no' || $edit_ship_charges_to_customer == NULL) echo 'checked=checked'; ?>/><label for="shipChargesToCustomer-no" class="css-label radGroup2"><span class="label-text">No</span></label>          
            </span> 
            <span id="shipChargesToCustomerError" ></span>
        </span>
        <span class="form-field" id="spanCustShipChargesAccountDiv" <?php if ($edit_ship_charges_to_customer == 'yes') {
            
        } else {
            ?> style="display: none;"<?php } ?>>
            <p class="contact"><label for="shipping_carrier">Carrier <span class="star-class"> *</span></label>&nbsp;&nbsp;<span class="errors" id="shipping_carrier_error"></span></p> 
            <select id="shipping_carrier" name="shipping_carrier" class="styled-select">
                <option value="" style="display:none;" disabled selected>Select Carrier</option>
<?php foreach (Utility::$shippingCarriers as $carrierOptionKey => $carrierOption) { ?>
                    <option value="<?= $carrierOptionKey ?>" <?php if ($edit_shipping_carrier == $carrierOptionKey) echo 'selected'; ?> ><?= $carrierOption ?></option>
<?php } ?>
            </select>

            <p class="contact"><label for="textCustShipChargesAccount"> Customer's Shipping Account #<span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="textCustShipChargesAccountError"></span></p>  

            <input type="text" placeholder="e.g. FedEx 345678 " name="textCustShipChargesAccount" id="textCustShipChargesAccount" maxlength="100" autocomplete="off" value="<?= $edit_customer_shipping_charges_account ?>" />


        </span>

        <hr style="margin: 15px 0;"/>





        <input type="hidden" name="ddBrand" id="ddBrand" value="4" >
        <?php /* ?>
          <span class="form-field">
          <p class="contact"><label for="brand">Brand <span class="star-class"> *</span></label>
          &nbsp;&nbsp;<span class="errors" id="ddBrandError"></span></p>
          <!--<select id="brand" class="required styled-select" name="brand" >-->
          <select name="ddBrand" id="ddBrand" class="styled-select">
          <option value="" style="display:none;" disabled selected>Select Brand</option>
          <?php foreach ($brands as $brand) { ?>
          <option value="<?= $brand['id'] ?>" <?php if ($edit_brand == $brand['id']) echo 'selected'; ?> ><?= ucfirst($brand['brand_name']) ?></option>
          <?php } ?>
          <!-- <option value="0">Other</option> -->
          </select>
          </span>

          <div id="brand_other_checklist_temp" class="default-none">
          <div id="brand_other_checklist_text" class="ui-dropdownchecklist-item ui-state-default ui-state-hover" style="white-space: nowrap;">
          <textarea id="brand_other_text" maxlength="240" class = "ui-dropdownchecklist-text" name="brand_other_text" placeholder="Please enter not listed Brand" class="txtfield"></textarea>
          </div>
          </div>

          <div id="brand-other-label"></div>

          <?php */ ?>
        <span class="form-field">
            <p class="contact"><label for="textSku_1">Items<span class="star-class"> *</span></label>
                &nbsp;&nbsp;<span class="errors" id="textSku_1_error"></span></p>  
            <div id='divskutables'> 

<?php
if (!empty($edit_skudata)) {
    $s = 1;
    foreach ($edit_skudata as $e => $sdata) {
//       echo "<pre>";print_r($sdata); exit; 
        ?> 
                        <table cellspacing="0" id='tblSkus_<?= $s ?>' class='tblskus'>
                            <tr>
                                <th colspan="200" style="border-right: 10px; padding:10px;">ITEM-<?= $s ?></th>
                                <th style="float:right;"><a name="btnSkuDelete[]"  style=" padding:5px;" id="btnSkuDelete_<?= $s ?>" onclick ="delete_sku($(this)); return false;" >
                                        <img class="removeskuitem" src="<?= SITE_PUBLIC_URL ?>images/close_red.png"></a></th>

                            </tr>  <tr class="sku-field">

                                <td>
                                    <img class="imgskuloader" src="<?= SITE_URL ?>public/images/ajax-loader-circle.gif"/>

                                    <input type="text" onkeypress="return event.keyCode != 13;" placeholder="Search" class="inputskusearch" name="existing_items[<?= $sdata['request_sku_id'] ?>][sku]" id="textSku_<?= $s ?>"  value="<?= $sdata['sku_name'] ?>" style="padding-right:30px;" maxlength="15" autocomplete="off" readonly/>
                                    <a id="btnSkuSearch_<?= $s ?>" class="skusearchimg" onclick="makeskueditable(this.id);" >
                                        <!-- onclick="get_skus(this); return false;" -->
                                        <img style="border-collapse: collapse;" src="<?php echo SITE_URL; ?>public/images/delete_request_form.png">
                                    </a>

                                    <ul id="myUL_<?= $s ?>" class="myul" ></ul>
                                </td>
                                <td>
                                    <img class="imglocationloader" src="<?= SITE_URL ?>public/images/ajax-loader-circle.gif"/>
                                    <select class="skusearch" name="existing_items[<?= $sdata['request_sku_id'] ?>][location]"  id="textSkuLocation_<?= $s ?>" onchange="getQtyAvailable(this);" style="color:black;" >
                                        <option value="" >Location & Quantity</option>
                                        <option value="<?= $sdata['location_name'] . "--" . $sdata['sku_location_id_fk'] . "--" . ($sdata['item_cost'] / $sdata['quantity_requested']) ?>" selected><?= $sdata['location_name'] . " (Qty: " . $sdata['sku_location_id_fk'] . ")"; ?></option>

                                    </select>
                                </td>
                                <td <?php if ($s == 1) {
            
        } else { ?> colspan="2"<?php } ?>>
                                    <input type="text" maxlength="10" class="inputqtyrequested numerics_only"  placeholder="Quantity Requested"  autocomplete="off" name="existing_items[<?= $sdata['request_sku_id'] ?>][quantity]" id="textSkuQtyRequested_<?= $s ?>" value="<?= $sdata['quantity_requested'] ?>"  />

                                </td>

                            </tr>

                            <tr class="sku-other-fields">
                                <td>
                                    <input type="text" maxlength="100" autocomplete="off"  onkeypress="return event.keyCode != 13;" name="existing_items[<?= $sdata['request_sku_id'] ?>][brand]" id="textSkuBrand_<?= $s ?>"  value="<?= $sdata['brand'] ?>" placeholder="Brand" readonly="readonly" class="inputbrandrequested" />
                                </td>
                                <td <?php if ($s == 1) { ?> colspan="2" <?php } else { ?> colspan="3"<?php } ?>>
                                    <div  class="inputskudescription"  name="existing_items[<?= $sdata['request_sku_id'] ?>][description]" id="textSkuDescription_<?= $s ?>"><?= $sdata['description'] ?></div>
                                </td>
                            </tr>

                        </table>

        <?php
        $s++;
    }
} else {
    ?>

                    <table cellspacing="0" id='tblSkus_1' class='tblskus'>
                        <tr>
                            <th colspan="200" style="border-right: 10px;padding:10px;">ITEM-1</th>
                            <th style="float:right;"><a name="btnSkuDelete[]"  style=" padding:5px;" id="btnSkuDelete_1" onclick ="delete_sku($(this)); return false;" >
                                    <img class="removeskuitem" src="<?= SITE_PUBLIC_URL ?>images/close_red.png"></a></th>



                        </tr>  <tr class="sku-field">

                            <td>
                                <img class="imgskuloader" src="<?= SITE_URL ?>public/images/ajax-loader-circle.gif"/>

                                <input type="text" onkeypress=" $(this).val($.trim($(this).val()));" placeholder="Search" class="inputskusearch" name="textSku[]" id="textSku_1"  value=""  style="padding-right:30px;" maxlength="30" autocomplete="off" />
                                <a id="btnSkuSearch_1" class="skusearchimg" style="display:none;" onclick="makeskueditable(this.id);" >
                                    <!-- onclick="get_skus(this); return false;" -->
                                    <img style="border-collapse: collapse;" src="<?php echo SITE_URL; ?>public/images/delete_request_form.png">
                                </a>

                                <ul id="myUL_1" class="myul" ></ul>
                            </td>
                            <td>
                                <img class="imglocationloader" src="<?= SITE_URL ?>public/images/ajax-loader-circle.gif"/>
                                <select class="skusearch" name="textSkuLocation[]"  id="textSkuLocation_1" onchange="getQtyAvailable(this);" style=""  >
                                    <option value="" >Location & Quantity </option>

                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text" maxlength="10" class="inputqtyrequested numerics_only" onblur="getQtyAvailable(this);" autocomplete="off" name="textSkuQtyRequested[]" id="textSkuQtyRequested_1" value="" placeholder="Quantity Requested" />
                            </td>

                        </tr>

                        <tr class="sku-other-fields">
                            <td >
                                <input type="text" maxlength="100" autocomplete="off"  onkeypress="return event.keyCode != 13;" name="textSkuBrand[]" id="textSkuBrand_1" value="" onkeyup="validateSKUs();" placeholder="Brand" readonly="readonly" class="inputbrandrequested" />
                            </td>
                            <td colspan="3">
                                <div class="inputskudescription" autocomplete="off" name="textSkuDescription[]" id="textSkuDescription_1"></div>
                            </td>
                        </tr>

                    </table>

<?php } ?>
            </div> 

            <input type="hidden" id="hiddenSkuRowCount" name="hiddenSkuRowCount" value="<?= $sku_count ?>">
            <div style=" background-color:#CBCBCB;font-size: 13pt;margin-top: -30px;color: black; text-align: center;" id="trAddItem_1">
                <div  style="border-right: 10px;padding:5px; text-align:center;">
                    <div class="btnAddItem" id='btnAddItem_1' value=' Add Item'  onClick='AddSkuItem(this.id); return false;'><img src="<?php echo SITE_PUBLIC_URL; ?>images/Add-icon_2.png"><span id="additemspan">&nbsp;Add Item</span ></div>
                </div>
            </div>

        </span>
        <hr style="margin: 20px 0;"/>


        <span class="roboto-bold-14 design-selector">
            <span>
                <p class="contact lblsechead">Additional</p> 

            </span>
        </span>
        <span class="form-field">
            <p class="contact"><label for="textareaSpecialInstructions">Special Preparation Instructions</label>
                &nbsp;&nbsp;<span class="errors" id="textareaSpecialInstructionsError"></span></p> 
            <!--<input type="text" name="project_name" id="project_name" placeholder="Enter a name for your project" class="required txtfield"  />-->
            <textarea name="textareaSpecialInstructions" id="textareaSpecialInstructions" placeholder="e.g. Sample Box, Tissue Paper" autocomplete="off" maxlength="300"><?= $edit_special_preparation_instructions ?></textarea>
        </span>


        <input type="hidden" id="hiddenUploadsCount" name="hiddenUploadsCount" value="<?= $uploads_count ?>">



        <span class="form-field" style="margin-top:28px;">       
            <p class="contact"><label for="">File attachments</label></p> 
            <div class="image-upload" id="image-upload">
                <span id="file_labels_div"> 


                    <div class="div-file" id="div-file-1">
                        <label for="input-file-1" style="cursor: pointer;">
                            <img style="vertical-align:middle; margin-right: 15px;" id="fileupload-attachments" src="<?= SITE_PUBLIC_URL ?>images/plus_icon.png" /> 
<?php // if($uploads_count!=0) echo $uploads_count;    ?>FILE ATTACHMENTS UP TO 100MB 
                        </label>

                        <input id="input-file-1" name="projectfiles[]" inc="1"  style="cursor: pointer; visibility: hidden;" type="file" onchange="getFileName(this);" />

                    </div>

                </span>
                <div class="all-filenames-span" id="all-filenames">

                </div>

            </div>
        </span>              





                    <?php if (!empty($file_attachments)) { ?>
            <span class="form-field" style="margin-top:28px;" id="previousfilesdiv">       
                <p class="contact"><label for="">Previous Files uploaded</label></p> 
                <div class="image-upload" id="previousimageupload">



                    <div class="all-filenames-span" id="previous-all-filenames">
    <?php
    $f = 1;

    foreach ($file_attachments as $file) {
        if (!empty($file)) {
            ?>

                                <div class="previoussinglefile" id="previoussinglefile-<?= $f ?>">
                                    <a target="_blank" href="<?= $download_link . base64_encode($file); ?>" style=" text-decoration:none; font-size: 15px; border-radius: 3px;padding: 2px 2px;"><img src="<?php echo SITE_URL; ?>public/images/download.png" style="margin-bottom: -4px; max-width: 15px;"/></a>
                                    <img id="previousclosebtn-<?= $f ?>"  src="<?= SITE_URL ?>public/images/close_icon@2x.png" style="cursor:pointer;/*display:none;*/vertical-align: middle;padding-left: 12px; margin-right: 18px; max-width: 16px;" onclick=previousdeletefile("<?= $f ?>") /><span class="spanfilename"><?= $file ?></span>&nbsp;


                                    <input id="previousinputfile-<?= $f ?>" name="existing_projectfiles[]" value="<?= $file ?>"  style="cursor: pointer; display: none;" type="text"/>

                                </div>


                    <?PHP
                    $f++;
                }
            }
            ?> 
                    </div>

                </div>
            </span>   
<?PHP } ?>





        <span class="form-field">
            <p class="contact"><label for="bStockAcceptable"> Is B-Stock Acceptable?</label></p> 
            <span class="roboto-bold-14"> 
                <input type="radio" name="bStockAcceptable" id="bStockAcceptable-yes" class="css-checkbox" value="yes" onclick="statusToggle(this.value)"  <?php if ($edit_b_stock_acceptable == 'yes') echo 'checked=checked'; ?> /><label for="bStockAcceptable-yes" class="css-label radGroup2" style="margin-left: 0px;"><span class="label-text">Yes</span></label>
                <input type="radio" name="bStockAcceptable" id="bStockAcceptable-no" class="css-checkbox" value="no" onclick="statusToggle(this.value)"  <?php if ($edit_b_stock_acceptable == 'no' || $edit_b_stock_acceptable == NULL) echo 'checked=checked'; ?>/><label for="bStockAcceptable-no" class="css-label radGroup2"><span class="label-text">No</span></label>          
            </span> 
            <span id="bStockAcceptableError" ></span>
        </span>

        <span class="form-field" style="padding-top: 30px; position: relative;">
            <input id="submit_button" type="submit" value="<?= $submit_text ?>">
            <img id="validation_loader" style="width: 50px;left: 200px; position: absolute;display:none; " src="<?= SITE_PUBLIC_URL ?>images/ajax_loader_front.gif"/>
        </span>
    </div>
</form>

<script type="text/javascript">

    $(document).ready(function () {
//    var a = $.parseJSON('<?= json_encode($emails); ?>');
//    console.log(a);
//    $('#another-requesters').hide();
    $('#yes-requesters').click(function () {
    $('#another-requesters').css('width', '770');
//    $("#additional-names").attr('required', true);
//    $('#requester-other').attr('required', true);
    $('#another-requesters').show('fast');
    });
    $('#no-requesters').click(function () {
    $('#another-requesters').hide();
    $("#additional-names").val('');
    $("#requester-other").hide();
    $("#allow-add-requester").hide();
    $("#requester-other").val('');
//    $("#additional-names").attr('required', false);
//    $('#requester-other').attr('required', false);
    $("#mandate_other_requester").val(0);
    });
    $("#requester-other").on('blur', function () {

    var email = $("#requester-other").val();
    //alert(email);

    if (email != 0)
    {
//                alert('sucess');
    if (isValidEmailAddress(email))
    {
    $("#validEmail_error").html('');
    return true;
    } else {
//                     alert('Please enter valid Email Id.');
    $("#validEmail_error").html('Please enter valid Email Id.');
    $("#requester-other").val('');
    $("#requester-other").focus();
//                     $("#requester-other").focus();
    return false;
    }
    } else {
//                alert('fail');

    }

    });
    var REGEX_EMAIL = '([a-zA-Z0-9]{1,})((@[a-zA-Z]{2,})[\\\.]([a-zA-Z]{2}|[a-zA-Z]{3}))';
    $('#additional-cc').selectize({
                                    plugins: ['remove_button'],
                                    persist: false,
                                    maxItems: null,
                                    valueField: 'email',
                                    labelField: 'name',
                                    searchField: ['name', 'email'],
                                    options: $.parseJSON('<?= json_encode($emails); ?>'),
                                    optgroups: [
                                        {value: 'emailcontent', label: 'CONTACTS AND RECENT ADDRESSES '},
                                    ],
                                    optgroupField: 'class',
                                    render: {
                                        optgroup_header: function (data, escape) {
                                            return '<div class="optgroup-header">' + escape(data.label) + '</div>';
                                        },
                                        item: function (item, escape) {
                                            //			    return '<div>' +
                                            //				    (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
                                            //				    (item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
                                            //			    '</div>';
                                            var caption = item.name ? item.name : item.email;
                                            return '<div>' +
                                                    (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                                                    '</div>';
                                        },
                                        option: function (item, escape) {
                                            var label = item.name || item.email;
                                            var caption = item.name ? item.email : null;
                                            return '<div>' +
                                                    '<span class="label">' + escape(label) + '</span>' +
                                                    (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                                                    '</div>';
                                        }
                                    },
                                    createFilter: function (input) {
                                        var match, regex;

                                        // email@address.com
                                        regex = new RegExp('^' + REGEX_EMAIL + '$', 'i');
                                        match = input.match(regex);
                                        if (match)
                                            return !this.options.hasOwnProperty(match[0]);

                                        // name <email@address.com>
                                        regex = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
                                        match = input.match(regex);
                                        if (match)
                                            return !this.options.hasOwnProperty(match[2]);

                                        return false;
                                    },
                                    create: function (input) {
                                        if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
                                            return {email: input};
                                        }
                                        var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
                                        if (match) {
                                            return {
                                                email: match[2],
                                                name: $.trim(match[1])
                                            };
                                        }
                                        alert('Invalid email address.');
                                        return false;
                                    }
                                });
    });
</script>
