<?php $config = get_cache('configurations_' .  get_language()); ?>
<div class="box contact">
    <div class="row">
        <div class="col-sm-6 contactform">
            <?php echo form_open($submit_uri);
            if (isset($id)) {echo form_hidden('id', $id);}
            $submit_uri = isset($submit_uri) ? $submit_uri : '';
            echo form_hidden('form', 'contact_form');
            ?>
            <h3 class="contact_title"><?php echo __('IP_send_message'); ?></h3>
            <?php $this->load->view('common/message'); ?>
            <?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $fullname, 'placeholder' => __('IP_fullname'), 'required' => TRUE)); ?>
            <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $email, 'placeholder' => __('IP_email'), 'required' => TRUE)); ?>
            <?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '20', 'class' => 'contactinput', 'value' => $tel, 'placeholder' => __('IP_tel'), 'required' => TRUE)); ?>
            <?php echo form_textarea(array('id' => 'message', 'name' => 'message', 'rows' => '3', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $message, 'placeholder' => __('IP_message'))); ?>
            <input type='submit' class="contactsubmit" title="<?php echo __('IP_send_contact'); ?>" value="<?php echo __('IP_send_contact'); ?>" />
            <?php echo form_close(); ?>
        </div>
        <div class="col-sm-6 contactinfo">
            <h3 class="contact_title"><?php echo __('IP_contact_info'); ?></h3>             
            <?php echo $config['contact_infomation']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $config['google_map_code']; ?>
        </div>
    </div>
</div>


