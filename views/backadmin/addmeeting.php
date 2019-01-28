
<link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/style.css" />
<div class="form">
<form enctype="multipart/form-data" id="project-quotation" action="" method="post" novalidate="novalidate">

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
        <select id="request_type" name="request_type" class="required styled-select" onchange="return changerequest(this.value);">
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
<!--    <span class="form-field">
        <p class="contact"><label for="date_of_meeting" id="date_label">Date and Time of meeting</label></p> 
        <input readonly="readonly" type="text" class="required " placeholder="Please enter meeting date and time" id="date_of_meeting" name="date_of_meeting" style="width: 250px;" ><input type="hidden" value="" id="alt_example_3_alt" name="duedate_datetime_db" style="cursor: pointer;">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="required " placeholder="Enter total number of people in meeting" id="number_of_people" name="number_of_people"  style="width: 280px;">
    </span>-->
    
<!--    <span class="form-field">
        <p class="contact"><label for="time_of_meeting">Time of meeting</label></p> 
        <input type="text" class="required txtfield" placeholder="Please enter meeting time" id="time_of_meeting" name="time_of_meeting">
        
        <p class="contact"><label for="" id="time_label">Time of meeting</label></p>
        <select name="s_hour" class="styled-select">
            <option value=""> Hours </option>
            <?php for($i=1;$i<=12;$i++){ $hourText = sprintf('%02d', $i); ?>
            <option value="<?=$hourText?>"><?=$hourText?></option>
            <?php } ?>
        </select>
        <select name="s_mins" class="styled-select">
            <option value=""> Mins </option>
            <?php for($i=0;$i<=59;$i++){ $minText = sprintf('%02d', $i);?>
            <option value="<?=$minText?>"><?=$minText?></option>
            <?php } ?>
        </select>
        <select name="s_meridian" class="styled-select">
            <option value="AM"> AM </option>
            <option value="PM"> PM </option>
        </select><br/>
        <span id="s_hour_error"></span>
        <div id="s_mins_error"></div>
    </span>-->

<!--    <span class="form-field">
        <p class="contact"><label for="number_of_people" id="number_of_people_label">No. of people in meeting (total)</label></p> 
        <input type="text" class="required txtfield" placeholder="Please enter total number of people in meeting" id="number_of_people" name="number_of_people">
    </span>-->
    
    <span class="form-field">
        <p class="contact"><label id="customers_label" for="customers">Customers / Partner Name</label></p> 
        <input type="text" class="required txtfield" placeholder="Please enter customers/partner name" id="customers" name="customers">
    </span>
    
    <span class="form-field">
        <p class="contact"><label id="comments_label" for="comments">Comments / Special Request</label></p> 
        <textarea type="text" class="txtfield" placeholder="Please enter comments/special request" id="comments" name="comments"></textarea>
    </span>
    
    <span class="form-field">
        <input type="button" name="back" onclick="window.location.href='<?=SITE_URL?>backadmin/allschedules'" value="Back">
        <input type="submit" name="submit" value="Submit">
    </span>
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
        <select id="restaurant_name_1" name="restaurant_name_1" class="required styled-select" onchange="return changefirstrestaurant(this.value)">
            <option value="">Select Restaurant</option>
            <?php foreach($restaurants as $restaurant) { ?>
                <option value="<?=$restaurant?>"><?=$restaurant?></option>
            <?php } ?>
        </select>
    </span>
    
    <div id="other_reataurant_choice_1" style="display: none"></div>
    
    
    
    <span class="form-field request_dropdwon" id="restaurant_span_2">
        <p class="contact"><label for="restaurant_choice_2">Restaurant Choice 2</label></p> 
        <select id="restaurant_name_2" name="restaurant_name_2" class="required styled-select"  onchange="return changesecondrestaurant(this.value)">
            <option value="">Select Restaurant</option>
            <?php foreach($restaurants as $restaurant) { ?>
                <option value="<?=$restaurant?>"><?=$restaurant?></option>
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
            <select id="meeting_room" name="meeting_room" class="required styled-select"    onchange="return changesecondrestaurant(this.value)">
            <option value="">Select Meeting Room</option>
            <?php foreach($meetingRooms as $rooms) { ?>
                <option value="<?=$rooms['id']?>"><?=$rooms['room_name']?></option>
            <?php } ?>
        </select>
        </span>
</div>
</div>