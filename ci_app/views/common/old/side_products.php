<?php $data = modules::run('products/get_side_products'); ?>

<?php if(!empty($data)) { ?>

<div class="sidebox sideproducts">

    <h3><?php echo __('IP_products_top'); ?></h3>

    <div class="sideproducts_inner">

    <?php foreach($data as $key => $value){

        if(SLUG_ACTIVE==0){

            $uri = get_base_url() . url_title(trim($value->product_name), 'dash', TRUE) . '-ps' . $value->id;

        }else{

            $uri = get_base_url() . $value->slug;

        }

        $image = is_null($value->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/thumbnails/'.$value->image_name;

        $value_name = limit_text($value->product_name, 100);

        $price = $value->price > 0 ? get_price_in_vnd($value->price) . ' ₫' : get_price_in_vnd($value->price);

    ?>

        <div class="homeproducts_item">

            <a href="<?php echo $uri; ?>" title="<?php echo $value->product_name; ?>" >

                <img title="<?php echo $value->product_name; ?>" alt="" src="<?php echo $image; ?>" />

            </a>

            <a href="<?php echo $uri; ?>" title="<?php echo $value->product_name; ?>" >

                <strong><?php echo $value_name; ?></strong>

            </a>

            <div class="homeproducts_button">

                <span><?php echo $price; ?></span>

                <a href="<?php echo $uri; ?>">Mua hàng</a>

                <div class="clearfix"></div>

            </div>

        </div>

    <?php } ?>

    </div>

</div>

<?php } ?>