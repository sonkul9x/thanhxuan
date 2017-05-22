<?php 
echo form_open($submit_uri); 
if (isset($id)) echo form_hidden('id', $id);
$title          = isset($title) ? $title : '';
$thumb          = isset($thumb) ? $thumb : '';
$summary        = isset($summary) ? $summary : '';
//$content        = isset($content) ? $content : '';
$submit_uri     = isset($submit_uri) ? $submit_uri : '';
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'faq_pro');
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Nội dung chuyên gia"</small>
    <span class="fright"><a class="button close" href="<?php echo FAQ_PRO_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>

    <ul class="tabs">
            <li><a href="#tab1">Nội dung</a></li>
            <li><a href="#tab2">Meta data</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
                <tr class="display_none"><td class="title">Ngôn ngữ: </td></tr>
                <tr class="display_none">
                    <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
                </tr>
                <tr><td class="title">Tên: (<span>*</span>)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $title)); ?></td>
                </tr>
                <tr><td class="title">Chọn hình minh họa: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                    <input type="text" name="thumb"  value="<?php echo $thumb;?>" readonly size="30px" id="url_abs" onchange="GetFilenameFromPath();">
                    <a href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs" class="btn iframe-btn" type="button"><input class="btn" type="button" value="Chọn hình..." /></a>
                    <i>(Định dạng jpg, jpeg, png. Dung lượng nhỏ hơn 1Mb. Tên ảnh và tên thư mục không dấu)</i><br />
                    </td>
                </tr>
                <tr><td class="title"  style="vertical-align: top">Mô tả: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'cols' => '90', 'rows' => '3', 'style' => 'width:560px;', 'value' => $summary)); ?>
                    </td>
                </tr>
<!--                <tr><td class="title" style="vertical-align: top">Nội dung: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php // echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg elm1')); ?>
                    </td>
                </tr>-->
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