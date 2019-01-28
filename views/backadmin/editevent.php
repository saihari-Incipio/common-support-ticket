    <table class="edittable" style="width: 100%; margin: auto;" >
            <?php /*
            <tr>
                <td>Request Type</td>
                <td>:</td>
                <td>
                    <select id="request_type" name="request_type" class="required"  onchange="return changerequesttype(this.value);">
                        <option value="">Select request type</option>
                        <option <?php if($eventInfo['request_type']=='MEETING') { echo 'selected="selected"'; } ?> value="MEETING">Meeting</option>
                        <option <?php if($eventInfo['request_type']=='DINNER') { echo 'selected="selected"'; } ?>  value="DINNER">Dinner</option>
                    </select>
                </td>
            </tr>
             * 
             */?>
        <?php $restaurants = Utility::getRestaurants(); ?>
            <tr id="restaurant_span_1" <?php if($eventInfo['request_type']=='DINNER') { echo 'style="display: grid;"'; } else {     echo 'style="display: none;"'; } ?> style="display: table-row;" >
                <td>Restaurant Choice 1</td>
                <td>:</td>
                <td>
                    <!--<input type="text" class="required txtfield"  placeholder="Please enter restaurant" id="restaurant_name_1" name="restaurant_name_1" value="<?=$eventInfo['restaurant_1']?>">-->
                    <select id="restaurant_name_1" name="restaurant_name_1" class="required styled-select" onchange="return changefirstrestaurant(this.value)">
                        <option value="">Select Restaurant</option>
                        <?php foreach($restaurants as $restaurant) { if($eventInfo['restaurant_1']==$restaurant) { ?>
                        <option selected="selected" value="<?=$restaurant?>"><?=$restaurant?></option>
                        <?php } else { ?>
                            <option value="<?=$restaurant?>"><?=$restaurant?></option>
                        <?php } } ?>
                    </select>
                </td>
            </tr>
            <!--<div id="other_reataurant_choice_1" style="display: none"></div>-->
            <tr id="other_reataurant_choice_1" style="display: none"></tr>
            <tr id="restaurant_span_2" <?php if($eventInfo['request_type']=='DINNER') { echo 'style="display: grid;"'; } else {     echo 'style="display: none;"'; } ?> style="display: table-row;" >
                <td>Restaurant choice 2</td>
                <td>:</td>
                <td>
                    <!--<input type="text" class="required txtfield"  placeholder="Please enter restaurant" id="restaurant_name_2" name="restaurant_name_2" value="<?=$eventInfo['restaurant_2']?>">-->
                    <select id="restaurant_name_2" name="restaurant_name_2" class="required styled-select"  onchange="return changesecondrestaurant(this.value)">
                        <option value="">Select Restaurant</option>
                        <?php foreach($restaurants as $restaurant) { if($eventInfo['restaurant_2']==$restaurant) { ?>
                        <option selected="selected" value="<?=$restaurant?>"><?=$restaurant?></option>
                        <?php } else { ?>
                            <option value="<?=$restaurant?>"><?=$restaurant?></option>
                        <?php } } ?>
                    </select>
                </td>
            </tr>
<!--            <div id="other_reataurant_choice_2" style="display: none"></div>-->
            <tr id="other_reataurant_choice_2" style="display: none"></tr>
            <?php if($eventInfo['request_type']=='MEETING') { ?>
            <tr>
                <td>Company Representing</td>
                <td>:</td>
                <td><input type="text" class="required txtfield" placeholder="Please enter company representing" id="company_representing" name="company_representing" value="<?=$eventInfo['company_representing']?>"></td>
            </tr>
            <?php } ?>
            <tr>
                <td id="number_of_people_label">No. of people in <?php if($eventInfo['request_type']=='DINNER') { echo 'DINNER'; } else {     echo 'MEETING'; } ?> (total)</td>
                <td>:</td>
                <td>
                    <input type="text" class="required txtfield"  placeholder="Please enter total number of people in meeting" id="number_of_people" name="number_of_people" value="<?=$eventInfo['number_of_people']?>">
                </td>
            </tr>
            <tr>
                <td>Customers/Partner Name</td>
                <td>:</td>
                <td>
                    <input type="text" class="required txtfield"  placeholder="Please enter customers/partner name" id="customers" name="customers" value="<?=$eventInfo['customers']?>">
                </td>
            </tr>
            <?php if($eventInfo['request_type'] == "DINNER") { ?>
                <tr>
                    <td>Status </td>
                    <td>:</td>
                    <td>
                        <select name="dinner_status">
                            <option value="REQUESTED" <?php if($eventInfo['dinner_status'] == "REQUESTED") { ?>selected="selected"<?php } ?>>REQUESTED</option>
                            <option value="CONFIRMED" <?php if($eventInfo['dinner_status'] == "CONFIRMED") { ?>selected="selected"<?php } ?>>CONFIRMED</option>
                        </select>
                    </td>
                </tr>
            <?php } else { // no change for meeting ?>
                <input type="hidden" name="dinner_status" value="<?=$eventInfo['dinner_status']?>" />
            <?php } ?>
            <tr>
                <?php if($eventInfo['request_type'] == "DINNER") { ?>
                    <td>Comments/Allergies/Special Request</td>
            <?php } else { ?>
                    <td>Comments/Special Request</td>
            <?php } ?>
                <td>:</td>
                <td>
                    <textarea type="text" class="txtfield" placeholder="Please enter comments/special request" id="comments" name="comments"><?=$eventInfo['comments']?></textarea>
                    <input type="hidden" name="request_type" value="<?=$eventInfo['request_type']?>" />
                    <input type="hidden" id="event_id" name="event_id" value="<?=$eventInfo['id']?>" />
                    <input type="hidden" id="type" name="type" value="EDIT" />
                </td>
            </tr>
            
        </table>

<table >
<tr  id="other_restaurant_1" style="display: none;">

                <td>Other Restaurant For Choice 1</td>
                <td>:</td>
                <td><input type="text" class="required txtfield" placeholder="Please enter other restaurant" id="restaurant_1_other" name="restaurant_1_other"></td>

</tr>
<tr id="other_restaurant_2" style="display: none;">

                <td>Other Restaurant For Choice 2</td>
                <td>:</td>
                <td><input type="text" class="required txtfield" placeholder="Please enter other restaurant" id="restaurant_2_other" name="restaurant_2_other"></td>

</tr>
  </table>