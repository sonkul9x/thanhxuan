<?php
    $this->load->view('admin/support_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', SUPPORTS_ADMIN_BASE_URL);
    echo form_close();
?>

<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 25%">TÀI KHOẢN HỖ TRỢ</th>
            <th class="left" style="width: 60%">TÊN NGƯỜI HỖ TRỢ</th>
            <th class="center" style="width: 5%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php 
        if(isset($supports)){
        $stt = 0;
        foreach($supports as $index => $support): 
        switch ($support->type){
            case YAHOO :
                $content ='<a rel="nofollow" href="ymsgr:sendIM?' . $support->content . '">
                <img align="absmiddle" vspace="2" hspace="2" border="0" alt="" src="http://opi.yahoo.com/online?u=' . $support->content . '">&nbsp;' . $support->content .
                '</a>'; break;
            case SKYPE :
                $content = '<a href="skype:' . $support->content . '?call">
                <img src="http://mystatus.skype.com/smallicon/' . $support->content .'" style="border: none;" alt="My status" />&nbsp;' . $support->content .
                '</a>'; break;
            case TELEPHONE :
                $content = '<a href="#">
                <img src="/powercms/images/con_tel.png" style="border: none;" alt="Telephone" />&nbsp;' . $support->content .
                '</a>'; break;
            case TEXT :
                $content = $support->content; break;
                
        }
        $style = $stt++ % 2 == 0 ? 'even' : 'odd';    
        $check = $support->status == STATUS_ACTIVE ? 'checked' : '';
        ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><?php echo $content; ?></td>
            <td class="left"><?php echo $support->title; ?></td>
            <td class="center" style="white-space:nowrap;"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $support->id;?>,'supports')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa hỗ trợ này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $support->id; ?>,'<?php echo SUPPORTS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa hỗ trợ này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $support->id; ?>,'<?php echo SUPPORTS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Cập nhật (up) lên đầu trang" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $support->id; ?>,'<?php echo SUPPORTS_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>