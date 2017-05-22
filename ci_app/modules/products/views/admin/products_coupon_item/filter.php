<div class="filter">
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td>
                <?php echo form_open('dashboard/products/coupon_item'); ?>
                Từ khóa: <?php echo form_input(array('name' => 'search', 'id' => 'search', 'maxlength' => '256', 'value' => $search)); ?>
                <input type="submit" name="submit" value="Tìm kiếm" class="btn" />
                <?php echo form_close(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>