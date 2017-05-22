<?php 
echo form_open($submit_uri); 
if (isset($id)) echo form_hidden('id', $id);
$title          = isset($title) ? $title : '';
$thumb          = isset($thumb) ? $thumb : '';
$summary        = isset($summary) ? $summary : '';
$content        = isset($content) ? $content : '';
$fullname       = isset($fullname) ? $fullname : '';
$email          = isset($email) ? $email : '';
$tel          = isset($tel) ? $tel : '';
$address          = isset($address) ? $address : '';
$created_date   = isset($created_date) ? $created_date : '';
$submit_uri     = isset($submit_uri) ? $submit_uri : '';
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'faq_cat');
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Nội dung hỏi đáp"</small>
    <span class="fright"><a class="button close" href="<?php echo FAQ_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
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
                <tr><td class="title">Tiêu đề: (<span>*</span>)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'onkeyup'=>'convert_to_slug(this.value);', 'value' => $title)); ?></td>
                </tr>
                <?php if(SLUG_ACTIVE>0){ ?>
                <tr><td class="title">Slug (vd: ten-bai-viet): (<span>*</span>)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'slug', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($slug) ? $slug : set_value('slug'))); ?></td>
                </tr>
                <?php } ?>
                <tr><td class="title">Họ tên (Người đặt câu hỏi): (<span>*</span>)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $fullname)); ?></td>
                </tr>
                <tr><td class="title">Email: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $email)); ?></td>
                </tr>
                <tr><td class="title">Điện thoại: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '20', 'style' => 'width:560px;', 'value' => $tel)); ?></td>
                </tr>
                <tr><td class="title">Địa chỉ: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'address', 'size' => '50', 'maxlength' => '500', 'style' => 'width:560px;', 'value' => $address)); ?></td>
                </tr>
                <tr><td class="title">Phân loại: (<span>*</span>)</td></tr>
                <tr>
                    <td id="category"><?php if (isset($categories_combobox)) echo $categories_combobox; ?></td>
                </tr>
                <tr><td class="title">Chọn hình minh họa: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                    <input type="text" name="thumb"  value="<?php echo $thumb;?>" readonly size="30px" id="url_abs" onchange="GetFilenameFromPath();">
                    <a href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs" class="btn iframe-btn" type="button"><input class="btn" type="button" value="Chọn hình..." /></a>
                    <i>(Định dạng jpg, jpeg, png. Dung lượng nhỏ hơn 1Mb. Tên ảnh và tên thư mục không dấu)</i><br />
                    </td>
                </tr>
                <tr><td class="title"  style="vertical-align: top">Nội dung câu hỏi: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'cols' => '90', 'rows' => '3', 'style' => 'width:560px;', 'value' => $summary)); ?>
                    </td>
                </tr>
                <tr><td class="title" style="vertical-align: top">Nội dung trả lời: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg elm1')); ?>
                    </td>
                </tr>
                <tr><td class="title">Ngày đăng: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php echo form_input(array('id' => 'news_created_date', 'name' => 'created_date', 'size' => '50', 'maxlength' => '10', 'value' => $created_date)); ?>
                        <span style="color:#999;">(định dạng: dd-mm-yyyy)</span>
                    </td>
                </tr>
            </table>
        </div>
        <div id="tab2" class="tab_content">
            <table>
                <tr><td class="title">Meta title: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '256', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                    </td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                    </td>
                </tr>
				<tr><td class="title">Tags:</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'tags', 'size' => '50', 'style' => 'width:560px;', 'value' => $tags)); ?></td>
                </tr>
                <tr><td class="hint">Mỗi tag cách nhau bởi dấu phấy.</td></tr>
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