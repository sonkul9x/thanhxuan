<div class="box">    
    <?php if(!empty($news)) { ?>
    <h1 class="title"><?php echo $category; ?></h1>
    <div class="list">
        <?php foreach ($news as $key => $new) {
        if(SLUG_ACTIVE==0){
                $uri = get_base_url() . url_title(trim($new->title), 'dash', TRUE) . '-ns' . $new->id;
            }else{
                $uri = get_base_url() . $new->slug;
            }
            $image_thumbnail = (isset($new->thumbnail) && $new->thumbnail <> '')?$new->thumbnail:base_url().'images/no-image.png';
        ?>
        <div class="row list_item">
            <div class="col-sm-4 list_thumb">
                <a href="<?php echo $uri; ?>" title="<?php echo $new->title; ?>"><img alt="<?php echo $new->title; ?>" src="<?php echo $image_thumbnail; ?>" title="<?php echo $new->title; ?>" ></a>
            </div>
            <div class="col-sm-8 list_content">
                <p class="list_title">
                    <a href="<?php echo $uri; ?>" title="<?php echo $new->title; ?>"><?php echo $new->title; ?></a>
                </p>
                <p class="posted_on"><i class="fa fa-calendar"></i><?php echo get_date_by_lang(get_language(), $new->created_date); ?><span>&verbar;</span><i class="fa fa-eye"></i><?php echo $new->viewed; ?></p>
                <p class="list_summary"><?php echo limit_text($new->summary, 310); ?></p>
                <a class="viewmore" href="<?php echo $uri; ?>" title="<?php echo $new->title; ?>"><?php echo __('IP_view_detail'); ?></a>
            </div>
        </div>
    <?php } ?>
    </div>
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <?php }else{echo '<h4 class="alert alert-info">' . __('IP_tags_no_result') . '</h4>';} ?>
</div>
