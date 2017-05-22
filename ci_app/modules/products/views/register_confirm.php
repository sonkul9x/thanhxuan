<div class="box contact">
    <h1 class="title">Xác nhận đăng ký</h1>

    <p class="title_pay1">1.1 Thông tin khách hàng</p>
    <p><strong>Họ tên: </strong><?php echo $fullname; ?></p>
    <p><strong>Email: </strong><?php echo $email; ?></p>
    <p><strong>Điện thoại: </strong><?php echo $tel; ?></p>
    <p><strong>Địa chỉ: </strong><?php echo $address; ?></p>
    <p><strong>Yêu cầu đặc biệt: </strong><?php echo $message; ?></p>
    <p><strong>Phương thức thanh toán: </strong><?php echo $billing_name; ?></p>

    <br>
    <p class="title_pay1">1.2 Thông tin sản phẩm</p>
    <div class="box" style="margin: 0px auto;">

        <div class="cart">
            <?php
            $lang = get_language();
            if ($this->cart->total_items() != 0):
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered" style="border:none;">
                        <thead style="background-color: #c22322;color: white;">
                            <tr style="height: 50px;">
                                <th style="width: 5%;text-align: center;vertical-align: middle;"><?php echo __('IP_cart_image'); ?></th>
                                <th style="width: 50%;text-align: center;vertical-align: middle;"><?php echo __('IP_products'); ?></th>
                                <th style="width: 15%;text-align: center;vertical-align: middle;"><?php echo __('IP_cart_price'); ?></th>
                                <th style="width: 15%;text-align: center;vertical-align: middle;"><?php echo __('IP_quantum'); ?></th>
                                <th style="width: 15%;text-align: center;vertical-align: middle;"><?php echo __('IP_price_total'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $carts = $this->cart->contents();
                            foreach ($carts as $cart):
                                if (SLUG_ACTIVE == 0) {
                                    $uri = get_base_url() . url_title(trim($cart['name']), 'dash', TRUE) . '-ps' . $product->id;
                                } else {
                                    $uri = get_base_url() . $cart['slug'];
                                }
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo $uri; ?>" title="<?php echo $cart['name']; ?>">
                                            <img src="/images/products/smalls/<?php echo $cart['images']; ?>" title="<?php echo $cart['name']; ?>" height="70px" />
                                        </a>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="<?php echo $uri; ?>" title="<?php echo $cart['name']; ?>" style="color: #000;"><?php echo $cart['name']; ?> <br />- Size: <b><?php echo $cart['size']; ?></b></a>
                                    </td>
                                    <td style="vertical-align: middle;text-align: center;">
                                        <span class="cart_price"><?php echo get_price_in_vnd($cart['price']) . ' VND'; ?></span>
                                    </td>
                                    <td style="vertical-align: middle;text-align: center;">
        <?php echo $cart['qty']; ?>

                                    </td>
                                    <td style="vertical-align: middle;text-align: center;">
                                        <span class="cart_price"><?php echo get_price_in_vnd($cart['subtotal']) . ' VND'; ?></span>
                                    </td>
                                </tr>
    <?php endforeach; ?>
                        </tbody>
                        <tfoot style="background-color: rgb(245, 245, 245);">
                            <tr>
                                <td colspan="4" style="text-align: right;<?php if(empty($total_discount) || $total_discount == 0){ ?>text-transform: uppercase;font-weight: bold;<?php } ?>">
                                    <?php echo __('IP_total'); ?>:
                                </td>
                                <td class="total_price"><?php echo get_price_in_vnd($this->cart->total()) . ' VND'; ?> </td>
                            </tr>

                            <?php if(!empty($total_discount) && $total_discount > 0){
                                $total = $this->cart->total();
                                $discount = $total - $total_discount;
                                ?>
                            <tr>
                                <td colspan="4" style="text-align: right;">
                                    Giảm giá (mã:<?php echo $coupon_code; ?>):
                                </td>
                                <td class="total_price"><?php echo '-' . get_price_in_vnd($discount) . ' VND'; ?> </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;text-transform: uppercase;font-weight: bold;">
                                    Thành tiền:
                                </td>
                                <td class="total_price"><?php echo get_price_in_vnd($total_discount) . ' VND'; ?> </td>
                            </tr>
                            <?php } ?>

                            <?php if ($lang == 'vi') { ?>
                            <?php if(!empty($total_discount) && $total_discount > 0){ ?>
                            <tr>
                                <td colspan="5" style="text-align: right;" class="total_price"><?php echo DocTienBangChu($total_discount); ?> </td>
                            </tr>
                            <?php }else{ ?>
                            <tr>
                                <td colspan="5" style="text-align: right;" class="total_price"><?php echo DocTienBangChu($this->cart->total()); ?> </td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                    </tfoot>
                </table>
            </div>
<?php else: ?>

                <h4 class="alert alert-warning"><?php echo __('IP_cart_shopping_empty'); ?></h4>
<?php endif; ?>
        </div>
        
        <div class="clearfix"></div>

    </div>

    <div class="pull-right" style="padding-bottom: 20px;">
        <a class="btn btn-danger registersubmit" title="Xác nhận đăng ký" onclick="javascript:window.location.href = '<?php echo base_url() . 'dang-ky-thanh-cong'; ?>';">Xác nhận</a>
    </div>
</div>