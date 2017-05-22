<div class="filter">
    <form method="post" action ="<?php echo VIDEOS_ADMIN_BASE_URL; ?>">
        <span class="display_status">Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?></span>
        Từ khóa: <input name="gallery_name" value="<?php echo str_replace('\\', '', $search); ?>" />
        Phân loại: <?php if(isset($categories_combo)) echo $categories_combo; ?>
        <input type="Submit" name ="btnSearch" value="Tìm kiếm" class="btn"/>
    </form>
</div>