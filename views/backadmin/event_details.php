<?php
//app::pre($eventInfo);
//$eventInfo = $eventInfo[0];
?>
<table>
    <tr>
        <td>Requester's Name </td>
        <td>:</td>
        <td><?= $eventInfo['requester_name'] ?></td>
    </tr>
    <tr>
        <td>Requester's Email </td>
        <td>:</td>
        <td><?= $eventInfo['requester_email_id'] ?></td>
    </tr>
    <tr>
        <td>Phone Number </td>
        <td>:</td>
        <td><?= $eventInfo['requester_phone_number'] ?></td>
    </tr>
    <tr>
        <td>Request Type </td>
        <td>:</td>
        <td><?= $eventInfo['request_type'] ?></td>
    </tr>
    <?php if ($eventInfo['request_type'] == 'DINNER') { ?>
        <tr>
            <td>Restaurant Choice 1</td>
            <td>:</td>
            <td><?= $eventInfo['restaurant_1'] ?></td>
        </tr>
        <tr>
            <td>Restaurant Choice 2</td>
            <td>:</td>
            <td><?= $eventInfo['restaurant_2'] ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td>Date </td>
        <td>:</td>
        <td><?php
            echo $date = date('F j, Y', strtotime($eventInfo['start_datetime']));
            ?>
        </td>
    </tr>
    <tr>
        <td>Start Time </td>
        <td>:</td>
        <td><?= $start_time = date('h:i A', strtotime($eventInfo['start_datetime'])); ?></td>
    </tr>
    <tr>
        <td>End Time </td>
        <td>:</td>
        <td><?= $end_time = date('h:i A', strtotime($eventInfo['end_datetime'])); ?></td>
    </tr>
    <?php if($eventInfo['request_type']=='MEETING') { ?>
        <tr>
            <td>Meeting Room: </td>
            <td>:</td>
            <td><?php if(isset($eventInfo['room_name']) && $eventInfo['room_name'] != "") { echo $eventInfo['room_name']; } else { echo "Unassigned"; } ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td>Number of People </td>
        <td>:</td>
        <td><?= $eventInfo['number_of_people'] ?></td>
    </tr>
    <tr>
        <td>Customers </td>
        <td>:</td>
        <td><?= $eventInfo['customers'] ?></td>
    </tr>

    <?php if ($eventInfo['request_type'] == "DINNER") { ?>
        <tr>
            <td>Status </td>
            <td>:</td>
            <td><?=$eventInfo['dinner_status'] ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td style="vertical-align: top;">Comments </td>
        <td style="vertical-align: top;">:</td>
        <td style="width: 280px;"><?= nl2br($eventInfo['comments']) ?></td>
    </tr>
</table>