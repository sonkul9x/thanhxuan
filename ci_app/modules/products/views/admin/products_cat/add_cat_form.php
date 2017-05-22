<?php 
echo form_open($submit_uri); 
if (isset($id)) echo form_hidden('id', $id);
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'products_cat');
?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa phân loại sản phẩm"</small>
    <span class="fright"><a href="<?php echo PRODUCTS_CAT_ADMIN_BASE_URL; ?>" class="button close" style="padding:5px;" title="Đóng"><em></em><span>Đóng</span></a></span>
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
            <tr class="display_status_block"><td class="title">Ngôn ngữ: </td></tr>
            <tr class="display_status_block">
                <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
            </tr>
            <tr><td class="title">Tên phân loại: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'category', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'onkeyup'=>'convert_to_slug(this.value);', 'value' => isset ($category) ? $category : set_value('category'))); ?></td>
            </tr>
            <?php if(SLUG_ACTIVE>0){ ?>
            <tr><td class="title">Slug (vd: phan-loai): (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'slug', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($slug) ? $slug : set_value('slug'))); ?></td>
            </tr>
            <?php } ?>
            <tr><td class="title">Thuộc phân loại:</td></tr>
            <tr>
                <td id="category"><?php if (isset($categories_combobox)) echo $categories_combobox; ?></td>
            </tr>
<!--            <tr><td class="title">Chọn hình minh họa: </td></tr>
            <tr>
                <td>
                <input type="text" name="thumb"  value="<?php // echo $thumb;?>" readonly size="30px" id="url_abs" onchange="GetFilenameFromPath2('url_abs');">
                <a href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs" class="btn iframe-btn" type="button"><input class="btn" type="button" value="Chọn hình..." /></a>
                <i>(Kích thước 400x400. Định dạng jpg, jpeg, png. Dung lượng nhỏ hơn 1Mb. Tên ảnh và tên thư mục không dấu)</i><br />
                </td>
            </tr>-->
<!--            <tr><td class="title">Chọn hình đại diện: </td></tr>
            <tr>
                <td>
                <input type="text" name="avatar"  value="<?php // echo $avatar;?>" readonly size="30px" id="url_abs2" onchange="GetFilenameFromPath2('url_abs2');">
                <a href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs2" class="btn iframe-btn" type="button"><input class="btn" type="button" value="Chọn hình..." /></a>
                <i>(Kích thước 307x85, đặt tên ảnh và tên thư mục không dấu)</i>
                </td>
            </tr>-->
<!--            <tr><td class="title"  style="vertical-align: top">Mô tả ngắn: </td></tr>
            <tr>
                <td>
                    <?php // echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'cols' => '90', 'rows' => '3', 'style' => 'width:560px;', 'value' => isset ($summary) ? $summary : set_value('summary'))); ?>
                </td>
            </tr>-->
<!--            <tr><td class="title" style="vertical-align: top">Nội dung: </td></tr>
            <tr>
                <td>
                    <?php // echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg elm1')); ?>
                </td>
            </tr>-->
        </table>
    </div>

    <div id="tab2" class="tab_content">
        <table>
            <tr><td class="title">Meta title: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
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
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
    <input type="reset" value="Làm lại" class="btn" />
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>