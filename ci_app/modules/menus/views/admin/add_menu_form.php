<?php
echo form_open($submit_uri);
if (isset($menu_id)) echo form_hidden('id', $menu_id);
if (isset($parent_id)) echo form_hidden('parent_id', $parent_id);
if (isset($cat_id)) echo form_hidden('cat_id', $cat_id);
if (isset($back_url)) echo form_hidden('back_url', $back_url);
?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa menu cho trang web của bạn"</small>
    <span class="fright">
        <a class="button close" href="<?php echo MENUS_ADMIN_BASE_URL;?>"><em>&nbsp;</em>Đóng</a>
    </span>
    <br class="clear"/>
</div>

<div class="form_content">
    <table>
<?php $this->load->view('powercms/message'); ?>
        <tr class="display_status_block"><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>
        <tr class="display_status_block"><td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td></tr>
        <tr><td class="title">Tên menu: (<span>*</span>)</td></tr>
        <tr><td><?php echo form_input(array('name' => 'menu_name', 'size' => '35', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset($menu_name) ? $menu_name : set_value('menu_name'))); ?></td></tr>
        <tr><td class="title">Đường dẫn: (<span>*</span>)</td></tr>
        <tr><td><?php echo form_input(array('name' => 'url_path', 'size' => '35', 'maxlength' => '512', 'style' => 'width:560px;', 'value' => isset($url_path) ? $url_path : set_value('url_path'))); ?></td></tr>
        <tr><td class="title">Css:</td></tr>
        <tr><td><?php echo form_input(array('name' => 'css', 'size' => '35', 'style' => 'width:560px;', 'value' => isset($css) ? $css : set_value('css'))); ?></td></tr>
        <tr><td class="title">Chọn hình: </td></tr>
        <tr>
            <td>
            <input type="text" name="thumb" value="<?php echo $thumb; ?>" readonly size="30px" id="url_abs" onchange="GetFilenameFromPath2('url_abs');">
            <a href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs" class="btn iframe-btn" type="button"><input class="btn" type="button" value="Chọn hình..." /></a>
            <i>(Kích thước: 1000x195. Định dạng jpg, jpeg, png. Dung lượng nhỏ hơn 1Mb. Tên ảnh và tên thư mục không dấu)</i><br />
            </td>
        </tr>
        <tr><td class="title">Phân loại menu: (<span>*</span>)</td></tr>
        <tr><td><?php if (isset($menus_categories)) echo $menus_categories; ?></td></tr>
        <tr><td class="title">Vị trí: (<span>*</span>)</td></tr>
        <tr><td id="navigation_menus"><?php if (isset($navigation_menu)) echo $navigation_menu; ?></td></tr>
        
        <tr><td style="padding-top: 5px;">
            <input type="submit" name="submit" value="<?php echo $button_name; ?>" onclick="reload_selected();" class="btn" />
            &nbsp;<input type="reset" value="Làm lại" class="btn" />
        </td></tr>
    </table>
</div>
<br class="clear"/>&nbsp;
<?php echo form_close(); ?>