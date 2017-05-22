<?php echo $this->load->view('admin_ui/common/header', NULL, TRUE); ?>



<div class="container header">

    <div class="working_container">

        <p><a href="<?php echo ADMIN_BASE_URL;?>" style="text-decoration:none;color:#fff;"><strong>Admin</strong> panel</a></p>

    </div>

</div>



<div class="container menu">

    <div class="working_container">

        <?php echo modules::run('menus/menus/get_main_menus',array('menu_type'=> 2)); ?>

        <?php $this->load->view('auth/login_panel'); ?>

        <br class="clear"/>

    </div>

</div>

    

<div class="container">

    <div class="working_container content">

    <?php

        if(isset($url)) echo form_hidden('url', $url);

        if (isset($main_content)) echo $main_content; else echo '&nbsp;';

    ?>

    </div>

</div>

<br class="clear"/>

<?php echo $this->load->view('admin_ui/common/footer', NULL, TRUE); ?>