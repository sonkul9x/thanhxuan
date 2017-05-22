<?php
echo form_open($submit_uri); if (isset($id)) echo form_hidden('id', $id);
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa đơn vị"</small>
    <span class="fright"><a href="<?php echo PRODUCTS_UNITS_ADMIN_BASE_URL; ?>" class="button close" style="padding:5px;" title="Đóng"><em></em><span>Đóng</span></a></span>
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
            <tr><td class="title">Tên đơn vị: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'unit', 'size' => '50', 'maxlength' => '15', 'style' => 'width:200px;', 'value' => isset ($unit) ? $unit : set_value('unit'))); ?>
                    <?php echo form_hidden('is_add_edit_unit', TRUE);?>
                    <?php echo form_hidden('form', 'units_form');?>
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