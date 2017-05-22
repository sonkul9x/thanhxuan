<div class="homebox">
    <div class="container home">
        <div class="links">        
            <?php if (modules::run('customers/is_logged_in_cus')): ?>
                <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" style="border: none;">
                        <a  class="login"><?php echo $this->phpsession->get('fullname_cus'); ?></a>

                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/thong-tin-ca-nhan"><i class="fa fa-info-circle"></i>Thông tin cá nhân</a></li>
                        <li><a href="/quan-ly-don-hang"><i class="fa fa-cart-arrow-down"></i>Đơn hàng</a></li>

                        <li class="divider"></li>
                        <li><a href="/dang-xuat"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                    </ul>
                </div>

            <?php else: ?>


                <a href="/dang-nhap-thanh-vien" rel="nofollow" rel="login" class="login"><i class="fa fa-sign-in"></i>Đăng nhập</a>
                <a href="/tao-tai-khoan" rel="nofollow" rel="login" class="login"><i class="fa fa-user"></i>Đăng ký</a>


            <?php endif; ?>

            <a href="/gio-hang" class="cart" rel="nofollow"><i class="fa fa-cart-arrow-down"></i>Giỏ hàng <span><?php echo $this->cart->total_items(); ?></span></a>
        </div>
    </div>
</div>