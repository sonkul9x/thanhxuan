<div class="box">
    <h3><?php echo __('IP_log_in'); ?></h3>
    <div class="divider"></div>
    <div class="reserve">
        <?php echo form_open($submit_uri); 
        $submit_uri = isset($submit_uri) ? $submit_uri : '';
        echo form_hidden('current_uri', '/');
        ?>
        <?php $this->load->view('common/message'); ?>
        <div class="form-group">
            <label for="exampleInputFile">Email <span style="color: red;">(*)</span></label>
          <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $email, 'placeholder' => __('IP_email'))); ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Mật khẩu <span style="color: red;">(*)</span></label>
          <?php echo form_input(array('name' => 'password','type' =>'password', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $password, 'placeholder' => __('IP_password'))); ?>
        </div>
      
        <input type='submit' class="btn btn-warning" value="<?php echo __('IP_log_in'); ?>" title="<?php echo __('IP_log_in'); ?>" alt="<?php echo __('IP_log_in'); ?>" />
        <?php echo form_close(); ?>
    </div>
</div>
