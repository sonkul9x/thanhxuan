<?php echo form_open($submit_uri); if (isset($id)) echo form_hidden('id', $id);?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa phân loại banners quảng cáo"</small>
    <span class="fright"><a href="<?php echo ADVS_CAT_ADMIN_BASE_URL; ?>" class="button close" style="padding:5px;" title="Đóng"><em></em><span>Đóng</span></a></span>
    <br class="clear"/>
</div>

<div class="form_content">
<?php $this->load->view('powercms/message'); ?>
<table>
    <tr><td class="title">Tên phân loại: (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($title) ? $title : set_value('title'))); ?></td>
    </tr>
    <tr><td class="title">Kích cỡ (widthxheight vd: 800x600):</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'dimension', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($dimension) ? $dimension : set_value('dimension'))); ?></td>
    </tr>
    <tr>
        <td style="padding-top: 10px;">
            <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
            <input type="reset" value="Làm lại" class="btn" />
        </td>
    </tr>
</table>
<br class="clear"/>&nbsp;    
</div>
<?php echo form_close(); ?>