<div class="filter">
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td>
                <?php echo form_open('dashboard/faq/'); ?>
                <span class="display_status">Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?></span>
                Từ khóa: <?php echo form_input(array('name' => 'search', 'id' => 'search', 'maxlength' => '256', 'value' => $search)); ?>
                Phân loại: <?php if (isset($categories_combobox)) echo $categories_combobox; ?>
                <input type="submit" name="submit" value="Tìm kiếm" class="btn" />
                <?php echo form_close(); ?>
            </td>
            <td style="width: 250px;">
                <?php echo form_hidden('submit_url','/do_sort_faq_list'); ?>
                <?php echo form_hidden('redirect_url',FAQ_ADMIN_BASE_URL); ?>
                Sắp xếp: <?php if (isset($sort_combobox)) echo $sort_combobox; ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
