<?php
    $this->load->view('admin/products_color/nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', PRODUCTS_COLOR_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <table class="list" style="width: 100%;margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left">TÊN MÀU</th>
            <th class="left">MÃ MÀU</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php 
        if(isset($products_color)){
        $stt = 0;
        foreach($products_color as $index => $value):
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
            ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><?php echo $value->name; ?></td>
            <td class="left">
                <div style="background: #<?php echo $value->code; ?>; width: 15px; height: 15px; border-radius: 15px; border: 1px solid #000; display: inline-block; vertical-align: bottom; "></div>
                <?php echo $value->code; ?>
            </td>
            <td class="center">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $value->id; ?>,'<?php echo PRODUCTS_COLOR_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $value->id; ?>,'<?php echo PRODUCTS_COLOR_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>