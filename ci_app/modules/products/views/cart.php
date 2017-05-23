
     <?php   $lang = get_language();
        if ($this->cart->total_items() != 0):     ?>

<div style="clear:both; display:block; height:40px"></div>
                    <h2>Shopping Cart &nbsp;<small>Your shopping cart</small></h2>
                    <table class="shopping-cart">
                      <tr>
                        <th class="image"><?php echo __('IP_cart_image'); ?></th>
                        <th class="name"><?php echo __('IP_products'); ?></th>
                        <th class="model"><?php echo __('IP_size'); ?></th>
                        <th class="quantity"><?php echo __('IP_quantum'); ?></th>
                        <th class="price"><?php echo __('IP_cart_price'); ?></th>
                        <th class="total"><?php echo __('IP_price_total'); ?></th>
                        <th class="action">Thao tác</th>
                      </tr>

                      <?php
                        $carts = $this->cart->contents();
                        foreach ($carts as $cart):
                            if(SLUG_ACTIVE==0){
                                $uri = get_base_url() . url_title($cart['name'], 'dash', TRUE) . '-ps' . $cart['id'];
                            }else{
                                $uri = get_base_url() . $cart['slug'];
                            }
                            ?>
                      
                      <tr>
                        <td class="image"><a href="<?php echo $uri; ?>" title="<?php echo $cart['name']; ?>"><img title="product" alt="product" src="/images/products/smalls/<?php echo $cart['images']; ?>" height="50" width="50"></a></td>
                        <td  class="name"><a href="<?php echo $uri; ?>" title="<?php echo $cart['name']; ?>"><?php echo $cart['name']; ?></a></td>
                        <td class="model"><?php echo $cart['size']; ?></td>
                        <td class="quantity"><input style="text-align: center" type="text" name="<?php echo $cart['rowid']; ?>" maxlength="2" size="2" value="<?php echo $cart['qty']; ?>" onchange="update_cart('<?php echo $cart['rowid']; ?>', '<?php echo get_uri_by_lang($lang, 'cart'); ?>');"></td>
                        <td class="price"><?php echo get_price_in_vnd($cart['price']) . ' VND'; ?></td>
                        <td class="total"><?php echo get_price_in_vnd($cart['subtotal']) . ' VND'; ?></td>
                        <td class="remove-update"> 

                        <a class="tip remove"  rel="nofollow" href="javascript:void(0);" onclick="remove_cart('<?php echo $cart['rowid']; ?>', '<?php echo get_uri_by_lang($lang, 'cart'); ?>', '<?php echo $lang; ?>');" title="<?php echo __('IP_cart_shopping_delete'); ?>">
                                        <img src="<?php echo base_url(); ?>frontend/images/remove.png" alt="">
                                    </a>                      
                        
                      </tr>

                  <?php endforeach; ?>                              
                    </table>

                    <div class="contentbox">
                    <div class="cartoptionbox one-half first">                 
                                      
                    </div><!--cartoptionbox-->
                    <div class="alltotal one-half">
                    <table class="alltotal">
                      <tr>
                        <td><span class="extra">  <?php echo __('IP_total'); ?> :</span></td>
                        <td><span><?php echo get_price_in_vnd($this->cart->total()) . ' ₫'; ?></span></td>
                      </tr>
                      <tr>
                        <td colspan="2">  <?php if($lang == 'vi'){ ?>
                         <?php echo DocTienBangChu($this->cart->total()); ?>              
                        <?php } ?></td>
                      </tr>
                      <tr>
                        <td><span class="extra">Mã giảm giá :</span></td>
                        <td><span><input type="text" class="text" name="coupon_code" > </span></td>
                      </tr>
                      
                    </table>
                    <a href="/san-pham" class="btn btn-primary one" title="Thêm sản phẩm">Thêm sản phẩm</a>
                    <?php if ($this->cart->total_items() != 0){ ?>
                        <a href="/thong-tin-khach-hang" class="btn btn-success one" title="Thanh toán">Thanh toán</a>
                    <?php } ?>
                  </div><!--end:alltotal-->
                  </div><!--end:contentbox-->
                  <div style="clear:both; display:block; height:40px"></div>
 <?php else: ?>
            <?php $this->load->view('common/message'); ?>
            <h4 class="alert green_alert"><?php echo __('IP_cart_shopping_empty'); ?></h4>
<?php endif; ?>

     