<div class="box bo_cart">
    <h3><?php echo __('IP_customers_sign_up'); ?></h3>
    <div class="divider"></div>
    <div class="reserve">
        <?php echo form_open($submit_uri); 
        $submit_uri = isset($submit_uri) ? $submit_uri : '';
        echo form_hidden('form', 'faq_form');
        ?>
        <?php $this->load->view('common/message'); ?>
        <div class="form-group">
            <label for="exampleInputFile">Email <span style="color: red;">(*)</span></label>
          <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $email, 'placeholder' => __('IP_email'))); ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile"><?php echo $pass;?></label>
          <?php echo form_input(array('name' => 'password','type' =>'password', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $password, 'placeholder' => __('IP_password'))); ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile"><?php echo $re_pass;?></label>
          <?php echo form_input(array('name' => 're_password','type' =>'password', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $re_password, 'placeholder' => __('IP_re_password'))); ?>
        </div>
        <?php echo $info_help;?>
        <h3><?php echo __('IP_customers_info_delivery'); ?></h3>
        <p>Nhập thông tin người nhận, địa chỉ mà bạn muốn chúng tôi chuyển hàng tới.</p>
        <div class="form-group">
          <label for="exampleInputFile">Họ tên <span style="color: red;">(*)</span></label>
          <?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $fullname, 'placeholder' => __('IP_fullname'))); ?>
        </div>
        
        <div class="form-group">
          <label for="exampleInputFile">Địa chỉ</label>
          <?php echo form_input(array('name' => 'address', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $address, 'placeholder' => __('IP_address'))); ?>
        </div>
        
        <div class="form-group">
          <label for="exampleInputFile">Điện thoại</label>
          <?php echo form_input(array('name' => 'phone', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $phone, 'placeholder' => __('IP_phone'))); ?>
        </div>
        
        <div class="form-group">
          <label for="exampleInputFile"><img src="/security_code"/>&nbsp;</label>
          <?php echo form_input(array('name' => 'security_code', 'size' => '35', 'class' => 'form-control', 'maxlength' => '10', 'placeholder' => __('IP_capcha'))); ?>
          <p class="help-block">Nhập mã an toàn vào ô trống.</p>
        </div>
        <input type='submit' class="btn btn-warning" value="<?php echo __($btn_submit); ?>" title="<?php echo __('IP_faq_question_send'); ?>" alt="<?php echo __('IP_faq_question_send'); ?>" />
        <?php echo form_close(); ?>
    </div>
</div>
