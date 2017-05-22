<div class="box">
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php echo __('IP_faq_question_send'); ?></li>
    </ol>

    <div class="question">
        <?php echo form_open($submit_uri); 
        $submit_uri = isset($submit_uri) ? $submit_uri : '';
        echo form_hidden('form', 'faq_form');
        ?>
        <?php $this->load->view('common/message'); ?>
        <div class="form-group">
          <label>Họ tên</label>
          <?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $fullname, 'placeholder' => __('IP_fullname'))); ?>
        </div>
        <div class="form-group">
          <label>Email</label>
          <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $email, 'placeholder' => __('IP_email'))); ?>
        </div>
        <div class="form-group">
          <label>Điện thoại</label>
          <?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '20', 'class' => 'form-control', 'value' => $tel, 'placeholder' => __('IP_tel'))); ?>
        </div>
        <div class="form-group">
          <label>Tiêu đề</label>
          <?php echo form_input(array('name' => 'faq_title', 'size' => '50', 'maxlength' => '255', 'class' => 'form-control', 'value' => $faq_title, 'placeholder' => __('IP_faq_title'))); ?>
        </div>
        <div class="form-group">
          <label>Nội dung câu hỏi</label>
          <?php echo form_textarea(array('name' => 'summary', 'rows' => '3', 'maxlength' => '1000', 'class' => 'form-control', 'value' => $summary, 'placeholder' => __('IP_faq_summary'))); ?>
        </div>
        <div class="form-group hidden">
          <label>Lĩnh vực</label>
          <?php if (isset($categories_combobox)) echo $categories_combobox; ?>
        </div>
        <div class="form-group">
          <label><img src="/security_code"/>&nbsp;</label>
          <?php echo form_input(array('name' => 'security_code', 'size' => '35', 'class' => 'form-control', 'maxlength' => '10', 'placeholder' => __('IP_capcha'))); ?>
          <p class="help-block">Nhập mã an toàn vào ô trống.</p>
        </div>
        <input type='reset' value="<?php echo __('IP_reset'); ?>" title="<?php echo __('IP_reset'); ?>" alt="<?php echo __('IP_reset'); ?>" />
        <input type='submit' value="<?php echo __('IP_faq_question_send'); ?>" title="<?php echo __('IP_faq_question_send'); ?>" alt="<?php echo __('IP_faq_question_send'); ?>" />
        <?php echo form_close(); ?>
    </div>
</div>
