<?php
echo form_open($submit_uri);
if (isset($id))
    echo form_hidden('id', $id);
$fullname = isset($fullname) ? $fullname : '';
$email = isset($email) ? $email : '';
$created_date = isset($created_date) ? $created_date : '';
$submit_uri = isset($submit_uri) ? $submit_uri : '';
echo form_hidden('is_add_edit_category', TRUE);
echo form_hidden('form', 'orders_cat');
?>
<div class="page_header">
    <h1 class="fleft"><?php if (isset($header)) echo $header; ?></h1>
    <small class="fleft">"Nội dung order"</small>
    <span class="fright"><a class="button close" href="<?php echo ORDER_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <ul class="tabs">
        <li><a href="#tab1">Thông tin người mua</a></li>
        <li><a href="#tab2">Sản phẩm mua</a></li>
        <li><a href="#tab3">Tình trạng thanh toán</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
                <tr style="display: none;"><td class="title">Ngôn ngữ: </td></tr>
                <tr style="display: none;">
                    <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
                </tr>
                <tr><td class="title">Họ tên (Người order):</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255','readonly'=>TRUE, 'style' => 'width:560px;', 'value' => $fullname)); ?></td>
                </tr>
                <tr><td class="title">Số điện thoại (Người order):</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '255','readonly'=>TRUE, 'style' => 'width:560px;', 'value' => $tel)); ?></td>
                </tr>
                <tr><td class="title">Email: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255','readonly'=>TRUE, 'style' => 'width:560px;', 'value' => $email)); ?></td>
                </tr>
                <tr><td class="title">Địa chỉ giao hàng:</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'address', 'size' => '50', 'maxlength' => '255','readonly'=>TRUE, 'style' => 'width:560px;', 'value' => $address)); ?></td>
                </tr>
<!--                <tr><td class="title">Ngày đặt hàng: </td></tr>
                <tr>
                    <td>
                        <?php // echo form_input(array('name' => 'created_date', 'size' => '50','readonly'=>TRUE, 'maxlength' => '10', 'value' => $created_date)); ?>
                    </td>
                </tr>
                <tr><td class="title">Ngày giờ yêu cầu giao hàng: </td></tr>
                <tr>
                    <td>
                        <?php // echo form_input(array('id' => 'reserve_time', 'name' => 'reserve_time', 'size' => '50', 'readonly'=>TRUE, 'maxlength' => '10', 'value' => $reserve_time)); ?>
                    </td>
                </tr>-->
                <tr><td class="title" style="vertical-align: top">Ghi chú của khách hàng:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('id' => 'message', 'name' => 'message', 'style' => 'width:560px; height: 80px;', 'readonly'=>TRUE, 'value' => ($message != '') ? $message : set_value('message'))); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div id="tab2" class="tab_content">
            <table class="list" style="width: 100%; margin-bottom: 10px;">
                <tr>
                    <th class="left" style="width: 5%">MÃ ĐH</th>
                    <th class="left" style="width: 5%">MÃ SP</th>
                    <th class="left" style="width: 40%">SẢN PHẨM</th>
                    <th class="left" style="width: 10%">KÍCH CỠ</th>
                    <th class="left" style="width: 10%">SỐ LƯỢNG</th>
                    <th class="left" style="width: 10%">GIÁ BÁN</th>
                    <th class="left" style="width: 10%">TỔNG</th>
                </tr>
                <?php
                if (isset($order_detail)) {
                    $stt = 0;
                    $amount = 0;
                    foreach ($order_detail as $index => $orders):
                        $style = $stt++ % 2 == 0 ? 'even' : 'odd';
                        $price = $orders->price != 0 ? get_price_in_vnd($orders->price) . ' VND' : get_price_in_vnd($orders->price);
                        $tong = $orders->price* $orders->quantity;
                        $total = $tong != 0 ? get_price_in_vnd($tong) . ' VND' : get_price_in_vnd($tong);
                        $amount = $amount + $tong;
                        ?>
                        <tr class="<?php echo $style ?>">
                            <td><?php echo '#' . $orders->order_id; ?></td>
                            <td><?php echo '#' . $orders->product_id ?></td>
                            <td style="white-space:nowrap;"><?php echo $orders->product_name; ?></td>
                            <td style="white-space:nowrap;"><?php echo $orders->size; ?></td>
                            <td style="white-space:nowrap;"><?php echo $orders->quantity; ?></td>
                            <td style="white-space:nowrap;color: red;text-align: right;"><?php echo $price; ?></td>
                            <td style="white-space:nowrap;color: red;text-align: right;"><?php echo $total; ?></td>
                        </tr>
                    <?php endforeach; ?>
                        <tr class="odd">
                           <?php $amounts = $amount != 0 ? get_price_in_vnd($amount) . ' VND' : get_price_in_vnd($amount);?>
                            <td class="right" colspan="6" style="white-space:nowrap;"><b>Tổng giá trị đơn hàng</b></td>
                            <td class="right" style="white-space:nowrap;color: red;"><?php echo $amounts; ?></td>
                        </tr>
                        <tr class="odd">
                            <td colspan="7" style="text-align: right; color: red;font-weight: bold" class="total_price"><?php echo DocTienBangChu($amount); ?> </td>
                        </tr>
                <?php } ?>
            </table>
        </div>
        <div id="tab3" class="tab_content">
            <table>
                <tr><td class="title">Khách hàng chọn hình thức thanh toán: </td></tr>
                <tr>
                    <td id="category"> <?php echo get_form_orders_icon($kind_pay) ?></td>
                </tr>
                <tr><td class="title">Tình trạng hóa đơn: </td></tr>
                <tr>
                    <td id="category"><?php if(isset($combo_order)) echo $combo_order;?></td>
                </tr>
            </table>
        </div>
    </div>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>
