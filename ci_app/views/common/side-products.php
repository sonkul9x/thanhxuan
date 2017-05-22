<?php $data = modules::run('products/get_side_products'); ?>

<?php if(!empty($data)) { ?>


<div class="side">
    <h4><?php echo __('IP_products_top'); ?></h4>
   
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
     <div class="entry">
        <div class="da-thumbs">
            <div>
                 <img title="<?php echo $value->product_name; ?>" alt="" src="<?php echo $image; ?>" />
                <article class="da-animate da-slideFromRight" style="display: block;">
                    <p><a href="<?php echo $uri; ?>" class="link"></a></p>
                </article>
            </div>
        </div>
        <h3><a href="<?php echo $uri; ?>" title="<?php echo $value_name; ?>"><?php echo $value_name; ?></a></h3>
        <small><?php echo $price; ?></small>
    </div>
        <?php } ?>
   
</div><!--end:side-->
<?php   } ?>