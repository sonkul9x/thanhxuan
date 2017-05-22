<div class="filter"> 
    <?php echo form_open('dashboard/menus/'); ?>
    <span class="display_status">Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?></span>
    Phân loại Menu: <?php if (isset($menus_categories)) echo $menus_categories; ?>
    <input type="submit" name="submit" value="Tìm kiếm" class="btn" />
    <?php echo form_close(); ?>
</div>