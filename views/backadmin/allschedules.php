
<link href='<?= SITE_URL ?>views/css/events/fullcalendar.min.css' rel='stylesheet' />
<link href='<?= SITE_URL ?>views/css/events/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href='<?= SITE_URL ?>views/css/events/scheduler.min.css' rel='stylesheet' />
<link href='<?= SITE_URL ?>views/css/events.css' rel='stylesheet' />

<script src='<?= SITE_URL ?>views/css/events/moment.min.js'></script>
<script src='<?= SITE_URL ?>views/css/events/fullcalendar.min.js'></script>
<script src='<?= SITE_URL ?>views/css/events/scheduler.min.js'></script>
<script src='<?= SITE_URL ?>views/js/calendar.js'></script>


<script type="text/javascript">
    var meetingRooms = jQuery.parseJSON('<?=$selected_meeting_rooms?>');    
    var schedules = jQuery.parseJSON('<?=$all_schedules?>');    
    
    console.log(meetingRooms);
    console.log(schedules);
    
    $("document").ready(function(){
        loadSchedules(meetingRooms, schedules);
    });
</script>

<style>
  .portal-bkadmin-content {
     margin: 0px;
     padding:0px; 
  }
  .styled-select {
      margin-top: 0px !important;
  }
  
</style>
<div id="allschedules" style="background-color: #242424;">
    <table style="width: 100%;">
        <tr>
            <td style="vertical-align: top; width: 180px;">
                <div id="sidebar">
                    <?php $classNameAll = isset($_REQUEST['room_id']) || !empty($is_dinners) ? "not-selected" : 'selected'; ?> 
                    <div class="add_meeting" >Add New</div>
                    <div class="meeting-room <?=$classNameAll?>" data-room-id="all">Master Schedule</div>
                    <div class="dinner-reservations <?php if(!empty($is_dinners)) { ?>selected<?php } else { ?>not-selected<?php } ?>">Dinner Reservations</div>
                    
                    <div class="meeting-lebel"><b>Meeting Rooms</b></div>
                    <?php $rooms = json_decode($meeting_rooms, true);
                    foreach($rooms as $room) { 

                        // check whether room number is selected
                        $className = isset($_REQUEST['room_id']) && ($_REQUEST['room_id'] == $room['id']) ? "selected" : 'not-selected'; ?>

                        <div class="meeting-room <?=$className?>" data-room-id="<?=$room['id']?>">
                            <span class="room-indicator" style="background-color:<?=$room['eventColor']?>;">&nbsp;</span>
                            <?=$room['title']?>
                        </div>
                    <?php } ?>
                </div>
            </td>
            <td style="background-color: #343434;vertical-align: top;">
                <h2 class="calender-header"><?=strtoupper($room_details['room_name'])?> SCHEDULE</h2>
                <div id='calendar'></div>
            </td>
        </tr>
    </table>
    <?php if(isset($requestFields)) { ?>
        <div id="list-view">
            <?php include dirname(__FILE__) . '/unschedules.php'; ?>
        </div>
    <?php } ?>
    
</div>
<div id="eventContent" title="Event Details" style="display:none;">
    <table id="event_view" style="width: 100%; margin: auto;"> </table>
</div>

<div id="eventEdit" title="Edit Event" style="display:none;">
    <form id="edit_form" name="edit_form" action="<?=SITE_URL?>backadmin/editevent"></form>
</div>

<div id="fade"></div>
<div id="modal">
    <img id="loader" src="<?=SITE_URL?>views/images/ajax-loader-circle.gif" />
</div>

<div id="loader_view" style="display: none;">
    <img style="display: block;margin: auto;width: 32px;" src="<?=SITE_URL?>views/images/ajax-loader-circle.gif"/>
</div>


<div id="eventAdd" title="Add Event" style="display:none;">
    
    <style type="text/css">
        .dropdown_button {
            width: 572px;
            height: 32px;
            border: 1px solid;
            border-radius: 6px;
            /* font-size: 15px; */
            /* color: rgba(0, 0, 0, 0.94); */
            font-family: Roboto Condensed !important;
            font-size: 12pt !important;
            padding: 4px;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/backadmin_form.css" />
    <div class="form">
        <form enctype="multipart/form-data" id="project-quotation" action="<?= SITE_URL ?>backadmin/addmeeting" method="post" novalidate="novalidate">

            <span class="form-field">
                <p class="contact"><label for="requester_name">Requester’s full name </label></p> 
                <input type="text" class="required txtfield" placeholder="Please enter full name" id="requester_name" name="requester_name">
            </span>

            <span class="form-field">
                <p class="contact"><label for="requester_email_id">Email address</label></p> 
                <input type="text" class="required txtfield" placeholder="Please enter email id" id="requester_email_id" name="requester_email_id">
            </span>

            <span class="form-field">
                <p class="contact"><label for="requester_phone_number">Phone number</label></p> 
                <input type="text" class="required txtfield" placeholder="Please enter phone number" id="requester_phone_number" name="requester_phone_number">
            </span>

            <span class="form-field request_dropdwon">
                <p class="contact"><label for="requester_phone_number">Request Type</label></p> 
                <select id="request_type" name="request_type" class="required dropdown_button" onchange="return changerequest(this.value);">
                    <option value="">Select request type</option>
                    <option value="MEETING">Meeting</option>
                    <option value="DINNER">Dinner</option>
                </select>
            </span>

            <div id="form_restaurants"  style="display: none;"></div>

            <span class="form-field">
                <table>
                    <tr>
                        <td><p class="contact"><label for="date_of_meeting" id="date_label">Date and Time of meeting</label></p></td>
                        <td></td>
                        <td><p class="contact"><label for="date_of_meeting" id="number_of_people_label">&nbsp;No. of people in meeting (total)</label></p></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <input readonly="readonly" type="text" class="required " placeholder="Please enter meeting date and time" id="date_of_meeting" name="date_of_meeting" style="width: 250px;" onchange="return changedate(this.value);" ><input type="hidden" value="" id="alt_example_3_alt" name="duedate_datetime_db" style="cursor: pointer;">
                        </td>
                        <td></td>
                        <td>
                            <input type="text" class="required " placeholder="Enter total number of people in meeting" id="number_of_people" name="number_of_people"  style="width: 280px;">
                        </td>
                    </tr>
                </table>
            </span>
            <div id="form_meeting_rooms"></div>
        
            <span class="form-field">
                <p class="contact"><label id="customers_label" for="customers">Customers / Partner Name</label></p> 
                <input type="text" class="required txtfield" placeholder="Please enter customers/partner name" id="customers" name="customers">
            </span>

            <span class="form-field">
                <p class="contact"><label id="comments_label" for="comments">Comments / Special Request</label></p> 
                <textarea type="text" class="txtfield" placeholder="Please enter comments/special request" id="comments" name="comments"></textarea>
            </span>

<!--    <span class="form-field">
    <input type="button" name="back" onclick="window.location.href='<?= SITE_URL ?>backadmin/allschedules'" value="Back">
    <input type="submit" name="submit" value="Submit">
</span>-->
        </form>


        <style>
            .dropdown_label {
                    /* background-color: #fff!important; */
            border: 1px solid;
            color: black;
            border-radius: 5px;
            width: 100%!important;
            height: 34px;
            font-weight: bold;
            /* position: relative; */
            padding: 3px 1em 3px .4em;
            }
        </style>



        <div id="restaurants" style="display: none;">

<?php $restaurants = Utility::getRestaurants(); ?>

            <span class="form-field request_dropdwon" id="restaurant_span_1">
                <p class="contact"><label for="restaurant_choice_1">Restaurant Choice 1</label></p> 
                <select id="restaurant_name_1" name="restaurant_name_1" class="required dropdown_button" onchange="return changefirstrestaurant(this.value)">
                    <option value="">Select Restaurant</option>
                    <?php foreach ($restaurants as $restaurant) { ?>
                        <option value="<?= $restaurant ?>"><?= $restaurant ?></option>
<?php } ?>
                </select>
            </span>

            <div id="other_reataurant_choice_1" style="display: none"></div>



            <span class="form-field request_dropdwon" id="restaurant_span_2">
                <p class="contact"><label for="restaurant_choice_2">Restaurant Choice 2</label></p> 
                <select id="restaurant_name_2" name="restaurant_name_2" class="required dropdown_button"  onchange="return changesecondrestaurant(this.value)">
                    <option value="">Select Restaurant</option>
                    <?php foreach ($restaurants as $restaurant) { ?>
                        <option value="<?= $restaurant ?>"><?= $restaurant ?></option>
<?php } ?>
                </select>
            </span>

            <div id="other_reataurant_choice_2" style="display: none"></div>

        </div>


        <div id="representing" style="display:none">
            <span class="form-field">
                <p class="contact"><label id="company_representing_label" for="company_representing">Company Representing</label></p> 
                <input type="text" class="required txtfield" placeholder="Please enter company representing" id="company_representing" name="company_representing">
            </span>
        </div>


        <div id="other_restaurant_1" style="display: none;">
            <span class="form-field">
                <p class="contact"><label id="company_representing_label" for="other_restaurant_1">Other Restaurant For Choice 1</label></p> 
                <input type="text" class="required txtfield" placeholder="Please enter other restaurant" id="restaurant_1_other" name="restaurant_1_other">
            </span>
        </div>

        <div id="other_restaurant_2" style="display: none;">
            <span class="form-field">
                <p class="contact"><label id="company_representing_label" for="other_restaurant_2">Other Restaurant For Choice 2</label></p> 
                <input type="text" class="required txtfield" placeholder="Please enter other restaurant" id="restaurant_2_other" name="restaurant_2_other">
            </span>
        </div>

        <div id="meeting_rooms" style="display: none;">
            <span class="form-field request_dropdwon">
                <p class="contact"><label id="company_representing_label" for="meeting_room">Meeting Rooms</label></p> 
                <select id="meeting_room" name="meeting_room" class="required dropdown_button"    onchange="return changesecondrestaurant(this.value)">
                    <option value="">Select Meeting Room</option>
                    <?php /* Using from ajax call */ 
                    /* foreach ($meetingRooms as $rooms) { ?>
                        <option value="<?= $rooms['id'] ?>"><?= $rooms['room_name'] ?></option>
<?php } */ ?>
                </select>
            </span>
        </div>
    </div>
</div>