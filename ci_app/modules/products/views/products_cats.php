<?php if(!empty($cats)) { ?>
<div class="box">
    <div class="grid">
        <h3><?php echo $title; ?></h3>
        <div class="row">
        <?php foreach($cats as $key => $value){
            if(SLUG_ACTIVE==0){
                $uri = get_base_url() . url_title(trim($value->category), 'dash', TRUE) . '-p' . $value->id;
            }else{
                $uri = get_base_url() . $value->slug;
            }
            $value_category = limit_text($value->category, 100);
        ?>
        <div class="col-sm-3 grid_item">
            <div class="thumbnail">
                <a href="<?php echo $uri; ?>" title="<?php echo $value->category; ?>">
                    <img title="<?php echo $value->category; ?>" alt="<?php echo $value->category; ?>" src="<?php echo $value->thumbnail; ?>" >
                </a>
                <div class="caption">
                    <p class="grid_title"><a href="<?php echo $uri; ?>" title="<?php echo $value->category; ?>"><?php echo $value_category; ?></a></p>
                </div>
            </div>
        </div>
        <?php } ?>
        </div>
    </div>
</div>
<?php }else{echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>';} ?>