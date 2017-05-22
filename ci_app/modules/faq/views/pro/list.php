<?php
    $this->load->view('pro/nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', FAQ_PRO_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('pro/filter'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 0%">&nbsp;</th>
            <th class="left">TÊN</th>
            <th class="center" style="width: 5%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($faq_professionals)){
        $stt = 0;
        foreach($faq_professionals as $index => $value):
            $check          = $value->status == STATUS_ACTIVE ? 'checked' : '';
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
            $this_lang = ($value->lang<>DEFAULT_LANGUAGE)?'/'.$value->lang:'';
        ?>
        <tr class="<?php echo $style ?>">
            <td><img src="<?php echo $value->thumbnail;?>" style="height: 20px;"/></td>
            <td><?php echo $value->title; ?></td>
            <td class="center" style="white-space:nowrap;"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $value->id;?>,'faq/pro')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $value->id ?>,'<?php echo FAQ_PRO_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $value->id ?>,'<?php echo FAQ_PRO_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Lên trên" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $value->id ?>,'<?php echo FAQ_PRO_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' bài viết</span>)'; ?>
        <tr class="list-footer">
            <th colspan="4">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>