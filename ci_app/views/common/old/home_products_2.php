<?php $results = modules::run('products/get_products_home',array('new'=>TRUE)); ?>
<?php if(!empty($results)){ ?>
<div class="homebox2">
    <div class="title">
        <a href="/hang-moi-ve" class="heading">Sản Phẩm Mới Nhất</a>
        <a href="/hang-moi-ve" class="view-all">Xem tất cả <i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="clearfix"></div>
    <div role="tabpanel" class="content">
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach($results as $k => $v){ ?>
            <li role="presentation" <?php if($k==0){ ?>class="active"<?php } ?>><a href="#sale2_<?php echo $v['category_slug']; ?>" aria-controls="sale2_<?php echo $v['category_slug']; ?>" role="tab" data-toggle="tab"><?php echo $v['category']; ?></a></li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php foreach($results as $k => $v){ ?>
            <div role="tabpanel" class="tab-pane sale2_<?php echo $v['category_slug']; ?> <?php if($k==0){ ?>active<?php } ?>" id="sale2_<?php echo $v['category_slug']; ?>">
                <div class="row">
                <?php $data = $v['products'];
                    if(!empty($data)){
                    foreach($data as $key => $value){
                    if(SLUG_ACTIVE==0){
                        $uri = get_base_url() . url_title(trim($value->product_name), 'dash', TRUE) . '-ps' . $value->id;
                    }else{
                        $uri = get_base_url() . $value->slug;
                    }
                    $image = is_null($value->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/thumbnails/'.$value->image_name;
                    $value_name = limit_text($value->product_name, 100);
                    $value_category = limit_text($value->category, 100);
                    $price = $value->price > 0 ? get_price_in_vnd($value->price) . ' ₫' : get_price_in_vnd($value->price);        
                    $price_old = $value->price_old > 0 ? get_price_in_vnd($value->price_old) . ' ₫' : 0;
                    $price_count = $value->price_old - $value->price;
                    $price_discount = $price_count > 0 ? get_price_in_vnd($price_count) . ' ₫' : 0;
                    $saleoff = $value->price_old > 0 ? ($price_count/$value->price_old)*100 : 0;
                    $saleoff = round($saleoff,0);
                ?>
                <div class="col-sm-4 item">
                    <div class="item-image">
                        <a title="<?php echo $value->product_name; ?>" href="<?php echo $uri; ?>">
                            <img alt="" title="<?php echo $value->product_name; ?>" src="<?php echo $image; ?>" />
                        </a>
                        <?php if(!empty($saleoff) && $saleoff > 0){ ?>
                        <p class="discount"><span><?php echo '-' . $saleoff . '%'; ?></span></p>
                        <?php } ?>
                    </div>
                    <h3><a title="<?php echo $value->product_name; ?>" href="<?php echo $uri; ?>"><?php echo $value_name; ?></a></h3>
                    <p>
                        <span class="price"><?php echo $price; ?></span>
                        <?php if(!empty($price_old) && $price_old <> 0){ ?>
                        <span class="price_old"><?php echo $price_old; ?></span>
                        <?php } ?>
                    </p>
                </div>
                <?php }} ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>