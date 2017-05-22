<?php echo form_open($submit_uri); if (isset($id)) echo form_hidden('id', $id); ?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm thông tin hỗ trợ trực tuyến"</small>
    <span class="fright"><a class="button close" href="<?php echo SUPPORTS_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <table>
        <tr class="display_status_block"><td class="title">Ngôn ngữ: </td></tr>
        <tr class="display_status_block">
            <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
        </tr>
        <tr><td class="title">Tên người hỗ trợ: </td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '50', 'style' => 'width:260px;', 'value' => $title)); ?></td>
        </tr>
        <tr><td class="title">Loại: (<span>*</span>)</td></tr>
        <tr>
            <td>
                <input type="radio" name="type" value="1" <?php if($type == YAHOO) echo 'checked';?> />Yahoo&nbsp;
                <input type="radio" name="type" value="2" <?php if($type == SKYPE) echo 'checked';?> />Skype&nbsp;
                <input type="radio" name="type" value="3" <?php if($type == TELEPHONE || $type == '') echo 'checked';?> />Điện thoại&nbsp;
                <!--<input type="radio" name="type" value="4" <?php // if($type == TEXT) echo 'checked';?> />Text&nbsp;-->
            </td>
        </tr>
        <tr><td class="title" style="vertical-align: top">Tài khoản: (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_input(array('name' => 'content', 'maxlength' => '50', 'style' => 'width:260px;', 'value' => $content)); ?>
            </td>
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
