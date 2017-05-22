<div class="container">
    <form class="form-signin" role="form" action="/login" accept-charset="utf-8" method="post">
      <h2 class="form-signin-heading"><?php echo __('IP_log_in') ?></h2>
      <?php echo $this->load->view('powercms/message'); ?>
      
      <input type="text" name="username" class="form-control" maxlength="30" value="<?php echo set_value('username'); ?>" placeholder="<?php echo __("IP_user_name"); ?>" required autofocus>
      <input type="password" name="password" class="form-control" maxlength="50" value="<?php echo set_value('password'); ?>" placeholder="<?php echo __("IP_password"); ?>" required style="margin: 10px 0;">
      <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo __("IP_log_in"); ?></button>
    </form>
</div> <!-- /container -->