<div class="filter">
    <?php echo form_open('dashboard/advs/'); ?>
    <span class="display_status">Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?></span>
    Phân loại banner: <?php if (isset($categories_combobox)) echo $categories_combobox; ?>
    <input type="submit" name="submit" value="Tìm kiếm" class="btn" />
    <?php echo form_close(); ?>
</div>