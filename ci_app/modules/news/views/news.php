<div class="box">
<?php if(!empty($news)){ 
    if(SLUG_ACTIVE==0){
        $uri2 = get_base_url() . url_title(trim($category), 'dash', TRUE) . '-n' . $category_id;    
    }else{
        $uri2 = get_base_url() . $category_slug;
    }
?>
<!--    <ol class="breadcrumb">
        <li><a href="<?php // echo get_base_url(); ?>" title="<?php // echo __('IP_default_company'); ?>"><?php // echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php // echo limit_text($category, 200); ?></li>
    </ol>-->
    
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
    <?php }else{echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>';} ?>
</div>

