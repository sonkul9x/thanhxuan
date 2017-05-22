<?php 
echo form_open_multipart($submit_uri); 
if (isset($video_id)) echo form_hidden('id', $video_id);
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'videos_cat');
?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thay đổi thông tin về videos"</small>
    <span class="fright">
        <a class="button close" href="<?php echo VIDEOS_ADMIN_BASE_URL;?>"><em>&nbsp;</em>Đóng</a>
    </span>
    <br class="clear"/>
</div>

<div id="sort_success">Vị trí đã được cập nhật</div>
<div id="add_caption_success">Tiêu đề đã được cập nhật</div>
<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <ul class="tabs">
        <li><a href="#tab1">Nội dung</a></li>
        <li><a href="#tab2">Meta data</a></li>
    </ul>
    
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
                <tr style="display: none;"><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>
                <tr style="display: none;"><td><?php if(isset($lang_combobox)) echo $lang_combobox;?></td></tr>
                <tr><td class="title">Tên video: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_input(array('name' => 'title', 'size' => '30', 'maxlength' => '255', 'style' => 'width:560px;', 'onkeyup'=>'convert_to_slug(this.value);', 'value' => $title)); ?></td></tr>
                <?php if(SLUG_ACTIVE>0){ ?>
                <tr><td class="title">Slug (vd: ten-album-video): (<span>*</span>)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'slug', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($slug) ? $slug : set_value('slug'))); ?></td>
                </tr>
                <?php } ?>
                <tr><td class="title">Phân loại: (<span>*</span>)</td></tr>
                <tr><td id="category"><?php echo $categories; ?></td></tr>
                <tr><td class="title">Mô tả ngắn: </td></tr>
                <tr><td><?php echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'size' => '50', 'maxlength' => '500', 'style' => 'width:560px; height: 80px;', 'value' =>  ($summary != '') ? $summary : set_value('summary'))); ?></td></tr>
            </table>
            <div style="margin-top: 10px;">
                <h5>Đường dẫn video (youtube, ví dụ: http://www.youtube.com/watch?v=abcde-ghjkl):</h5>
                <?php echo form_input(array('name' => 'url', 'id' => 'video_item_url' , 'size' => '30', 'maxlength' => '500', 'style' => 'width:460px; margin: 10px 0;')); ?>
                <input type="button" value="Thêm video" class="btn" onclick="add_video();" />
            </div>
            <br class="clear-both"/>
            <div id="videos_items">
                <ul>
                    <?php if(isset($items)) echo $items;?>
                </ul>
            </div>
        </div>

        <div id="tab2" class="tab_content">
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
