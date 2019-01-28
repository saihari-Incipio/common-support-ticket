<?php
$i = Pagination::getStartSerialNumber();
if (count($requestFields) > 0) {

    foreach ($requestFields as $request) { ?>
        <tr>
            <td><?=$i?></td>
            <td> <?php echo $request['requester_name']; ?> </td>
            <td> <?php echo $request['requester_email_id']; ?> </td>
            <td> <?php echo $request['requester_phone_number']; ?> </td>
            <td> <?php echo $request['request_type']; ?> </td>
            <td> <?php echo date('Y-m-d', strtotime($request['start_datetime'])); ?> </td>
            <td> <?php echo date('h:i A', strtotime($request['start_datetime'])); ?> </td>
            <td> <?php echo $request['number_of_people']; ?> </td>
            <td> <?php echo $request['customers']; ?> </td>
            <td> <?php echo $request['comments']; ?> </td>
        </tr>
    <?php
    $i = $i + 1;
    }
//    echo $pagination;
    echo Pagination::getHtml();
} else {
    ?>
    <tr>
        <td colspan="19" style="color: red; text-align: center;" ><span>No Request found</span></td>
    </tr>

<?php } ?>
