<?php
    $this->load->view('cat/cat_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo form_hidden('back_url', MENUS_CAT_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php // $this->load->view('cat/filter_form'); ?>
    <table class="list" style="width: 100%; margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 5%">ID</th>
            <th class="left" style="width: 90%">PHÂN LOẠI</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php
        if(isset($categories)){
        $i = 0;
        $padding = '';
        $last_id = 0;
        foreach($categories as $index => $cat):
            $style = $i++ % 2 == 0 ? 'even' : 'odd';
        ?>
        <tr class="<?php echo $style;?>">
            <td><?php echo $cat->id;?></td>
            <td class="left"><?php echo $cat->name; ?></td>
            <td class="center">
                <a class="edit" title="Sửa phân loại này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo MENUS_CAT_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa phân loại này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo MENUS_CAT_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>