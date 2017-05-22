<div class="central-content bo_cart">
    <div class="cm-notification-container"></div>
    <div class="mainbox-container">
        <h1 class="mainbox-title"><span>Thông tin đơn hàng</span></h1>
        <div class="mainbox-body">    
         
            <div align="right" class="clear">
                <ul class="action-bullets">
                </ul>
            </div>
<!--            <div class="right">
                <span class="button"><a href="#" onclick="window.open(this.href, 'popupwindow', 'width=900,height=600,toolbar=yes,status=no,scrollbars=yes,resizable=no,menubar=yes,location=no,direction=no');
                        return false;" class="">In đơn hàng</a></span>
            </div>-->
            <div class="clear order-info">
                <table cellpadding="2" cellspacing="0" border="0" class="float-left">
                    <tbody><tr>
                            <td><strong>Mã đơn hàng</strong>:&nbsp;</td><td><?php echo $order->id; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Ngày tạo hóa đơn</strong>:&nbsp;</td><td><?php echo date('d-m-Y, H:i:s', strtotime($order->sale_date)); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Trạng thái</strong>:&nbsp;</td><td>
                                <?php echo get_status_orders($order->order_status); ?>
                            </td>
                        </tr>
                    </tbody></table>
            </div>
            <div class="border">
                <div class="subheaders-group" style="
    margin-bottom: 50px;
">
                    <h2 class="subheader">
                        Các sản phẩm trong đơn hàng
                    </h2>
                    <table cellpadding="0" cellspacing="0" border="0" class="table product-list" width="100%">
                        <tbody><tr>
                                <th>Sản phẩm</th>
                                <th style="text-align: right">Giá bán</th>
                                <th style="text-align: center">Số lượng</th>
                                <th style="text-align: right">Thành tiền</th>
                            </tr>
                            <?php
                          //  $order_detals = $order->order_details;
                            foreach ($order_detals as $detail):
                            ?>
                            <tr valign="top">
                                <td>
                                    <a href="#" class="product-title"><?php echo $detail->product_name;?></a>                        
                                    <p>Code:&nbsp;<?php echo $detail->product_id;?></p>
                                </td>
                                <td class="right nowrap" style="text-align: right;color: rgb(194, 0, 0);">
                                    <?php echo get_price_in_vnd($detail->price); ?> &nbsp;VNĐ</td>
                                <td class="center" style="text-align: center">&nbsp;<?php echo $detail->quantity;?></td>
                                <td class="right" style="text-align: right;color: rgb(194, 0, 0);">
                                    &nbsp;<strong><?php echo get_price_in_vnd($detail->price*$detail->quantity);?>&nbsp;VNĐ</strong></td>
                            </tr>
                            <?php endforeach;?>
                            <tr class="table-footer">
                                <td colspan="5">&nbsp;</td>
                            </tr>
                        </tbody></table>
                    <h2 class="subheader">
                        Tóm tắt
                    </h2>
                    <table width="100%" class="fixed-layout">
                        <tbody><tr>
                                <td width="220"><strong>Hình thức thanh toán:&nbsp;</strong></td>
                                <td>
                                    <?php
                                    $payment_form = $order->kind_pay;
                                
                                    if($payment_form == 1)
                                        echo 'Thanh toán trực tiếp ';
                                    else if($payment_form == 2)
                                        echo 'Chuyển khoản ngân hàng';
                                    else
                                        echo 'Hình thức khác';
                                    
                                    ?>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><strong>Shipping:&nbsp;</strong></td>
                                <td>
                                    Giao Hàng Tận Nơi
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Thành tiền:&nbsp;</strong></td>
                                <td><span style="color: rgb(194, 0, 0);"><?php echo get_price_in_vnd($order->total);?></span> &nbsp;VNĐ</td>
                            </tr>
                            <tr>
                                <td><strong>Phí dịch vụ:</strong>&nbsp;</td>
                                <td ><span style="color: rgb(194, 0, 0);">0</span> &nbsp;VNĐ</td>
                            </tr>
                            <tr>
                                <td><strong>Tổng cộng:&nbsp;</strong></td>
                                <td><strong><span style="color: rgb(194, 0, 0);"><?php echo get_price_in_vnd($order->total);?></span>&nbsp;VNĐ</strong></td>
                            </tr>
                            <tr>
                                <td valign="top"><strong>Ghi chú KH:&nbsp;</strong></td>
                                <td><div class="scroll-x"><?php echo $order->message;?></div></td>
                            </tr>
                        </tbody></table>
                    <h2 class="subheader">
                        Thông tin khách hàng
                    </h2>
                    <h5 class="info-field-title">Thông tin liên lạc</h5>
                    <div style="margin:7px 0px 0px 5px">
                        <div style="width:130px;float:left;font-weight:bold">Email:</div>
                        <div style="width:585px;margin-left:90px"><?php echo $order->email;?></div>
                    </div>
                    <br>
                    <h5 class="info-field-title">Địa chỉ giao hàng</h5>
                    <div style="margin:7px 0px 3px 5px">
                        <div style="width:140px;float:left;font-weight:bold">Họ tên:</div>
                        <div style="width:585px;margin-left:90px"><?php echo $order->fullname;?></div>
                    </div>
                    <div style="margin:7px 0px 3px 5px">
                        <div style="width:140px;float:left;font-weight:bold">Địa chỉ:</div>
                        <div style="width:585px;margin-left:90px">
                          <?php echo $order->address;?></div>
                    </div>
                    <div style="margin:7px 0px 3px 5px">
                        <div style="width:140px;float:left;font-weight:bold">Điện thoại:</div>
                        <div style="width:585px;margin-left:90px"><?php echo $order->phone;?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>