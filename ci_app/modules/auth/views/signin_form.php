<form class="form-2" role="form" action="/login" accept-charset="utf-8" method="post">
    <h1>
        <span class="log-in"><?php echo __('IP_log_in') ?></span>
        <span class="sign-up"><?php echo $this->load->view('powercms/message'); ?></span>
    </h1>
    <p class="float">
        <label for="username"><i class="icon-user"></i>Username</label>
        <input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="<?php echo __("IP_user_name"); ?>">
    </p>
    <p class="float">
        <label for="password"><i class="icon-lock"></i>Password</label>
        <input type="password" name="password" value="<?php echo set_value('password'); ?>" placeholder="<?php echo __("IP_password"); ?>" class="showpassword">
    </p>
    <p class="clearfix"> 
        <input type="submit" name="submit" class="log-twitter" value="<?php echo __("IP_log_in"); ?>">
    </p>
</form>​​