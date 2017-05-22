<?php if(!empty($products)) { ?>
<div class="box">
    <div class="title">
        <a href="#" class="heading"><?php echo $category; ?> - tổng số: <strong><?php echo $total_row; ?></strong></a>
    </div>
    <div class="row">
    <?php foreach($products as $key => $value){
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($value->product_name), 'dash', TRUE) . '-ps' . $value->id;
        }else{
            $uri = get_base_url() . $value->slug;
        }
        $image = is_null($value->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/thumbnails/'.$value->image_name;
        $value_name = limit_text($value->product_name, 50);
        $value_category = limit_text($value->category, 100);
        $price = $value->price > 0 ? get_price_in_vnd($value->price) . ' ₫' : get_price_in_vnd($value->price);    
        $price_old = $value->price_old > 0 ? get_price_in_vnd($value->price_old) . ' ₫' : 0;
        $price_count = $value->price_old - $value->price;
        $price_discount = $price_count > 0 ? get_price_in_vnd($price_count) . ' ₫' : 0;
        $saleoff = ($price_count/$value->price_old)*100;
        $saleoff = round($saleoff,0);
    ?>
    <div class="col-sm-4 item">
        <div class="item-image">
            <a title="<?php echo $value->product_name; ?>" href="<?php echo $uri; ?>">
                <img alt="" title="<?php echo $value->product_name; ?>" src="<?php echo $image; ?>" />
            </a>
            <?php if(!empty($saleoff) && $saleoff <> 0){ ?>
            <p class="discount"><span><?php echo '-' . $saleoff . '%'; ?></span></p>
            <?php } ?>
        </div>
        <h3><a title="<?php echo $value->product_name; ?>" href="<?php echo $uri; ?>"><?php echo $value_name; ?></a></h3>
        <p><span class="price"><?php echo $price; ?></span><span class="price_old"><?php echo $price_old; ?></span></p>
    </div>
    <?php } ?>
    </div>
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
<?php }else { ?>
<h4 class="alert alert-warning"><?php echo __('IP_search_no_result'); ?></h4>
<?php } ?>