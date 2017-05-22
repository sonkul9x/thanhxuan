<?php if(!empty($products)) { ?>
<div class="box">
    <?php 
        if(STATUS_ACTIVE==0){
            $uri2 = get_base_url() . url_title(trim($category), 'dash', TRUE) . '-p' . $category_id; 
        }else{
            $uri2 = get_base_url() . $category_slug;
        }
    ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo DEFAULT_COMPANY; ?>"><?php echo __('IP_home_page'); ?></a></li>
        <?php if($category_id<>0){ ?><li><a href="<?php echo get_url_by_lang(get_language(),'products'); ?>" title="Sản phẩm"><?php echo __('IP_products'); ?></a></li><?php } ?>
        <li class="active"><?php echo $category; ?></li>
    </ol>
    
    <h3><a href="<?php echo $uri2; ?>"><?php echo $category; ?></a></h3>
    <div class="box_content plist">
        <ul>
        <?php foreach($products as $key => $product){
            if(SLUG_ACTIVE==0){
                $uri = get_base_url() . url_title(trim($product->product_name), 'dash', TRUE) . '-ps' . $product->id;
            }else{
                $uri = get_base_url() . $product->slug;
            }
            $image = is_null($product->image_name) ? 'no-image.png' : $product->image_name;
            $product_name = limit_text($product->product_name, 100);
            //$price = $product->price != 0 ? get_price_in_vnd($product->price) . ' ₫' : get_price_in_vnd($product->price);        
            //$product_unit   = ($product->unit != NULL && $product->unit != '') ? '/' . $product->unit : '';
        ?>
        <li class="plist-item">
            <div class="plist-title">
                <a href="<?php echo $uri; ?>" title="<?php echo $product->product_name; ?>"><?php echo $product_name; ?></a>
            </div>
            <div class="plist-avatar">
                <a href="<?php echo $uri; ?>" title="<?php echo $product->product_name; ?>"><img title="<?php echo $product->product_name; ?>" alt="<?php echo $product->product_name; ?>" src="/images/products/thumbnails/<?php echo $image; ?>" ></a>
            </div>
            <div class="plist-summary">
                <?php echo $product->summary; ?>
            </div>
            <div class="plist-more">
                <?php if($lang == 'vi'){ ?>
                <a href="<?php echo $uri; ?>" title="<?php echo $product->product_name; ?>"><img src="<?php echo base_url(); ?>images/more.png" /></a>
                <?php }else{ ?>
                <a href="<?php echo $uri; ?>" title="<?php echo $product->product_name; ?>"><img src="<?php echo base_url(); ?>images/more2.png" /></a>
                <?php } ?>
            </div>
        </li>
        <?php } ?>
        </ul>
    </div>
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php }else echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>'; ?>