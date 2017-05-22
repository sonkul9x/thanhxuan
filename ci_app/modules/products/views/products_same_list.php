<?php if(!empty($products)) { ?>
<div class="same_products">
    <h5><?php echo $category; ?></h5>
    <ul>
    <?php foreach($products as $key => $product){
        $product_name = limit_text($product->product_name, 90);
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($product->product_name), 'dash', TRUE) . '-ps' . $product->id;
        }else{
            $uri = get_base_url() . $product->slug;
        }
    ?>
    <li>
        <a href="<?php echo $uri; ?>" title="<?php echo $product_name; ?>"><?php echo $product_name; ?></a>
    </li>
    <?php } ?>
    </ul>
</div>
<?php } ?>