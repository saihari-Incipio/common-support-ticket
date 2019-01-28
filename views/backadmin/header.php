<div class="tavik-logo">
    <a href=""><img src="<?php echo SITE_URL; ?>views/images/IncipioLogo-209x53.png"></a>
    <span class="header">CES Meeting Room Request </span>
    <?php // if(!isset($list)) { ?>
<!--     <font style="font-size:20px;float: right;margin: 22px 24px;color: #000;border-left: 2px solid #000;">&nbsp;&nbsp;&nbsp;
    <a style="letter-spacing:1px;text-decoration: none;color: #000;font-family: Roboto Bold Condensed;font-size: 18px;" href="<?php echo SITE_URL; ?>backadmin/logout/">Logout</a>
    </font>-->
    <font style="float: right;margin: 22px 24px 0;" class="resetpass"> 
	<a style="text-decoration: none;color: #fff;" href="<?php echo SITE_URL; ?>backadmin/logout/">Logout</a>
    </font>
    <span style="float: right;margin-top: 27px;">
	<a href="<?php echo SITE_URL; ?>backadmin/resetpassword" class="resetpass">Reset Password</a>
    </span>
    <span style="float: right;margin: 26px 20px 0;"><b>View</b> <select onchange="changeView(this.value)"> 
                    <!--<option value="">Select view</option>-->
                    <option  value="list-view" <?php if(isset($list)) { echo 'selected="selected"'; } ?>>List</option>
                    <option value="allschedules" <?php if(!isset($list)) { echo 'selected="selected"'; } ?>>All Schedules</option>
                </select>
        </span>
    <?php // } ?>
    
</div>

<?php if(isset($list)) { ?>
<div class="portal-bkadmin-content"> <!-- content div -->
    <table class="bkadmin-table-main">
<?php } else { ?>
        <div class="portal-bkadmin-content" > <!-- content div -->
            <table class="bkadmin-table-main" style="display: none">
<?php } ?>

        <tr>
            <td style="width:25%;"> 
                <img src="<?php echo SITE_URL; ?>views/images/Hello-68x46.png" style="vertical-align:text-bottom"> &nbsp; 
                <span style="letter-spacing:1px; font-size:24px;color:#a2a1a1;text-transform:uppercase;">
                    <?= $_SESSION['admin_display_name'] ?>&nbsp;
                </span> 
                <font style="font-size:20px;border-left: 2px solid #000;">&nbsp;&nbsp;&nbsp;
                <a style="letter-spacing:1px;" href="<?php echo SITE_URL; ?>backadmin/logout/">Logout</a>
                </font>
            </td>
            <td style="font-size: 24px; padding-left:5em;">&nbsp;&nbsp;&nbsp;&nbsp;
                Date: <?php echo Utility::getPSTCurrentTime()->format('m/d/Y'); ?>
            </td>
            <td id="center-td-cal" style="display:none;">
                <img src="<?php echo SITE_URL; ?>views/images/CalendarView-MonthLeftArrow.png" style="vertical-align:top;" id="previous" class="previous-month-select"><span style="vertical-align:top;" id="selected-month"> <span style="margin:0 0 0 19px;bacground-color:red;">June2015 </span></span><img style="vertical-align:top;" src="<?php echo SITE_URL; ?>views/images/CalendarView-MonthRightArrow.png" id="next" class="next-month-select">
            </td>

            <td style="align:right;width:25%;" align="right"> 
                <!--                 Status &nbsp; 
                                <select onchange="populateTable(document.dateChooser);" id="pstatus_main" data-filter="PROJECT_STATUS"> 
                                    <option selected="selected" value="NEW"> New / Open </option>
                                    <option value="COMPLETED">Completed</option>
                                </select>  &nbsp;-->
                View &nbsp;
                <select onchange="changeView(this.value)"> 
                    <option value="">Select view</option>
                    <option  value="list-view" <?php if(isset($list)) { echo 'selected="selected"'; } ?>>List</option>
                    <option value="allschedules" <?php if(!isset($list)) { echo 'selected="selected"'; } ?>>All Schedules</option>
                </select>
            </td>
        </tr>
    </table>