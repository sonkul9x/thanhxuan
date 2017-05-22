<?php 
echo form_open($submit_uri); 
if (isset($id)) {echo form_hidden('id', $id);}
$label = isset($label) ? $label : '';
$module = isset($module) ? $module : '';
$submit_uri = isset($submit_uri) ? $submit_uri : '';
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Vai trò người dùng"</small>
    <span class="fright"><a class="button close" href="<?php echo AUTH_ROLES_MENUS_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <table>
        <tr><td class="title">Label: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'label', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $label)); ?></td>
        </tr>
        <tr><td class="title">Module: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'module', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $module)); ?></td>
        </tr>
        <tr><td class="title">Đường dẫn (dùng để check ẩn menu trong admin panel):</td></tr>
        <tr>
            <td><?php echo form_textarea(array('name' => 'url_path', 'cols' => '90', 'rows' => '3', 'maxlength' => '500', 'style' => 'width:560px;', 'value' => $url_path)); ?></td>
        </tr>
        <tr><td class="hint">Cách nhau bởi dấu phẩy (,).</td></tr>
    </table>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
    <input type="reset" value="Làm lại" class="btn" />
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>