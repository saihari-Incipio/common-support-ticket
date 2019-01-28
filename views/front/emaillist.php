<?php 
$sNo = Pagination::getStartSerialNumber();

foreach($emailRecords as $emailRecord) { 
     $toEmails = json_decode($emailRecord['to_data'], true);
     $ccEmails = !empty($emailRecord['cc_emails']) ? json_decode($emailRecord['cc_emails'], true) : [];?>
    <tr>
        <td><?=$sNo?></td>
        <td><?=$emailRecord['from_name']?>&lt;<?=$emailRecord['from_email']?>&gt;</td>
        <td>
            <?php foreach($toEmails as $email) { ?>
                <?=$email[1]?>&lt;<?=$email[0]?>&gt;<br/>
            <?php } ?>
        </td>
        <td>
            <?php foreach($ccEmails as $email) { ?>
                <?=$email[0]?><br/>
            <?php } ?>
        </td>
        <td><?=$emailRecord['subject']?></td>
        <td><?=$emailRecord['body']?></td>
        <td><?=Utility::getFormatedDate($emailRecord['c_date'])?></td>
    </tr>
<?php $sNo++; } echo Pagination::getHtml(); ?>

