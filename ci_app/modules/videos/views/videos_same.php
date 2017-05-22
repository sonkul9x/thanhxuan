<?php if(!empty($videos)) { ?>
<div class="grid_same">
    <h3><i class="fa fa-arrow-circle-right"></i><?php echo $category; ?></h3>
    <div class="grid">
    <div class="row">
        <?php foreach($videos as $key => $value){
            $image_url = $value->image_name;
            $short_title = limit_text($value->title, 50);
//            $short_summary = limit_text($value->summary, 200);
            if(SLUG_ACTIVE==0){
                $uri = get_base_url() . url_title(trim($value->title), 'dash', TRUE) . '-vs' . $value->id;
            }else{
                $uri = get_base_url() . $value->slug;
            }
        ?>
        <div class="col-sm-4 grid_item">
            <div class="thumbnail">
                <a class="grid_image" href="<?php echo $uri; ?>" title="<?php echo $value->title; ?>">
                    <img title="<?php echo $value->title; ?>" alt="<?php echo $value->title; ?>" src="<?php echo $image_url; ?>" >
                </a>
                <div class="caption">
                    <p class="grid_title"><a href="<?php echo $uri; ?>" title="<?php echo $value->title; ?>"><?php echo $short_title; ?></a></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    </div>
</div>
<?php } ?>
