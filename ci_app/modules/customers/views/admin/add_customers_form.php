<?php
echo form_open($submit_uri);
if (isset($id))
    echo form_hidden('id', $id);
$fullname = isset($fullname) ? $fullname : '';
$email = isset($email) ? $email : '';
$created_date = isset($created_date) ? $created_date : '';
$submit_uri = isset($submit_uri) ? $submit_uri : '';
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'customers_cat');
?>
<div class="page_header">
    <h1 class="fleft"><?php if (isset($header)) echo $header; ?></h1>
    <small class="fleft">"Chi tiết khách hàng"</small>
    <span class="fright"><a class="button close" href="<?php echo CUSTOM_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>

    <ul class="tabs">
        <li><a href="#tab1">Thông tin khách hàng</a></li>
     
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
            
                <tr><td class="title">Họ tên khách hàng:</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $fullname)); ?></td>
                </tr>
                <tr><td class="title">Số điện thoại (Người order):</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'phone', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $phone)); ?></td>
                </tr>
                <tr><td class="title">Email: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $email)); ?></td>
                </tr>
                <tr><td class="title">Địa chỉ giao hàng:</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'address', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $address)); ?></td>
                </tr>
                <tr><td class="title">Ngày tạo: </td></tr>
                <tr>
                    <td>
                        <?php echo form_input(array('name' => 'created_date', 'readonly'=>TRUE,'size' => '50', 'maxlength' => '10', 'value' => $created_date)); ?>

                    </td>
                </tr>
            </table>
        </div>
   
    </div>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
   
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>