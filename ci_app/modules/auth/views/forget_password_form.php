<div class="side_item">
    <h2><?php echo __('IP_forget_password') ?></h2>
    <div class="content">
        <div class="form contact_form" >
            <?php echo form_open($submit_uri); ?>
            <table>
                <tr><td><?php echo $this->load->view('powercms/message'); ?></td></tr>
                <tr><th><?php echo __("IP_user_name"); ?>: (<span>*</span>)</th></tr>
                <tr><td><?php echo form_input(array('name' => 'username', 'size' => '40', 'maxlength' => '30', 'value' => set_value('username'))); ?></td></tr>
                <tr><th><?php echo __("IP_email"); ?>: (<span>*</span>)</th></tr>
                <tr><td><?php echo form_input(array('name' => 'email', 'size' => '40', 'maxlength' => '50', 'value' => set_value('email'))); ?></td></tr>
                <tr><th><?php echo __("IP_captcha"); ?>: (<span>*</span>)</th></tr>
                <tr>
                    <td>
                        <?php echo form_input(array('name' => 'security_code', 'size' => '40', 'maxlength' => '50', 'value' => set_value('security_code'))); ?>
                        <img src="/security_code" style="height: 28px;vertical-align: top;padding-left: 5px;"/>
                    </td>
                </tr>
                <tr><td><?php echo __('IP_get_password_message'); ?></td></tr>
                <tr>
                    <td>
                        <input type="submit" name="btnLogin" id="btn_login" value="<?php echo __("IP_log_in"); ?>" class="button yellow" />
                        <input type="reset" value="<?php echo __("IP_reset"); ?>" class="button darkgray" />
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>