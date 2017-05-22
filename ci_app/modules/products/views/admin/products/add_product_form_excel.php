<div class="page_header" id="form">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Nhập sản phẩm bằng excel"</small>
    <span class="fright">
        <a class="button close" href="<?php echo PRODUCTS_ADMIN_BASE_URL;?>"><em>&nbsp;</em>Đóng</a>
    </span>
    <br class="clear"/>
</div>
<div class="form_content" id="form_add">
<?php echo form_open_multipart(PRODUCTS_ADMIN_IMPORT_URL);?>

<table>
    <?php $this->load->view('powercms/message'); ?>
    <tr><td class="title">Nhập sản phẩm bằng excel: (<span>*</span>)</td></tr>
    <tr>
        <td><input id="image_name" name="userfile" type="file" value="" class="btn" /></td>
    </tr>
    <tr>
        <td style="margin-bottom: 10px;">
            <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Thêm', 'class' => 'btn')); ?>
        </td>
    </tr>
</table>

<?php echo form_close();?>
</div>
