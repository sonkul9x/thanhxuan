<?php echo $this->load->view('powercms/admin_header', NULL, TRUE); ?>

<div class="header">
    <div style="background-color:darkred; color:white;">
        <div class="container"><p style="padding:16px 0; font-size:26px; font-family:arial"><strong>Admin</strong> panel</p></div>
    </div>
    <div class="container">
        <?php if(isset($admin_menu))echo $admin_menu;?>
    </div>
    <br class="clear"/>
</div>

<div class="container">
    <div class="content_container">
        <?php
            if(isset($url)) echo form_hidden('url', $url);
            if (isset($main_content)) echo $main_content; else echo '&nbsp;';
        ?>
    </div>
    <br class="clear"/>
</div>

<?php echo $this->load->view('powercms/admin_footer', NULL, TRUE); ?>