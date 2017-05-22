<span class="fright">
    <?php if($this->phpsession->get('menu_type') == FRONT_END_MENU):?>
    <a class="button close" href="/dashboard/menu/<?php echo isset($lang) && $lang != '' ? $lang :$this->phpsession->get('current_menus_lang'); ?>"><em>&nbsp;</em>Đóng</a>
    <?php endif;?>
    <?php if($this->phpsession->get('menu_type') == BACK_END_MENU):?>
    <a class="button close" href="<?php echo MENUS_ADMIN_BASE_URL; ?>" ><em>&nbsp;</em>Đóng</a>
    <?php endif;?>
</span>