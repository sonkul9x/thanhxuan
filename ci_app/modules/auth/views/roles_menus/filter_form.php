<div class="filter">
    <?php echo form_open(AUTH_ROLES_MENUS_ADMIN_BASE_URL); ?>
    Từ khóa: <?php echo form_input(array('name' => 'search', 'id' => 'search', 'maxlength' => '255', 'value' => $search)); ?>
        
    <input type="submit" name="submit" value="Tìm kiếm" class="btn" />
    <?php echo form_close(); ?>
</div>
