<?php
    $this->load->view('admin/orders_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', ORDER_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 5%">MÃ ĐH</th>
            <th class="left" style="width: 20%">KHÁCH HÀNG</th>
            <th class="left" style="width: 20%">EMAIL</th>
            <th class="left" style="width: 20%">TEL</th>
            <th class="center" style="width: 10%">NGÀY ĐẶT HÀNG</th>
            <th class="center" style="width: 10%">TRẠNG THÁI</th>
            <th class="center" style="width: 10%">TỔNG</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($orderss)){
        $stt = 0;
        foreach($orderss as $index => $orders):
        $created_date   = get_vndate_string($orders->create_time);
        $updated_date   = get_vndate_string($orders->update_time);
//        $check          = $orders->status == STATUS_ACTIVE ? 'checked' : '';
        $style = $stt++ % 2 == 0 ? 'even' : 'odd';
        $price          = $orders->total != 0 ? get_price_in_vnd($orders->total) . ' đ' : get_price_in_vnd($orders->total);
        ?>
        <tr class="<?php echo $style ?>">
            <td><?php echo '#'.$orders->id; ?></td>
            <td><?php echo $orders->fullname ?></td>
            <td style="white-space:nowrap;"><?php echo $orders->email ?></td>
            <td style="white-space:nowrap;"><?php echo $orders->tel ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $created_date ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo get_status_orders_icon($orders->order_status) ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $price ?></td>
            <td class="center" style="white-space:nowrap;" class="action">        
                <a class="edit" title="Xem chi tiết đơn hàng này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $orders->id ?>,'<?php echo ORDERS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa đơn hàng" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $orders->id ?>,'<?php echo ORDERS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <!--<a class="excel" title="Xuất excel" href="javascript:void(0);" onclick="submit_action_admin(<?php // echo $orders->id ?>,'<?php // echo ORDERS_ADMIN_EXPORT; ?>','export');"><em>&nbsp;</em></a>-->
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' đơn hàng</span>)'; ?>
        <tr class="list-footer">
            <th colspan="8">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>
