<?php include_once 'views/front/headerdashboard.php'; ?>
<script type="text/javascript" src="<?= SITE_URL ?>views/js/dropdownchecklist/ui.dropdownchecklist.js"></script>
<style>
    .searchdate{
        float: left;
        /*font-family: 'Roboto Condensed'*/
    }
    .calendar {
        background-color: #eee;
        border: none;
        border-radius: 0px;
        width: 19em;
    }
    .daterangepicker{
        display: none;
        left: 180px !important;
        /*    right: auto;
            top: 192.25px;*/
        /*width: 750px;*/
        background-color: #eee;
        font-family: "Roboto Condensed";
    }

    .daterangepicker.show-calendar {
        width: 730px;
    }

    .reportrange{
        background: #fff; 
        cursor: pointer; 
        float: left !important; 
        font-family: "Roboto Condensed";
        margin: 0px 10px; 
        padding: 2px; 
        border: 1px solid #E3E2E2; 
        width: 200px;
        border-radius: 4px;
    }
    .calendar-table {
        font-family: "Roboto Condensed";
        font-size: 18px;
    }
    .daterangepicker .input-mini {
        width: 86%;
    }
    .glyphicon-chevron-left::before {
        content: "<";
        font-style: normal;
    }
    .glyphicon-chevron-right::before {
        content: ">";
        font-style: normal;
    }
    .daterangepicker.opensleft:before {
        left: 50px !important; 
        right: auto;
    }

    .range_inputs .applyBtn, .range_inputs .cancelBtn {
        padding: 3px 10px;
    } 
    table.tablesorter tbody .request-rejected td {
        background-color: #ffa07a;
        /*color: #fff;*/
    }

    table.tablesorter tbody .request-rejected .ui-dropdownchecklist-selector{
        color: #fff;
    }

    .header{
        text-transform: none;
        top: 0px;
        font-family: arial;
    }
    .success{
        color: green;
        text-align: center;
    }
    .error{
        text-align: center;
    }
    .ui-widget-header{
        background: #CBCBCB;
    }
    #task_td{
        color:#95989A;
    }
    .search-position {
           z-index: 99 !important;
           position: fixed;
     }
     #globle_search_select-menu{
        height:auto !important;
        /*padding-top: 3px !important;*/
        /*position: fixed;*/
        
    }
     .tablesorter .ui-dropdownchecklist-item{
        text-align: left;
        font-weight: normal !important;
        vertical-align: middle;
    }
    .ui-widget input{
    vertical-align: middle;
    margin-bottom: 6px;
     margin-top: 5px;
    }
    
    .tablesorter .ui-dropdownchecklist-selector {
         padding: 7px 5px !important;
         text-align: left;
         font-weight:bold;
         color:#000 !important;
       
    }
   
    .tablesorter .ui-dropdownchecklist{
         width: 150px !important; 
         font-family: Roboto Condensed !important;
         /*left:auto !important;*/
    }
    .tablesorter .ui-dropdownchecklist-text{
        text-overflow: ellipsis;
    }
    .tablesorter .ui-dropdownchecklist-item label {      
        display: block;
        margin-top: -22px;
        margin-left: 20px;
    }
    table.tablesorter .ui-dropdownchecklist{
        background-color: #fff;
    }
    
     .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
        border: 1px solid #cbcbcb;
    }
 .ui-state-default {
     white-space: normal !important;
 }
 .ui-dropdownchecklist-dropcontainer{
     overflow-x: hidden !important;
 }
 .ui-dropdownchecklist-dropcontainer{
     /*border: 1px solid #cdcdcd !important;*/
     border-top: 1px solid  #cdcdcd !important;
     border-right:  1px solid #cdcdcd !important;
     border-bottom: 1px solid #ffffff !important;
     border-left:   1px solid  #cdcdcd !important;
 }
 .donediv{
     text-align:left;      
     padding-left:7px;
     padding-bottom: 10px;
     background:#fff;
      border-top: 1px solid  #ffffff !important;
     border-right:  1px solid #cdcdcd !important;
     border-bottom: 1px solid #cdcdcd !important;
     border-left:   1px solid  #cdcdcd !important;
 }
 .donebutton{
    background: #000;
    color: #fff;
    border: 1px;
    border-radius: 4px;
    padding: 4px 12px;
    cursor:pointer;
    font-size: 13px !important;
 }
  .tablesorter .ui-widget-header{
        background: #fff !important;
        border:0px !important;
        color:#000 !important;
        text-align:left !important;
        margin-left: 8px !important;
        font-family: Roboto Condensed !important;
    }
     .list-view-filter .ui-dropdownchecklist-item label {       
        display: block;
        margin-top: -22px;
        margin-left: 20px;
    }
        #view_dialog{
    padding: 0px !important;
    }
   .ui-widget-header{
        border: 0px!important;
    }
        #view_dialog form{
        width: 80%;
        margin: auto;
        margin-top: 30px;
    }
    .sort_fields_div .ui-dropdownchecklist-text{
            width: 183px !important;
    }
    .sort_fields_div .ui-dropdownchecklist{
        /*padding-left: 15px !important;*/
    }

</style>
<script>
    $(document).ready(function () {
        $("#messenger").delay(3000).fadeOut(400);
    });
</script>
<div id="list-view" style="padding-top:116px;">

    <div class="messenger" style="text-align: center;">
        <?php if (isset($_SESSION['message'])) { ?>
        <span style="line-height: 24px;" id="messenger"  class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
            <?php unset($_SESSION['message']);
        }
        ?>
    </div>
           


    <!--    <form name="datesearch" id="datesearch">
            Select Date : <input type="text" name="from_duedate" placeholder="From Date" class="duedate_datetime" />
            <input type="text" name="to_duedate" placeholder="To Date" class="duedate_datetime" />
            <input type="button" value="submit" onclick="date_search()">
        </form>-->
    <div style="width: 100%;">
        <table id="tablesorter" class="tablesorter" data-dataurl="front/dashboardrequestfilter">
            <thead>
            <input type="hidden" name="dashboard_type" id="dashboard_type" value="FRONT" />
                <tr id="request_filter">
                    <!--<th>ID</th>-->
                    <th width="3%"> Project ID </th>
    <!--                <th width="5%">Department</th>-->
    <!--                <th width="5%">
                        <select name="department_id" class="data-filter custom-select">
                            <option value="all">Department</option>
                    <?php foreach ($departments as $dept) { ?>
                                    <option value="<?= $dept['id'] ?>"><?= $dept['d_name'] ?></option>
                    <?php } ?>
                        </select>
                    </th>-->

<!--<th>New/Revision</th>-->
                    <?php
                    if (in_array('submit_date', $_SESSION['sort_fields'])) {
                ?>
                    <th class="header" data-sort-by="created_date" style="width:10%;text-align: left;">Submit Date</th>
                    <?php
                    }
                    if (in_array('due_date', $_SESSION['sort_fields'])) {
                    ?>
                    <th class="header" data-sort-by="duedate" style="width:10%;text-align: left;">Due Date</th>
                     <?php
                    }
                    ?>
                    <th width="3%">Project Name</th>
                    <?php
                    if (in_array('brand', $_SESSION['sort_fields'])) {
                    ?>
                    <th width="12%">
                       <select name="brand_id[]" id="brand_multiselect" multiple="multiple" class="brand_multiselect">
                            <!--<option value="all">Brand</option>-->
                            <?php
                            $brandOptions = '';
                            $brandOtherOptions = '';
                            $licBrnads = '';
                            $incpBrands = '';
                            $otherBrands = '';
                            foreach ($brandtype as $brandtypeid) {
                                $selected = '';
                                if (isset($_SESSION['filter']['brand_id']) && !empty($_SESSION['filter']['brand_id'])) {
                                    if (in_array($brandtypeid['id'], $_SESSION['filter']['brand_id'])) {
                                        $selected = "selected=selected";
                                    } else {
                                        $selected = '';
                                    }
                                }
                                if(!(in_array($brandtypeid['brand_name'] , array('incipio', 'incipio group')))){
                                $trimBrandName = trim(str_replace(array('incipio', 'licensing', '-', ), '', strtolower($brandtypeid['brand_name'])));
                                }else{
                                    $trimBrandName = trim($brandtypeid['brand_name']);
                                }
                                if ($brandtypeid['id'] != '0') {
                                    if (strpos(strtolower($brandtypeid['brand_name']), 'incipio') !== false && !(in_array($brandtypeid['brand_name'] , array('incipio', 'incipio group')))) {
                                        if (strpos(strtolower($trimBrandName), 'collaboration') !== false) {
                                        $otherBrands .= '<option value="' . $brandtypeid['id'] . '" ' . $selected . '> ' . ucfirst('Incipio - Collaborations') . '</option>';

                                        }else if (strpos(strtolower($trimBrandName), 'inhouse collections')!== false) {
                                        $otherBrands .= '<option value="' . $brandtypeid['id'] . '" ' . $selected . '> ' . ucfirst('Incipio - Inhouse Collections') . '</option>';
                                        }else{
                                        $otherBrands .= '<option value="' . $brandtypeid['id'] . '" ' . $selected . '> ' . ucfirst($trimBrandName) . '</option>';
                                            
                                        }
                                    } else if (strpos(strtolower($brandtypeid['brand_name']), 'licensing') !== false) {
//                                        $brandOptions .= '<optgroup label="Licensing">';
                                        $licBrnads .= '<option value="' . $brandtypeid['id'] . '" ' . $selected . '> ' . ucfirst($trimBrandName) . '</option>';
                                     } else {
                                         if(strtolower($brandtypeid['brand_name']) == 'co op'){
                                           $brandOtherOptions .= '<option value="' . $brandtypeid['id'] . '" ' . $selected . ' > ' . ucfirst($trimBrandName) . '</option>';  
                                         }else{
                                         $otherBrands .= '<option value="' . $brandtypeid['id'] . '" ' . $selected . '> ' . ucfirst($trimBrandName) . '</option>';
                                         }
                                         
                                         }

                                } else {
                                    $brandOtherOptions .= '<option value="' . $brandtypeid['id'] . '" ' . $selected . ' > ' . ucfirst($trimBrandName) . '</option>';
                                }
                            }
                            $brandOptions .= '<optgroup label="Owned Brands">';
                            $brandOptions .= $otherBrands;
                            $brandOptions .= '</optgroup>';
//                            $brandOptions .= '<optgroup label="Incipio">';
//                            $brandOptions .= $incpBrands;
//                            $brandOptions .= '</optgroup>';
                            $brandOptions .= '<optgroup label="Licensing">';
                            $brandOptions .= $licBrnads;
                            $brandOptions .= '</optgroup>';  
                            $brandOptions .= '<optgroup label="Other Brands">';
                            $brandOptions .= $brandOtherOptions;
                            $brandOptions .= '</optgroup>'; 
                            echo $brandOptions;
                            ?>
                            
                        </select>
                    </th>
                    <?php
                    }
                    if (in_array('project_type', $_SESSION['sort_fields'])) {
                    ?>
                    <th width="12%">
                         <select name="project_id[]" id="Project_multiselect" multiple="multiple" class="">
                            <!--<option value="all">Project Type</option>-->
                            <?php foreach ($projecttype as $projects) { 
                                $selected ='';
                                if(isset($_SESSION['filter']['project_id'])){
                                    if (in_array($projects['id'], $_SESSION['filter']['project_id'])) {
                                     $selected = "selected=selected";
                                     }else{
                                         $selected = '';
                                     }
                                }
                                ?>
                                <option value="<?= $projects['id'] ?>" <?php echo $selected; ?> ><?= $projects['project_type'] ?></option>
                            <?php } ?>
                            <option value="0" <?php if(isset($_SESSION['filter']['project_id'])){ if (in_array(0,  $_SESSION['filter']['project_id'])) { ?>selected="selected" <?php } } ?>  >Other</option>
                        </select>
                    </th>
                  <?php
                    }
                    if (in_array('project_deliverable', $_SESSION['sort_fields'])) {
                    ?>
                    <th width="12%">
                        <select name="project_del_id[]" id="Deliverables_multiselect" multiple="multiple" class="">
                            <!--<option value="all">Project Deliverables</option>-->
                            <?php foreach ($projectdeli as $projectdeliverable) { 
                                $selected ='';
                                if(isset($_SESSION['filter']['project_del_id'])){
                                    if (in_array($projectdeliverable['id'], $_SESSION['filter']['project_del_id'])) {
                                     $selected = "selected=selected";
                                     }else{
                                         $selected = '';
                                     }
                                }
                                ?>
                                <option value="<?= $projectdeliverable['id'] ?>" <?php echo $selected; ?> ><?= $projectdeliverable['deliverables'] ?></option>
                            <?php } ?>
                                <option value="0" <?php if(isset($_SESSION['filter']['project_del_id'])){ if (in_array(0,  $_SESSION['filter']['project_del_id'])) { ?>selected="selected" <?php } } ?> >Other</option>       
                        </select>
                    </th>
                    <?php
                    }
                    if (in_array('project_description', $_SESSION['sort_fields'])) {
                    ?>
                    <th><div style="width: 120px;">Project Description</div></th>
                    <?php
                    }
                    ?>
                    <th width="3%"> 
                       <select name="project_status[]" id="project_status_multiselect" multiple="multiple" class=""> 
                                                      
                            <?php 
                   
                            if ($_SESSION['admin_type'] == 'Requester') {
                                if(isset($_SESSION['filter']['project_status'])){ ?>
                                 <option value="New" <?php if (in_array('New',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }  ?> >New</option> <!-- Default selected -->
                                <option value="In-progress" <?php if (in_array('In-progress',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }  ?> >In Progress</option>
                                <option value="On-Hold" <?php if (in_array('On-Hold',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }  ?> >On-Hold</option>
                                <option value="Completed" <?php if (in_array('Completed',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }  ?> >Completed</option>
                                <option value="Rejected" <?php if (in_array('Rejected',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }  ?> >Rejected</option>
                 <?php
                 }else{
                     ?>
                                <option value="New" selected="selected" >New</option> <!-- Default selected -->
                                <option value="In-progress" selected="selected">In Progress</option>
                                <option value="On-Hold">On-Hold</option>
                                <option value="Completed">Completed</option>
                                <option value="Rejected">Rejected</option>
                                
                            <?php
                 } } else { ?>
                                <option value="New" <?php if (in_array('New',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }  ?> >New</option> <!-- Default selected -->
                               <option value="In-progress" <?php if(isset($_SESSION['filter']['project_status'])){ if (in_array('In-progress',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }}  ?> >In Progress</option>
                                <option value="Completed" <?php if(isset($_SESSION['filter']['project_status'])) {if (in_array('Completed',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php } } ?> >Completed</option>
                                <option value="Rejected" <?php if(isset($_SESSION['filter']['project_status'])) {if (in_array('Rejected',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }}  ?> >Rejected</option>
                                <option value="Rejected" <?php if(isset($_SESSION['filter']['project_status'])) {if (in_array('On-Hold',  $_SESSION['filter']['project_status'])) { ?>selected="selected" <?php }}  ?> >On-Hold</option>
                            
                          <?php      } ?>
                        </select>
                    </th>
                    <?php
                   if (in_array('attachements', $_SESSION['sort_fields'])) {
                       ?>
                    <th width="3%">Attachments</th>
                   <?php } ?>
                    <th width="3%" >Action</th>
                </tr>
            </thead>
            <tbody id="request_data_body">
                <?php include dirname(__FILE__) . '/dashboardrequestfilter.php'; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="ajax_loader" style="display: none;">
    <img width="20px" title="Please wait..." src="<?= SITE_URL ?>views/images/ajax-loader-circle.gif"/>
</div>

<div id="ajax_success" style="display: none;">
    <img class="ajax_success" width="20px" title="Saved Successfully" src="<?= SITE_URL ?>views/images/right-mark-md.png"/>
</div>

<div id="addnote_dialog" name="addnote_dialog" class="form user-dialog" title="Upload Attachments" style="display: none;">
    <form id="frm_add_note" method="POST" action="<?= SITE_URL ?>backadmin/add_attachments" enctype="multipart/form-data">
        <input type="hidden" name="proj_id" value=""/>
        <input type="hidden" name="status" value=""/>
        <table style="margin: 10px auto;width: 430px;">
            <tr>
                <td>Attachments: </td>
                <td>
                    <input type="file" id="approval_attachments" name="approval_attachments" style="width: 318px;" class="mygroup" >
                </td>
                <td>
                    <img src="<?php echo SITE_URL; ?>views/images/Clearall.png" style=" width:20px"  onclick="deleteimage(this);">
                    <!--<input type="button" value="Reset Attachment" />-->
                </td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td> Path to Server: </td>
                <td><input type="text" id="pathlink" name="pathlink" style="width: 318px;" class="mygroup"></td>
            </tr>
        </table>
    </form>
</div>

<div id="view_attachment_dialog" name="view_attachment_dialog" class="form user-dialog" title="View Attachments" style="display: none;"></div>	

<!-- Used for calender view project details data store -->
<div id="get_project_by_id" style="display: none;"></div>

<div id="edit_request_dialog" class="form" title="VIEW PRODUCTION REQUEST" style="display: none;height: auto !important;">
    <div id="container"></div>
    <form id="edit_request_form" method="POST" action="<?= SITE_URL ?>front/editrequest" enctype="multipart/form-data"></form>  
</div>
<div id="view_dialog" class="form" title="View Log" style="display: none;height: auto !important;">
<!--      <div id="viewlog_details_maincontainer" style="width:100%; background-color: #cbcbcb;border-bottom: 2px solid;" >
            <table class="tabmenu" style="vertical-align: baseline !important;">
    <tr>
            <td class="active_tabitem">
		<div id="logs_show_button" class="tabitem_select" >Logs</div>
            </td>
            <td class="active_tabitem">
		<div id="files_show_button" class="tabitem" >Files</div>
            </td>
    </tr>
</table>
        </div>-->
 <div id="viewlog_details_container"></div>
    <form id="viewlog_details" method="POST" action="<?= SITE_URL ?>backadmin/editrequest" enctype="multipart/form-data">

    </form>
</div>
<div id="reject_view_dialog" class="form" title="" style="display: none;height: auto !important;">
    <div id="reject_viewlog_details_container"></div>
    <form id="reject_viewlog_details" method="POST" action="<?= SITE_URL ?>backadmin/editrequest" enctype="multipart/form-data">
    </form>
</div>

<!-- Support Popup code-->

<div id="support_popup_dialog" name="support" class="support-user-dialog" title="Support" style="display: none;">
    <div id="support_container"></div>
    </div>
  