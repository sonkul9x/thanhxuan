<div class="page_header" id="form">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm bộ videos"</small>
    <span class="fright">
        <a class="button close" href="<?php echo VIDEOS_ADMIN_BASE_URL;?>"><em>&nbsp;</em>Đóng</a>
    </span>
    <br class="clear"/>
</div>
<div class="form_content" id="form_add">
<?php echo form_open(VIDEOS_ADMIN_ADD_URL);?>

<table>
    <?php $this->load->view('powercms/message'); ?>
    <tr><td class="title">Tên bộ videos: (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => set_value('title'))); ?></td>
    </tr>
    <tr>
        <td style="margin-bottom: 10px;">
            <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Thêm', 'class' => 'btn')); ?>
        </td>
    </tr>
</table>

<?php echo form_close();?>
</div>
