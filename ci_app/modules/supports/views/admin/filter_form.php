<div class="filter">
    <?php echo form_open('dashboard/supports/'); ?>
    <span class="display_status">Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?></span>
    <?php echo form_close(); ?>
</div>