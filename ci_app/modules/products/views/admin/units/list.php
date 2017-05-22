<?php
    $this->load->view('admin/units/nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', PRODUCTS_UNITS_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php // $this->load->view('admin/units/filter_form'); ?>
    <table class="list" style="width: 100%;margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 95%">ĐƠN VỊ TÍNH</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php 
        if(isset($units)){
        $i = 0;
        $last_id = 0;
        foreach($units as $index => $unit):
            $style = $i++ % 2 == 0 ? 'even' : 'odd';
            ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><?php echo $unit->name; ?></a></td>
            <td class="center">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $unit->id; ?>,'<?php echo PRODUCTS_UNITS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $unit->id; ?>,'<?php echo PRODUCTS_UNITS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>