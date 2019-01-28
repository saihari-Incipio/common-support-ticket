
<!-- Form submited successfully alert -->
<?php
if (isset($_SESSION['request_submitted']) && $_SESSION['request_submitted'] != '') {
    echo '<script>alert("' . $_SESSION['request_submitted'] . '")</script>';
    unset($_SESSION['request_submitted']);
}
?>
<div class="form">
    <span class="roboto-bold"> 
        <a style="text-decoration: none;"href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL; ?>views/images/ProjectRequest_IncipioLogo.png"> </a>
        ERP Service Ticket
        <div style="border-top:3px solid #000000;width:100px;"></div> 
    </span>
