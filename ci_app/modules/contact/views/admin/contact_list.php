<?php
    $this->load->view('admin/contact_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', CONTACT_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php // $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 15%">HỌ TÊN</th>
            <!--<th class="left" style="width: 15%">CÔNG TY</th>-->
            <th class="left" style="width: 40%">TIN NHẮN</th>
            <th class="left" style="width: 20%">EMAIL</th>
            <th class="center" style="width: 10%">ĐIỆN THOẠI</th>
            <!--<th class="left" style="width: 5%">FAX</th>-->
            <!--<th class="center" style="width: 20%">ĐỊA ĐIỂM</th>-->
            <th class="center" style="width: 5%">NGÀY TẠO</th>
            <!--<th class="center" style="width: 5%">HIỂN THỊ</th>-->
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($contacts)){
        $stt = 0;
        foreach($contacts as $index => $contact):
        $created_date   = date('d-m-Y',strtotime($contact->created_date));
        $check = $contact->status == STATUS_ACTIVE ? 'checked' : '';
        $style = $stt++ % 2 == 0 ? 'even' : 'odd';
        ?>
        <tr class="<?php echo $style ?>">
            <td style="word-wrap:break-word;"><?php echo $contact->fullname; ?></td>
            <!--<td style="word-wrap:break-word;"><?php // echo $contact->company; ?></td>-->
            <td style="word-wrap:break-word;"><?php echo $contact->message; ?></td>
            <td style="word-wrap:break-word;"><?php echo $contact->email; ?></td>
            <td class="center" style="word-wrap:break-word;"><?php echo $contact->tel; ?></td>
            <!--<td class="center" style="word-wrap:break-word;"><?php // echo $contact->fax; ?></td>-->
            <!--<td class="center" style=word-wrap:break-word;" ><?php // echo $contact->address; ?></td>-->
            <td class="center" style="white-space:nowrap;"><?php echo $created_date; ?></td>
            <!--<td class="center" style="white-space:nowrap;"><input type="checkbox" <?php // echo $check;?> onclick="change_status(<?php // echo $contact->id;?>,'contact')"></td>-->
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="del" title="Xóa bỏ" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $contact->id ?>,'<?php echo CONTACT_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $e_page . ' / ' . $total_pages . ' (<span>Tổng: ' . $total_rows . '</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>