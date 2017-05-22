<?php echo form_open($submit_uri); 
if (isset($id)) echo form_hidden('id', $id);
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'download_cat');
?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa phân loại Files"</small>
    <span class="fright"><a href="<?php echo DOWNLOAD_CAT_ADMIN_BASE_URL; ?>" class="button close" style="padding:5px;" title="Đóng"><em></em><span>Đóng</span></a></span>
    <br class="clear"/>
</div>

<div class="form_content">
<?php $this->load->view('powercms/message'); ?>
<table>
    <tr class="display_status_block"><td class="title">Ngôn ngữ: </td></tr>
    <tr class="display_status_block">
        <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
    </tr>
    <tr><td class="title">Tên phân loại: (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'onkeyup'=>'convert_to_slug(this.value);', 'value' => isset ($title) ? $title : set_value('title'))); ?></td>
    </tr>
    <?php if(SLUG_ACTIVE>0){ ?>
    <tr><td class="title">Slug (vd: phan-loai): (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'slug', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($slug) ? $slug : set_value('slug'))); ?></td>
    </tr>
    <?php } ?>
    <tr><td class="title">Thuộc phân loại:</td></tr>
    <tr>
        <?php echo form_hidden('is_add_edit_category', TRUE);?>
        <?php echo form_hidden('form', 'download_cat');?>
        <td id="category"><?php if (isset($categories_combobox)) echo $categories_combobox; ?></td>
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