<div class="box">
    <h3><?php echo __('IP_faq_question_send'); ?></h3>
    <div class="divider"></div>
    <div class="reserve">
        <?php echo form_open($submit_uri); 
        $submit_uri = isset($submit_uri) ? $submit_uri : '';
        echo form_hidden('form', 'faq_form');
        ?>
        <?php $this->load->view('common/message'); ?>
        <div class="form-group">
          <label for="exampleInputFile">Họ tên</label>
          <?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $fullname, 'placeholder' => __('IP_fullname'))); ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Email</label>
          <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $email, 'placeholder' => __('IP_email'))); ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Tiêu đề</label>
          <?php echo form_input(array('name' => 'faq_title', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $faq_title, 'placeholder' => __('IP_faq_title'))); ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Nội dung câu hỏi</label>
          <?php echo form_textarea(array('name' => 'summary', 'rows' => '3', 'maxlength' => '1000', 'class' => 'form-control', 'value' => $summary, 'placeholder' => __('IP_faq_summary'))); ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Lĩnh vực</label>
          <?php if (isset($categories_combobox)) echo $categories_combobox; ?>
        </div>
        <div class="form-group">
          <label for="exampleInputFile"><img src="/security_code"/>&nbsp;</label>
          <?php echo form_input(array('name' => 'security_code', 'size' => '35', 'class' => 'form-control', 'maxlength' => '10', 'placeholder' => __('IP_capcha'))); ?>
          <p class="help-block">Nhập mã an toàn vào ô trống.</p>
        </div>
        <input type='submit' class="btn_faq_send" value="<?php echo __('IP_faq_question_send'); ?>" title="<?php echo __('IP_faq_question_send'); ?>" alt="<?php echo __('IP_faq_question_send'); ?>" />
        <?php echo form_close(); ?>
    </div>
</div>
