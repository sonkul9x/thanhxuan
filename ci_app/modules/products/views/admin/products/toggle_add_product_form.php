<div>
<fieldset style="overflow: hidden; display: none;" id="add_product">
        <?php echo form_open(PRODUCTS_ADMIN_ADD_URL);?>

        <table>
            <tr><td class="title">Tên sản phẩm: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'product_name', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => set_value('product_name'))); ?></td>
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
<div>
<fieldset style="overflow: hidden; display: none;" id="add_product_excel">
        <?php echo form_open_multipart(PRODUCTS_ADMIN_IMPORT_URL);?>

        <table>
            <tr><td class="title">Nhập sản phẩm bằng excel: (<span>*</span>)</td></tr>
            <tr>
                <td>
                    <input id="image_name" name="userfile" type="file" value="" class="btn" />
                </td>
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