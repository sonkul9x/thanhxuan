<?php 
echo form_open_multipart(DOWNLOAD_ADMIN_ADD_URL); 
?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm Files"</small>
    <span class="fright">
        <a class="button close" href="<?php echo DOWNLOAD_ADMIN_BASE_URL;?>"><em>&nbsp;</em>Đóng</a>
    </span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <div class="tab_container">
        <div class="tab_content">
            <!--<div class="title">Phân loại tài liệu: <?php // if (isset($categories_combobox)) echo $categories_combobox; ?></div>-->
            <div style="margin-top: 10px;">
                <input id="download_file_upload" name="file_upload" type="file" />
            </div>
            <input id="session_upload_file" name="session_upload" type="hidden" value="<?php echo session_id(); ?>" />
            <input id="process_url_file" name="process_url" type="hidden" value="/upload_file_download" />
            <br class="clear-both"/>
            <div id="download_file">
                <ul>
                    <?php if(isset($files)) echo $files;?>
                </ul>
            </div>
        </div>
    </div>
    <br class="clear">
    <div style="margin-top: 10px;"></div>
    <a href= "<?php echo DOWNLOAD_ADMIN_BASE_URL; ?>"><input type="button" name="btnSubmit" value="Hoàn thành" class="btn" /></a>
    <?php // echo form_submit(array('name' => 'btnSubmit', 'value' => 'Hoàn thành', 'class' => 'btn')); ?>
    <br class="clear">&nbsp;
</div>
<?php echo form_close(); ?>
