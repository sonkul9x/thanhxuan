<?php
    $this->load->view('admin/products_coupon_item/nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', PRODUCTS_COUPON_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/products_coupon_item/filter'); ?>
    <table class="list" style="width: 100%;margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left">MÃ</th>
            <th class="left" style="width: 25%">TÊN COUPON</th>
            <th class="center" style="width: 7%">TRẠNG THÁI</th>
        </tr>
        <?php 
        if(isset($products_coupon_item)){
        $stt = 0;
        foreach($products_coupon_item as $index => $value):
//            $check = $value->status == STATUS_ACTIVE ? 'checked' : '';
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
        ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><?php echo $value->code; ?></td>
            <td class="left"><?php echo $value->name; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo status_show_label($value->status,'Chưa sử dụng','Đã sử dụng'); ?></td>
            <!--<td class="center" style="white-space:nowrap;"><input type="checkbox" <?php // echo $check;?> onclick="change_status(<?php // echo $value->id;?>,'products/coupon_item')"></td>-->
        </tr>
        <?php endforeach; ?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . '</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>