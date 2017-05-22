<div class="box">
    <h3><?php echo __('IP_reserve_title'); ?></h3>
    <div class="divider"></div>
    <div class="box_content reserve">
        <?php echo form_open($submit_uri); 
        $submit_uri = isset($submit_uri) ? $submit_uri : '';
        echo form_hidden('form', 'reserve_form');
        ?>
        <?php $this->load->view('common/message'); ?>
        <?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $fullname, 'placeholder' => __('IP_fullname'))); ?>
        <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $email, 'placeholder' => __('IP_email'))); ?>
        <?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '20', 'class' => 'form-control', 'value' => $tel, 'placeholder' => __('IP_tel'))); ?>
        <?php echo form_input(array('name' => 'number', 'size' => '50', 'maxlength' => '20', 'class' => 'form-control', 'value' => $number, 'placeholder' => __('IP_number'))); ?>
        <?php echo form_input(array('id' => 'reserve_time', 'name' => 'time', 'size' => '50', 'maxlength' => '10', 'class' => 'form-control', 'value' => $time, 'placeholder' => __('IP_time'))); ?>
        <?php echo form_textarea(array('id' => 'message', 'name' => 'message', 'rows' => '3', 'maxlength' => '255', 'class' => 'form-control', 'value' => $message, 'placeholder' => __('IP_message'))); ?>
        <?php echo form_input(array('name' => 'security_code', 'size' => '35', 'class' => 'form-control', 'maxlength' => '10', 'placeholder' => __('IP_capcha'))); ?><br/><img src="/security_code"/>
        <input type='image' class="contactsubmit" src="<?php echo base_url().'images/booking.png'; ?>" title="<?php echo __('IP_reserve_title'); ?>" alt="<?php echo __('IP_reserve_title'); ?>" />
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
