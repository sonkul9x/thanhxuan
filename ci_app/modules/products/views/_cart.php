<div class="box">    

    <div class="cart">

        <h3><?php echo $title; ?></h3>

        <?php 

        $lang = get_language();

        if ($this->cart->total_items() != 0): ?>

        <div class="table-responsive">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th style="width: 5%"><?php echo __('IP_cart_image'); ?></th>

                    <th style="width: 50%"><?php echo __('IP_products'); ?></th>

                    <th style="width: 15%"><?php echo __('IP_cart_price'); ?></th>

                    <th style="width: 15%"><?php echo __('IP_quantum'); ?></th>

                    <th style="width: 15%"><?php echo __('IP_price_total'); ?></th>

                </tr>

            </thead>
        
            <tbody>

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

                        <td>

                            <a href="<?php echo $uri; ?>" title="<?php echo $cart['name']; ?>">

                                <img src="/images/products/smalls/<?php echo $cart['images']; ?>" title="<?php echo $cart['name']; ?>" height="70px" />

                            </a>

                        </td>

                        <td>

                            <a href="<?php echo $uri; ?>" title="<?php echo $cart['name']; ?>"><?php echo $cart['name']; ?></a>

                        </td>

                        <td>

                            <span class="cart_price"><?php echo get_price_in_vnd($cart['price']) . ' ₫'; ?></span>

                        </td>

                        <td>

                            <input type="text" name="<?php echo $cart['rowid']; ?>" maxlength="2" size="2" value="<?php echo $cart['qty']; ?>" onchange="update_cart('<?php echo $cart['rowid']; ?>','<?php echo get_uri_by_lang($lang,'cart'); ?>');">

                            <a rel="nofollow" href="javascript:void(0);" onclick="remove_cart('<?php echo $cart['rowid']; ?>','<?php echo get_uri_by_lang($lang,'cart'); ?>','<?php echo $lang; ?>');" title="<?php echo __('IP_cart_shopping_delete'); ?>">

                                <img src="/images/delete-cart.gif" alt="Delete" class="icon">

                            </a>

                        </td>

                        <td>

                            <span class="cart_price"><?php echo get_price_in_vnd($cart['subtotal']) . ' ₫'; ?></span>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

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

        </div>

        <?php else: ?>

            <?php $this->load->view('common/message'); ?>

            <h4 class="alert alert-warning"><?php echo __('IP_cart_shopping_empty'); ?></h4>

        <?php endif; ?>

    </div>

    

    <?php if ($this->cart->total_items() != 0): ?>

    

    <?php echo form_open($submit_uri); if (isset($id)) {echo form_hidden('id', $id);}

    $submit_uri = isset($submit_uri) ? $submit_uri : ''; echo form_hidden('form', 'cart_form'); ?>

    

    <div>

        <?php $this->load->view('common/message'); ?>

        <div class="alert alert-info"><?php echo __('required_fields'); ?></div>

        <p><?php echo __('IP_fullname'); ?> (<span>*</span>):</p>

        <?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255', 'style' => 'width:60%;', 'class' => 'form-control', 'value' => $fullname, 'required'=>TRUE)); ?>

        <p><?php echo __('IP_email'); ?> (<span>*</span>):</p>

        <?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'style' => 'width:60%;', 'class' => 'form-control', 'value' => $email, 'required'=>TRUE)); ?>

        <p><?php echo __('IP_tel'); ?> (<span>*</span>):</p>

        <?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '20', 'style' => 'width:60%;', 'class' => 'form-control', 'value' => $tel, 'required'=>TRUE)); ?>

        <p><?php echo __('IP_address'); ?> (<span>*</span>):</p>

        <?php echo form_input(array('name' => 'address', 'size' => '50', 'maxlength' => '255', 'style' => 'width:60%;', 'class' => 'form-control', 'value' => $address, 'required'=>TRUE)); ?>

        <p><?php echo __('IP_message'); ?>:</p>

        <?php echo form_textarea(array('id' => 'message', 'name' => 'message', 'cols' => '90', 'rows' => '3', 'maxlength' => '255', 'style' => 'width:80%;', 'class' => 'form-control', 'value' => $message)); ?>

        <div style="margin-top: 10px;"></div>

        <?php echo form_submit(array('name' => 'btnSubmit', 'value' => __('IP_cart_shopping_submit'), 'class' => 'btn btn-warning')); ?>

        <input type="reset" value="<?php echo __('IP_reset'); ?>" class="btn btn-default" />

        <br class="clear"/>&nbsp;

    </div>

    <?php echo form_close(); ?>

    <?php endif; ?>

    

</div>

