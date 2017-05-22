<div class="box">
    <h3>Đăng ký đặt trước</h3>
    <div class="divider"></div>
    <div class="box_content contact_box">
        <div class="col-sm-12">
            <div class="row contactform">
                <?php echo form_open($submit_uri);
                if (isset($id)) echo form_hidden('id', $id);
                $submit_uri = isset($submit_uri) ? $submit_uri : '';
                echo form_hidden('form', 'contact_form');
                ?>
                <h3>Gửi thông tin liên lạc</h3>
                <?php $this->load->view('common/message'); ?>
                <?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $fullname, 'placeholder' => __('IP_fullname'))); ?>
                <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $email, 'placeholder' => __('IP_email'))); ?>
                <?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '20', 'class' => 'contactinput', 'value' => $tel, 'placeholder' => __('IP_tel'))); ?>
                <?php echo form_input(array('name' => 'fax', 'size' => '50', 'maxlength' => '20', 'class' => 'contactinput', 'value' => $fax, 'placeholder' => __('IP_fax'))); ?>
                <?php echo form_input(array('name' => 'company', 'size' => '50', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $company, 'placeholder' => __('IP_company'))); ?>
                <?php echo form_input(array('name' => 'address', 'size' => '50', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $address, 'placeholder' => __('IP_address'))); ?>
                <?php echo form_textarea(array('id' => 'message', 'name' => 'message', 'rows' => '3', 'maxlength' => '255', 'class' => 'contactinput', 'value' => $message, 'placeholder' => __('IP_message'))); ?>
                <input type='image' class="contactsubmit" src="<?php echo base_url().'images/send.png'; ?>" title="<?php echo __('IP_send_contact'); ?>" alt="<?php echo __('IP_send_contact'); ?>" />
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
