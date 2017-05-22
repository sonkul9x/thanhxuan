<div class="filter">
    <?php echo form_open('dashboard/customers/'); ?>
    <!--Ngôn ngữ:--> <?php // if (isset($lang_combobox)) echo $lang_combobox; ?>
    Tên khách hàng: <?php echo form_input(array('name' => 'search', 'id' => 'search', 'maxlength' => '256', 'value' => $search, 'style'=>'width: 125px;' )); ?>

    <input type="submit" name="submit" value="Tìm kiếm" class="btn" />
    <span class="fright"><a class="button" href="/dashboard/customers/export"><em>&nbsp;</em>Xuất excel</a></span>
    <?php echo form_close(); ?>
 
</div>
