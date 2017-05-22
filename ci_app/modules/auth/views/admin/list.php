<?php
    $this->load->view('admin/nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', AUTH_USERS_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <!--<th class="left" style="width: 5%">ID</th>-->
            <th class="left" style="width: 25%">TÊN ĐĂNG NHẬP</th>
            <th class="left" style="width: 25%">HỌ TÊN</th>
            <th class="left" style="width: 10%">QUYỀN</th>
            <th class="left" style="width: 15%">EMAIL</th>
            <th class="center" style="width: 10%">ĐIỆN THOẠI</th>
            <th class="center" style="width: 5%">NGÀY TẠO</th>
            <th class="center" style="width: 5%">KÍCH HOẠT</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($users)){
        $stt = 0;
        foreach($users as $index => $user):
            $joined_date = get_vndate_string($user->joined_date);
            $check = $user->active == STATUS_ACTIVE ? 'checked' : '';
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
        ?>
        <tr class="<?php echo $style ?>">
            <!--<td><?php // echo $user->id; ?></td>-->
            <td style="white-space:nowrap;"><?php echo $user->username; ?></td>
            <td style="white-space:nowrap;"><?php echo $user->fullname; ?></td>
            <td style="white-space:nowrap;"><?php echo $user->roles_name; ?></td>
            <td style="white-space:nowrap;"><a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></td>
            <td class="center" style="white-space:nowrap;"><?php echo $user->tel; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $joined_date; ?></td>
            <td class="center" style="white-space:nowrap;"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $user->id;?>,'auth')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $user->id ?>,'<?php echo AUTH_USERS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $user->id ?>,'<?php echo AUTH_USERS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' người dùng</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>