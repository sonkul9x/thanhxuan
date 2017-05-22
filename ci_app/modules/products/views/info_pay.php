<div class="box">
    <h1 class="title"><?php echo $title; ?></h1>
    <div class="clearfix"></div>
    <?php $this->load->view('common/message'); ?>
    <?php if ($this->cart->total_items() != 0): ?>
        <?php
        $attributes = array('class' => 'form-horizontal', 'role' => 'form');

        echo form_open($submit_uri, $attributes);

        if (isset($id)) {
            echo form_hidden('id', $id);
        }
        $submit_uri = isset($submit_uri) ? $submit_uri : '';
        echo form_hidden('form', 'cart_form');
        ?>
        <div class="alert alert-info"><?php echo __('required_fields'); ?></div>
        <?php echo form_hidden('user_id', $user_id); ?>
        <div class="form-group">
            <label for="inputname" class="col-sm-2 control-label"><?php echo __('IP_fullname'); ?> (<span style="color: red;">*</span>)</label>
            <div class="col-sm-6">
                <?php echo form_input(array('name' => 'fullname', 'id' => 'inputname', 'class' => 'form-control', 'value' => $fullname, 'placeholder' => __('IP_fullname'))); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="inputemail" class="col-sm-2 control-label"><?php echo __('IP_email'); ?> (<span style="color: red;">*</span>)</label>
            <div class="col-sm-6">
                <?php echo form_input(array('name' => 'email', 'id' => 'inputemail', 'class' => 'form-control', 'value' => $email, 'placeholder' => __('IP_email'))); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="inputtel" class="col-sm-2 control-label"><?php echo __('IP_tel'); ?> (<span style="color: red;">*</span>)</label>
            <div class="col-sm-6">
                <?php echo form_input(array('name' => 'tel', 'id' => 'inputtel', 'class' => 'form-control', 'value' => $tel, 'placeholder' => __('IP_tel'))); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="inputaddress" class="col-sm-2 control-label"><?php echo __('IP_address'); ?> (<span style="color: red;">*</span>)</label>
            <div class="col-sm-6">
                <?php echo form_input(array('name' => 'address', 'id' => 'inputaddress', 'class' => 'form-control', 'value' => $address, 'placeholder' => __('IP_address'))); ?>
            </div>
        </div>

        <!--            <div class="form-group">
                        <label for="reserve_time" class="col-sm-2 control-label"><?php // echo __('IP_cart_time');  ?> (<span style="color: red;">*</span>)</label>
                        <div class="col-sm-6">
        <?php // echo form_input(array('id' => 'reserve_time', 'name' => 'reserve_time','class' => 'form-control', 'value' => $time, 'placeholder' => __('IP_time'))); ?>
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label for="inputpay" class="col-sm-2 control-label"><?php echo __('IP_cart_kind');  ?> (<span style="color: red;">*</span>)</label>
                        <div class="col-sm-6">
        <?php echo form_dropdown('kind_pay', $kind_pay, '1','class="form-control"');?>
                        </div>
                    </div>

        <div class="form-group">
            <label for="inputmessage" class="col-sm-2 control-label"><?php echo __('IP_message'); ?></label>
            <div class="col-sm-6">
                <?php echo form_textarea(array('name' => 'message', 'id' => 'inputmessage', 'class' => 'form-control', 'value' => $message, 'placeholder' => __('IP_message'))); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="inputsubmit" class="col-sm-2 control-label"></label>
            <div class="col-sm-6">
                <input type="reset" value="<?php echo __('IP_reset'); ?>" class="btn btn-primary" />
                <?php echo form_submit(array('name' => 'btnSubmit', 'value' => __('IP_cart_shopping_submit'), 'class' => 'btn btn-warning')); ?>    
            </div>
        </div>
        <?php echo form_close(); ?>
    <?php endif; ?>

</div>
