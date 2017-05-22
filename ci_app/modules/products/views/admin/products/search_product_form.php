<div class="filter">    
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td>
                <form method="post" action ="<?php echo PRODUCTS_ADMIN_BASE_URL; ?>">
                    <span class="display_status">Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?></span>
                    Từ khóa: <input name="product_name" value="<?php echo str_replace('\\', '', $search); ?>" />
                    Phân loại: <?php if(isset($categories_combo)) echo $categories_combo; ?>
                    <input type="Submit" name ="btnSearch" value="Tìm kiếm" class="btn"/>
                </form>
            </td>
            <td style="width: 300px;">
                <?php echo form_hidden('submit_url','/do_sort_products_list'); ?>
                <?php echo form_hidden('redirect_url',PRODUCTS_ADMIN_BASE_URL); ?>
                Sắp xếp: <?php if (isset($sort_combobox)) echo $sort_combobox; ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>