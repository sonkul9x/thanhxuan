<?php 
echo form_open_multipart($submit_uri); 
if (isset($gallery_id)) echo form_hidden('id', $gallery_id);
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'gallery_cat');
?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thay đổi thông tin về bộ sưu tập ảnh"</small>
    <span class="fright">
        <a class="button close" href="<?php echo GALLERY_ADMIN_BASE_URL;?>"><em>&nbsp;</em>Đóng</a>
    </span>
    <br class="clear"/>
</div>

<div id="sort_success">Vị trí ảnh đã được cập nhật</div>
<div id="add_caption_success">Tiêu đề ảnh đã được cập nhật</div>
<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <ul class="tabs">
        <li><a href="#tab1">Ảnh gallery</a></li>
        <li><a href="#tab2">Nội dung</a></li>
        <li><a href="#tab3">Meta data</a></li>
    </ul>
    
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <div style="margin-top: 10px;">
                <input id="file_upload" name="file_upload" type="file" />
            </div>
            <input id="session_upload" name="session_upload" type="hidden" value="<?php echo session_id(); ?>" />
            <input id="process_url" name="process_url" type="hidden" value="/upload_gallery_images" />
            <i>(Định dạng jpg, jpeg, png. Dung lượng nhỏ hơn 1Mb. Tên ảnh và tên thư mục không dấu)</i><br />
            <br class="clear-both"/>
            <div id="gallery_images">
                <ul>
                    <?php if(isset($images)) echo $images;?>
                </ul>
            </div>
        </div>
        
        <div id="tab2" class="tab_content">
            <table>
                <tr class="display_status_block"><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>
                <tr class="display_status_block"><td><?php if(isset($lang_combobox)) echo $lang_combobox;?></td></tr>
                <tr><td class="title">Tên bộ sưu tập: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_input(array('name' => 'gallery_name', 'size' => '30', 'maxlength' => '255', 'style' => 'width:560px;', 'onkeyup'=>'convert_to_slug(this.value);', 'value' => $gallery_name)); ?></td></tr>
                <?php if(SLUG_ACTIVE>0){ ?>
                <tr><td class="title">Slug (vd: ten-album-anh): (<span>*</span>)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'slug', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($slug) ? $slug : set_value('slug'))); ?></td>
                </tr>
                <?php } ?>
                <tr><td class="title">Phân loại: (<span>*</span>)</td></tr>
                <tr><td id="category"><?php echo $categories; ?></td></tr>
                <tr><td class="title">Mô tả ngắn: </td></tr>
                <tr><td><?php echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'size' => '50', 'maxlength' => '500', 'style' => 'width:560px; height: 80px;', 'value' =>  ($summary != '') ? $summary : set_value('summary'))); ?></td></tr>
                <tr><td class="title">Nội dung: </td></tr>
                <tr><td><?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg elm1')); ?></td></tr>
            </table>
        </div>
        
        <div id="tab3" class="tab_content">
            <table>
            <tr><td class="title">Meta title: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'style' => 'width:560px; height: 80px;', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
            </tr>

            <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '255', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                </td>
            </tr>

            <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
    <br class="clear">
    <div style="margin-top: 10px;"></div>
    <input type="submit" name="btnSubmit" value="<?php if(isset($button_name)) echo $button_name;?>" class="btn" />
    <input type="reset" value="Làm lại" class="btn" />
    <br class="clear">&nbsp;
</div>
<?php echo form_close(); ?>
