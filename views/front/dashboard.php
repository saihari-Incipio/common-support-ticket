<?php include_once 'views/front/headerdashboard.php'; ?>
<script type="text/javascript" src="<?= SITE_URL ?>views/js/dropdownchecklist/ui.dropdownchecklist.js"></script>
<style>
    table {
    border-spacing: 0;
    border-collapse: collapse;
}
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
<div class="search_sticky" >                  
                 <!--<a  style="float:right;margin:-27px 0px; text-decoration:none;color:black;font-weight: bold;font-size: 16px;" href="<?= SITE_URL ?>front"> Create New  <img src="<?php echo SITE_URL; ?>views/images/plus.png" style=" margin-bottom: -8px; width: 25px;"/></a>-->
     <span class="flexContainer" style="float:left;height:27px;">
         <input name="text_search" placeholder="Search by name or ticket no" style="border: 1px; flex: 1; font-style: normal;font-size:11pt;font-weight:bold;" type="text" value="" id="text_search">
         <button style="border: none; background-color: #fff;float:right;"><a href=""> <img onclick="" src="<?= SITE_URL ?>views/images/search_dashboard.png" style=" width:18px;"></a></button>
            
     </span> 
     <span><a style="float:right;" class="newt" href="<?= SITE_URL ?>front"> NEW TICKET</a></span> 
     <span><a  style="float:right;" class="filter" href="#"> FILTER <img src="<?= SITE_URL ?>views/images/filter.png" style=" width:18px;" /></a></span> 
</div>



<div id="list-view" style="padding-top:80px;">
    <div class="messenger" style="text-align: center;">
        <?php if (isset($_SESSION['message'])) { ?>
            <span style="line-height: 24px;" id="messenger"  class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
            <?php
            unset($_SESSION['message']);
        }
        ?>
    </div>

    <!--    <form name="datesearch" id="datesearch">
            Select Date : <input type="text" name="from_duedate" placeholder="From Date" class="duedate_datetime" />
            <input type="text" name="to_duedate" placeholder="To Date" class="duedate_datetime" />
            <input type="button" value="submit" onclick="date_search()">
        </form>-->
    <div style="width: 100%;">
        <table id="tablesorter" class="tablesorter" data-dataurl="front/dashboardrequestfilter" >
            <thead>
            <input type="hidden" name="dashboard_type" id="dashboard_type" value="FRONT" />
            <tr id="request_filter" style="height:50px;">
                <!--<th>ID</th>-->
                <th align="center"> Ticket ID </th>
                <th class="" data-sort-by="created_date" style="width:10%;text-align: left;">Submit Date</th>
                <th><div style="width:100px;text-align:left;">Title</div></th>
                <th><div style="width:150px;text-align:left;">Description</div></th>
                <th><div style="width:50px;text-align:left;">Platform </div> </th>
                <th><div style="width:50px;text-align:left;">Track </div></th>
                <th><div style="width:80px;text-align:left;">Sub Track </div></th>
                <th><div style="width:50px;text-align:left;">Instance  </div></th>
                <th><div style="width:50px;text-align:left;">Phase  </div></th>
                <th><div style="width:90px;text-align:left;">Service Type  </div></th>
                <th><div style="width:50px;text-align:left;">Status  </div></th>
                  <th><div style="width:50px;text-align:left;">Details</div></th>
<!--                <th><div style="width:50px;">Action  </div></th>-->
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
