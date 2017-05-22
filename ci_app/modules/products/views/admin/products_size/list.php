<?php
    $this->load->view('admin/products_size/nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', PRODUCTS_SIZE_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <table class="list" style="width: 100%;margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left">KÍCH CỠ</th>
            <!--<th class="left">ĐƯỜNG DẪN</th>-->
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php 
        if(isset($products_size)){
        $stt = 0;
        foreach($products_size as $index => $value):
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
//            $uri = '/'.PRODUCTS_SIZE_SLUG.$value->name;
//            $url = get_base_url().PRODUCTS_SIZE_SLUG.$value->name;
            ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><?php echo $value->name; ?></td>
            <!--<td class="left"><a href="<?php // echo $url; ?>"><?php // echo $uri; ?></a></td>-->
            <td class="center">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $value->id; ?>,'<?php echo PRODUCTS_SIZE_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $value->id; ?>,'<?php echo PRODUCTS_SIZE_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>