<script>
$(document).ready(function () {
        $("#button").on('click', function(){
            $("#box").slideToggle();
            $("#box").css('display', 'block');
        });
});
</script>
<script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery.ui.touch-punch.js"></script>
<style>
    #button {
        width: 100%;
        margin: auto !important;
        text-align: center;
    }
    
/* don't allow browser text-selection */
.dragg {
    cursor: pointer;
        
    -webkit-user-select: none;
     -khtml-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
</style>
<div id="title_bar">
    <div id="button"><img src="<?php echo SITE_URL; ?>views/images/toggle.png"></div>
</div>
<div id="box" style="display:none">

    <?php
    if (count($requestFields) > 0) {
        foreach ($requestFields as $request) {
            ?>
            <div class="dragg" data-id="<?= $request['id'] ?>" data-duration='01:00' onclick="return requestEventClick('<?php echo $request['id'] ?>', '<?php echo $request['request_type'] . ' - ' . $request['requester_name'] ?>')">
                <div class="event-title">
                    <?php echo $request['request_type'] . '</br>' ?>
                    <?php echo $request['requester_name'] . '</br>' ?>
                </div>
                <?php echo "<span style='font-size:10px;'>" . date('h:i A', strtotime($request['start_datetime'])) . '-' . date('h:i A', strtotime($request['end_datetime'])) . '</span></br>' ?>
            </div>
            <?php
        }
        echo '<div style="text-align: right; padding: 10px;">' . Pagination::getHtml() . '</div>';
    } else {
        echo 'No unscheduled meeting found';
    }
    ?>  
</div>
