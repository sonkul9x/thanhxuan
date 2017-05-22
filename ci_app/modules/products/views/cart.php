
     <?php   $lang = get_language();
        if ($this->cart->total_items() != 0):
            ?>

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
                  <tfoot>
                        <tr>       
                    <td colspan="4">
                        <?php echo __('IP_total'); ?>:
                    </td>
                    <td class="total_price"><?php echo get_price_in_vnd($this->cart->total()) . ' ₫'; ?> </td>
                </tr>
                <?php if($lang == 'vi'){ ?>
                <tr>
                    <td colspan="5" style="text-align: right;" class="total_price"><?php echo DocTienBangChu($this->cart->total()); ?> </td>
                </tr>
                <?php } ?>
            </tfoot>                  
                    </table>

                    <div class="contentbox">
                    <div class="cartoptionbox one-half first">
                    <h4> Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost. </h4>
                    <input type="radio" class="radio">
                    <span>Use Coupon Code</span> <br>
                    <input type="radio" class="radio">
                    <span>Use Gift Voucher</span> <br>
                    <input type="radio" class="radio" checked="checked">
                    <span>Estimate Shipping &amp; Taxes</span> <br><br>
                    <form action="#" class="ship">
                      <h4> Enter your destination to get a shipping estimate.</h4>
                      <fieldset>
                        <div class="control-group">
                          <label>Select list</label>
                            <select  class="span3 cartcountry">
                              <option>Country:</option>
                              <option>Philippines</option>
                              <option>United States</option>
                            </select>
                            <select class="span3 cartstate">
                              <option>Region / State:</option>
                              <option>Manila</option>
                              <option>Los Angeles</option>
                            </select>
                            <input type="submit" value="Submit" class="submit">
                        </div>
                      </fieldset>
                    </form>
                  </div><!--cartoptionbox-->
                    <div class="alltotal one-half">
                    <table class="alltotal">
                      <tr>
                        <td><span class="extra">Sub-Total :</span></td>
                        <td><span>$101.0</span></td>
                      </tr>
                      <tr>
                        <td><span class="extra">Eco Tax (-2.00) :</span></td>
                        <td><span>$11.0</span></td>
                      </tr>
                      <tr>
                        <td><span class="extra">VAT (18.2%) :</span></td>
                        <td><span>$21.0</span></td>
                      </tr>
                      <tr>
                        <td><span class="extra grandtotal">Total :</span></td>
                        <td><span class="grandtotal">$150.28</span></td>
                      </tr>
                    </table>
                    <input type="submit" value="Continue Shopping">
                    <input type="submit" value="CheckOut">
                  </div><!--end:alltotal-->
                  </div><!--end:contentbox-->
                  <div style="clear:both; display:block; height:40px"></div>
 <?php else: ?>
            <?php $this->load->view('common/message'); ?>
            <h4 class="alert green_alert"><?php echo __('IP_cart_shopping_empty'); ?></h4>
<?php endif; ?>
