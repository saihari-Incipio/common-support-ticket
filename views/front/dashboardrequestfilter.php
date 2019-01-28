


<?php
//print_r($_SESSION['admin_type']);
//print_r($_SESSION['admin_readonly']);exit;
//echo Pagination::getHtml();exit;
//App::pre($projectsRequests);
$projectDesigners = [];
$startSrNo = Pagination::getStartSerialNumber();
//App::pre($ticketsData);
if (isset($ticketsData['issues']) && count($ticketsData['issues']) > 0) {
    foreach ($ticketsData['issues'] as $request) {
//        print_r($request);
        $selectedDesignerNames = [];
        $key = base64_encode($request['key']);
        ?>

        <tr id="request_row_<?= $request['id'] ?>" >
            <td align="center"> <?= $request['key'] ?> </td>
            <td><?= Utility::getFormatedDate($request['fields']['created']) ?></td>
            <td ><?= $request['fields']['summary'] ?></td>
            <td> <div style="width: 150px;"><?= $request['fields']['description'] ?></div></td>
            <td><?= $request['fields']['customfield_11304']['value'] ?></td>
            <td><?= $request['fields']['customfield_11305']['value'] ?></td>
            <td><?= $request['fields']['customfield_11306']['value'] ?></td>
            <td><?= $request['fields']['customfield_11307']['value'] ?></td>
            <td><?= $request['fields']['customfield_11308']['value'] ?></td>
            <td><?= $request['fields']['customfield_11309']['value'] ?></td>
            <td style="width: 11%;"><span class="<?= strtolower(str_replace(" ", "", $request['fields']['status']['statusCategory']['name'])); ?>"><?= $request['fields']['status']['statusCategory']['name'] ?></span></td>
            <td><a href="<?php SITE_URL ?>viewrequest?key=<?=$key; ?>">View</a></td>
        </tr>
        <?php
        
    } echo Pagination::getHtml();
} else {
    ?>
    <tr>
        <td colspan="19" style="color: red; text-align: center;" ><span>No Request found</span></td>
    </tr>

<?php } ?>

