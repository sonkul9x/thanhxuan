<?php $results = modules::run('products/get_products_home',array('saleoff'=>TRUE)); ?>

<?php if(!empty($results)){ ?>
<div class="list_work list_work2">
                        <h4>Sản phẩm giảm giá</h4>
                        <ul id="mycarouselnew" class="jcarousel-skin-tango item">
                         <?php foreach($results as $k => $v){ ?>
      <?php $data = $v['products'];

                    if(!empty($data)){

                    foreach($data as $key => $value){

                    if(SLUG_ACTIVE==0){

                        $uri = get_base_url() . url_title(trim($value->product_name), 'dash', TRUE) . '-ps' . $value->id;

                    }else{

                        $uri = get_base_url() . $value->slug;

                    }

                    $image = is_null($value->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/thumbnails/'.$value->image_name;

                    $imgbig = base_url().'images/products/'.$value->image_name;

                    $value_name = limit_text($value->product_name, 100);

                    $value_category = limit_text($value->category, 100);

                    $price = $value->price > 0 ? get_price_in_vnd($value->price) . ' ₫' : get_price_in_vnd($value->price);        

                    $price_old = $value->price_old > 0 ? get_price_in_vnd($value->price_old) . ' ₫' : 0;

                    $price_count = $value->price_old - $value->price;

                    $price_discount = $price_count > 0 ? get_price_in_vnd($price_count) . ' ₫' : 0;

                    $saleoff = $value->price_old > 0 ? ($price_count/$value->price_old)*100 : 0;

                    $saleoff = round($saleoff,0); ?>

                            <li>
                                <img alt="" title="<?php echo $value->product_name; ?>" src="<?php echo $image; ?>" />
                                <span><?php echo $value->product_name; ?><br>
       
 <?php if(!empty($price_old) && $price_old <> 0){ ?>
                    <small class="sale"><?php echo $price_old; ?></small>&nbsp;&nbsp;<small><?php echo $price; ?></small>
               

                        <?php }else{ ?>
            <small><?php echo $price; ?></small>
                         <?php    } ?>
        </span>
                                <span class="sale">Sale</span>
                                <ul>      
                                                                              
                                    <li><a href="<?php echo $uri; ?>" class="cart tip" title="Mua sản phẩm">Mua hàng</a></li>
                                    <li><a href="<?php echo $imgbig; ?>" rel="prettyPhoto[gallery1]" class="zoom tip" title="Zoom">Zoom</a></li>                      
                                </ul>
                            </li>
                            <?php }} ?>
    <?php } ?>          
                            </ul>
                        </div><!--end:list_work-->
                        <?php } ?>