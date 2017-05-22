<?php
    $this->load->view('admin/customers_nav');
    echo form_open('', array('id' => 'customers_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', FAQ_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            
            <th class="left" style="width: 5%">MÃ KH</th>
            <th class="left" style="width: 20%">KHÁCH HÀNG</th>
            <th class="left" style="width: 20%">EMAIL</th>
            <th class="left" style="width: 10%">TEL</th>
            <th class="center" style="width: 10%">THAM GIA</th>
            <th class="left" style="width: 20%">HÓA ĐƠN</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($customerss)){
        $stt = 0;
        foreach($customerss as $index => $customers):
        $row_uri        = get_base_url() . url_title(trim($customers->fullname), 'dash', TRUE) . '-qs' . $customers->id;
        $created_date   = get_vndate_string($customers->created_date);
        $updated_date   = get_vndate_string($customers->updated_date);
        $check          = $customers->status == STATUS_ACTIVE ? 'checked' : '';
        $style = $stt++ % 2 == 0 ? 'even' : 'odd';
       
        ?>
        <tr class="<?php echo $style ?>">
            <td><?php echo '#'.$customers->id;?></td>
            <td>
                <?php
            if($customers->count_order <=0)
                echo $customers->fullname;
            else
                echo '<a href="/dashboard/orders?email='.$customers->email.'" style="text-decoration: underline;">'.$customers->fullname.'</a>';
            
            ?>
            </td>
            <td style="white-space:nowrap;"><?php echo $customers->email ?></td>
            <td style="white-space:nowrap;"><?php echo $customers->phone ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $created_date?></td>
            <td style="white-space:nowrap;">
                <?php
            if($customers->count_order <=0)
                echo '';
            else
                echo '<a href="/dashboard/orders?email='.$customers->email.'" style="text-decoration: underline;">'.$customers->count_order.'</a>';
            
            ?>
                </td>
            <td class="center" style="white-space:nowrap;" class="action">
                
                <a class="edit" title="Xem chi tiết khách hàng này" href="javascript:void(0);" onclick="submit_action(<?php echo $customers->id ?>,'customers','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa khách hàng" href="javascript:void(0);" onclick="submit_action(<?php echo $customers->id ?>,'customers','delete');"><em>&nbsp;</em></a>
                
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' khách hàng</span>)'; ?>
        <tr class="list-footer">
            <th colspan="8">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>