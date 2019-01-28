<?php include_once 'views/front/headerdashboard.php'; ?>
<h2 style="text-align: center; font-family: 'Roboto Condensed'">Email Notifications</h2>
<table id="tablesorter" class="tablesorter" data-dataurl="backadmin/emaillist">
        <thead>
            <tr id="request_filter">
                <th width="3%">S.No.</th>
                <th width="3%">From</th>
                <th width="3%">To</th>
                <th width="3%">CC</th>
                <th width="3%">Subject</th>
                <th width="3%">Body</th>
                <th width="3%">Sent Date</th>
            </tr>
        </thead>
        <tbody id="request_data_body">
            <?php include dirname(__FILE__) . '/emaillist.php'; ?>
        </tbody>
</table>



