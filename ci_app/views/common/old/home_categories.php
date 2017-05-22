<?php $data = modules::run('products/get_categories_home'); ?>
<?php if(!empty($data)){ ?>
<div class="homecat">
    <?php foreach($data as $key => $value){
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($value->category), 'dash', TRUE) . '-p' . $value->id;
        }else{
            $uri = get_base_url() . $value->slug;
        }
        $image = is_null($value->avatar) ? base_url().'images/no-image.png' : $value->avatar;
//        $value_category = limit_text($value->category, 60);
//        $value_summary = limit_text($value->summary, 40);
    ?>
    <div class="homecat_item">
        <a href="<?php echo $uri; ?>" title="<?php echo $value->category; ?>">
            <img src="<?php echo $image; ?>" title="<?php echo $value->category; ?>" />
<!--            <p>
                <?php // echo $value_category; ?>
                <span class="homecat_summary"><?php // echo $value_summary; ?></span>
            </p>-->
        </a>
    </div>
    <?php } ?>
</div>
<?php } ?>
