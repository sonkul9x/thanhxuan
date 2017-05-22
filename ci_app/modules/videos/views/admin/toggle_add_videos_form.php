<div>
<fieldset style="overflow: hidden; display: none;" id="add_videos">
        <?php echo form_open(VIDEOS_ADMIN_ADD_URL);?>

        <table>
            <tr><td class="title">Tên video: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => set_value('title'))); ?></td>
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