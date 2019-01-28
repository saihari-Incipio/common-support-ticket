<?php use incipio\lib\Session; ?>
<!-- Form submited successfully alert -->
<?php
if (isset($_SESSION['request_submitted']) && $_SESSION['request_submitted'] != '') {
    echo '<script>alert("' . $_SESSION['request_submitted'] . '")</script>';
    unset($_SESSION['request_submitted']);
}
?>
<div class="form">
    <span class="roboto-bold heading"> 
        <?php if(isset($_SESSION['requester_id'])) { ?>
        <a href=""><img src="<?php echo SITE_PUBLIC_URL; ?>images/incipio-logo-white.png" style="position: relative; top: 2px; width: 20%; vertical-align: middle; margin-bottom: 10px;"></a><br/>
        Sample Request Form
        <div style="border-top:3px solid #000000;width:36px;"></div> 
        <?php } ?>
    </span> 
    <?php if(!isset($_SESSION['requester_id'])) { ?>
    <span> 
        <img src="<?php echo SITE_PUBLIC_URL; ?>images/incipio-logo-white.png" onclick="window.location.href='<?=SITE_URL?>'" style="position: relative; top: 8px; width: 26%; margin-bottom: 21px; cursor:pointer;">
    </span> 
    <p style="text-transform: uppercase; color: #fff; margin: 10px 0; font-family: Roboto Condensed; letter-spacing: 2px; font-size: 25px;">
        Sample Request Form
        
        <?php 
        $back_to_home_link = SITE_URL;
        
        if(Session::get('admin_user_id')) { 
            $back_to_home_link= SITE_URL."backadmin"; 
            $download_link = SITE_URL."front/index/downloadattachment?name=";
        } else if(Session::get('requester_id')){ 
            $back_to_home_link= SITE_URL."front/dashboard"; 
            $download_link=SITE_URL."front/index/downloadattachment?name="; 
        } 
        ?>
        
        <a style="letter-spacing:1px;font-size: 20px;float: right;color: #fff;" href="<?=$back_to_home_link?>">Back To Home</a>
    </p>
    <?php } ?>
    
     <div class="messenger">
        <?php if(isset($_SESSION['message'])) { ?>
             <span id="messenger"  class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
        <?php unset($_SESSION['message']); } ?>
     </div>
    
<script>
    $(document).ready(function () {
        $("#messenger").delay(3000).fadeOut(400);
         $.LoadingOverlay("show");
    });
    $(window).load(function() {
     $.LoadingOverlay("hide");
});
</script>