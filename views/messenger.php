<div class="error">
   <?php if(isset($_SESSION['message'])) { ?>
        <span class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
   <?php unset($_SESSION['message']); } ?>
</div>
