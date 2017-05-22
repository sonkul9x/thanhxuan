<?php
    $this->load->view('admin/products/product_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', PRODUCTS_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
     <?php 
        if(isset ($filter)) echo $filter;
        $this->load->view('admin/products/toggle_add_product_form');
     ?>
    
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" colspan="2">TÊN</th>
            <th class="left" style="width: 25%">PHÂN LOẠI</th>
            <th class="right" style="width: 10%">GIÁ TIỀN</th>
            <!--<th class="left" style="width: 5%">ĐƠN VỊ</th>-->
            <th class="center" style="width: 5%">XEM</th>
            <th class="center" style="width: 5%">NGÀY SỬA</th>
            <!--<th class="center" style="width: 5%">TRANG CHỦ</th>-->
            <th class="center" style="width: 5%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php 
        if(isset($products)){
        $stt = 0;
        foreach ($products as $index => $product):
            $product_id     = $product->id;
            $product_name   = $product->product_name;
            $category       = $product->category;
            $warning        = strlen($product->image_name)==0 ? '<img src="/powercms/images/warning.png"' : '';
            if(SLUG_ACTIVE==0){
                $uri = '/' . url_title(trim($product->product_name), 'dash', TRUE) . '-ps' . $product->id;
            }else{
                $uri = '/' . $product->slug;
            }
            $price          = $product->price != 0 ? get_price_in_vnd($product->price) . ' đ' : get_price_in_vnd($product->price);
//            $product_unit   = ($product->unit != NULL && $product->unit != '') ? $product->unit : '';
            $updated_date   = get_vndate_string($product->updated_date);
            $created_date   = get_vndate_string($product->created_date);
            $style          = ($stt++ % 2 == 0) ? 'even' : 'odd';
            $image          = '/images/products/smalls/' . ((strlen($product->image_name)==0) ? 'no-product.png' : $product->image_name);
            $image          = '<img src="' . $image . '" alt="' . $product->product_name . '" style="height: 20px;" />';
            $check          = $product->status == STATUS_ACTIVE ? 'checked' : '';
//            $check_home     = $product->home == STATUS_ACTIVE ? 'checked' : '';
            $this_lang = ($product->lang<>DEFAULT_LANGUAGE)?'/'.$product->lang:'';
        ?>
        <tr class="<?php echo $style ?>">
            <td style="width:1%;"><?php echo $image; ?></td>
            <td class="left">
                <a href="<?php echo $this_lang . $uri; ?>"><?php echo $product_name;?></a> <span title="Chưa có hình ảnh sẽ không được hiển thị ra ngoài trang chủ"><?php echo $warning;?></span>
            </td>
            <td class="left" style="word-wrap:break-word;"><?php echo $category; ?></td>
            <td class="right"><span class="red"><?php echo $price; ?></span></td>
            <!--<td class="left"><?php // echo $product_unit; ?></span></td>-->
            <td class="center"><?php echo $product->viewed; ?></td>
            <td class="center"><?php echo $updated_date; ?></td>
            <!--<td class="center"><input type="checkbox" <?php // echo $check_home;?> onclick="change_home(<?php // echo $product_id;?>,'products')"></td>-->
            <td class="center"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $product_id;?>,'products')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa thông tin sản phẩm" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $product_id ?>,'<?php echo PRODUCTS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa sản phẩm" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $product_id ?>,'<?php echo PRODUCTS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Cập nhật (up) sản phẩm lên đầu trang" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $product_id ?>,'<?php echo PRODUCTS_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>

        <?php endforeach; ?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' sản phẩm</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>