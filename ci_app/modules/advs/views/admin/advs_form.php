<?php echo form_open_multipart($submit_uri); 
if (isset($id)) echo form_hidden('id', $id);
if (isset($action)) echo form_hidden('action', $action);
$url_path = isset($url_path) ? $url_path : '';
if(isset($image_name)){
    //form_hidden('image_name', $image_name);
    $image_name = ADVS_IMAGE_UPLOAD_URL.'thumbnails/'.$image_name;
    $image_avatar = '<img src="'.$image_name.'" style="position: absolute; margin-left: 20px;" />';
}else $image_avatar = "";
$submit_uri     = isset($submit_uri) ? $submit_uri : '';
echo form_hidden('form', 'advs_cat');
$check = (isset($timelimited) && $timelimited === STATUS_ACTIVE) ? 'checked' : '';
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm banner quảng cáo"</small>
    <span class="fright"><a class="button close" href="<?php echo ADVS_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <table>
        <tr class="display_status_block"><td class="title">Ngôn ngữ: </td></tr>
        <tr class="display_status_block">
            <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
        </tr>
        
        <tr><td class="title">Phân loại banner: (<span>*</span>)</td></tr>
        <tr>
            <td id="category"><?php if (isset($categories_combobox)) echo $categories_combobox; ?></td>
        </tr>

        <tr><td class="title">Chọn hình: <!-- (<span>*</span>) --></td></tr>
        <tr>
            <td>
                <input id="image_name" name="userfile" type="file" value="" class="btn" />
                <?php echo $image_avatar; ?>
<!--                <input id="url_abs" name="image_name" value="<?php //echo $image_name; ?>" readonly size="30px" onchange="GetFilenameFromPath2('url_abs');" />
                <input class="btn" type="button" value="Chọn hình..." onclick="mcImageManager.browse({fields : 'url_abs'});"/>-->
                <i>(Định dạng jpg, jpeg, png. Dung lượng nhỏ hơn 1Mb. Tên ảnh và tên thư mục không dấu)</i><br />
            </td>
        </tr>
        
        <tr><td class="title">Tiêu đề: </td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'title', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $title)); ?></td>
        </tr>
        
        <tr><td class="title"  style="vertical-align: top">Mô tả ngắn: </td></tr>
        <tr>
            <td>
                <?php echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'cols' => '90', 'rows' => '3', 'style' => 'width:560px;', 'value' => $summary)); ?>
            </td>
        </tr>
        
        <tr><td class="title">Đường dẫn khi click vào ảnh: </td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'url_path', 'maxlength' => '500', 'style' => 'width:560px;', 'value' => $url_path)); ?></td>
        </tr>
        
        <tr><td class="title">Giới hạn thời gian: <input type="checkbox" value="<?php echo $timelimited; ?>" title="Time Limited" name="timelimited" id="timelimited" style="margin: 0 10px; height: 15px;" onclick="timelimited_check();" <?php echo $check;?> /></td></tr>
        <tr id="timelimited-area" <?php if(!$check){ ?>style="display: none;"<?php } ?>>
            <td>
                <table>
                    <tr><td class="title">Thời gian bắt đầu</td></tr>
                    <tr>
                        <td>
                        <div>
                            <?php echo form_input(array('id' => 'start_date_time', 'name' => 'start_time', 'size' => '50', 'maxlength' => '10', 'value' => $start_time)); ?>
                            <span style="color:#999;">(định dạng: Tháng/Ngày/Năm Giờ:Phút)</span>
                        </div>
                        </td>
                    </tr>
                    <tr><td class="title">Thời gian kết thúc</td></tr>
                    <tr>
                        <td>
                        <div>
                            <?php echo form_input(array('id' => 'end_date_time', 'name' => 'end_time', 'size' => '50', 'maxlength' => '10', 'value' => $end_time)); ?>
                            <span style="color:#999;">(định dạng: Tháng/Ngày/Năm Giờ:Phút)</span>
                        </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td>
                <div style="margin-top: 20px; ">
                <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
                <input type="reset" value="Làm lại" class="btn" />
                </div>
            </td>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>