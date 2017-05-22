<div>
<fieldset style="overflow: hidden; display: none;" id="add_gallery">
        <?php echo form_open(GALLERY_ADMIN_ADD_URL);?>

        <table>
            <tr><td class="title">Tên bộ sưu tập: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'gallery_name', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => set_value('gallery_name'))); ?></td>
            </tr>
            <tr>
                <td>
                    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Thêm', 'class' => 'btn')); ?>
                </td>
            </tr>
        </table>

        <?php echo form_close();?>
</fieldset>
</div>