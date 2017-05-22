<?php 
echo form_open($submit_uri); 
if (isset($id)) echo form_hidden('id', $id);
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'products_coupon');
?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa Mã coupon"</small>
    <span class="fright"><a href="<?php echo PRODUCTS_COUPON_ADMIN_BASE_URL; ?>" class="button close" style="padding:5px;" title="Đóng"><em></em><span>Đóng</span></a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <ul class="tabs">
        <li><a href="#tab1">Nội dung</a></li>
    </ul>
<div class="tab_container">
    <div id="tab1" class="tab_content">
        <table>
            <tr><td class="title">Tên coupon: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'name', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($name) ? $name : set_value('name'))); ?></td>
            </tr>
            <tr><td class="title">Giảm giá: (<span>*</span>)</td></tr>
            <tr>
                <td>
                    <?php echo form_input(array('name' => 'discount', 'size' => '50', 'maxlength' => '255', 'style' => 'width:160px;', 'value' => isset ($discount) ? $discount : set_value('discount'))); ?>
                    <?php echo form_dropdown('discount_type', array('1'=>'% giảm giá mỗi đơn hàng','2'=>'giảm giá mỗi đơn hàng'), !empty($discount_type)?$discount_type:1,'style="max-width: none ! important; width: 390px;" class="btn"'); ?>
                </td>
            </tr>
            <tr><td class="title">Số tiền tối thiểu của đơn hàng: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'price_min', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($price_min) ? $price_min : set_value('price_min'))); ?></td>
            </tr>
<!--            <tr><td class="title">Số lần sử dụng: (<span>*</span>)</td></tr>
            <tr>
                <td><?php // echo form_input(array('name' => 'number', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($number) ? $number : set_value('number'))); ?></td>
            </tr>-->
            <?php if(empty($is_edit)){ ?>
            <tr><td class="title">Số lượng mã: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'count', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($count) ? $count : set_value('count'))); ?></td>
            </tr>
            <?php } ?>
            <tr><td class="title">Ngày hết hạn: (<span>*</span>)</td></tr>
            <tr>
                <td>
                    <?php echo form_input(array('id' => 'news_created_date', 'name' => 'end_date', 'size' => '50', 'maxlength' => '10', 'value' => isset($end_date) ? $end_date : '')); ?>
                    <span style="color:#999;">(định dạng: dd-mm-yyyy)</span>
                </td>
            </tr>
        </table>
    </div>

</div>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
    <input type="reset" value="Làm lại" class="btn" />
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>