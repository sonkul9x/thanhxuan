<div class="filter">
    <?php echo form_open('dashboard/orders/'); ?>
    <!--Ngôn ngữ:--> <?php // if (isset($lang_combobox)) echo $lang_combobox; ?>
    Tên khách hàng: <?php echo form_input(array('name' => 'search', 'id' => 'search', 'maxlength' => '256', 'value' => $search, 'style'=>'width: 125px;' )); ?>
    
    Trạng thái đơn hàng: <?php if (isset($combo_order)) echo $combo_order; ?>
    
    Từ ngày: <?php echo form_input(array('id' => 'news_created_date', 'name' => 'start_date', 'size' => '50', 'maxlength' => '10', 'value' => $start_date, 'style'=>'width: 125px;')); ?>
    
    Đến ngày: <?php echo form_input(array('id' => 'end_day_date', 'name' => 'end_date', 'size' => '50', 'maxlength' => '10', 'value' => $end_date, 'style'=>'width: 125px;')); ?>
    
    <input type="submit" name="submit" value="Tìm kiếm" class="btn" />
    <span class="fright"><a class="button" href="/dashboard/orders/export"><em>&nbsp;</em>Xuất excel</a></span>
    <?php echo form_close(); ?>
 
</div>
