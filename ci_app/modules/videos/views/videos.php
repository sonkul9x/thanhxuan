<div class="box">
    <?php if(!empty($videos)) { ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php echo $category; ?></li>
    </ol>
    <div class="grid videos">
    <div class="row">
        <?php foreach($videos as $key => $video){
        $short_title = limit_text($video->title, 50);
        $short_summary = limit_text($video->summary, 200);
        $videos_items = modules::run('videos/list_videos_items',$video->id);
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($video->title), 'dash', TRUE) . '-vs' . $video->id;
        }else{
            $uri = get_base_url() . $video->slug;
        }
        ?>
        <div class="col-sm-4 grid_item">
            <div class="thumbnail">
                <?php if(!empty($videos_items)){ ?>
                <?php foreach($videos_items as $key => $image){
                    $item_image = $image->image_name;
                    $item_url = $image->url;
                    if($image->caption <> ''){
                        $image_caption = $video->title . ' - ' . $image->caption;
                    }else{
                        $image_caption = $video->title;
                    }
                ?>
                <?php if($key==0){ ?>
                <a class="grid_image fancybox-media ft-<?php echo $video->id; ?>" rel="fancybox-thumb" href="<?php echo $item_url; ?>" title="<?php echo $image_caption; ?>" onclick="fancyshowvideo(<?php echo $video->id; ?>)" style="border-radius:0; min-height: 150px;">
                    <img title="<?php echo $image_caption; ?>" alt="<?php echo $image_caption; ?>" src="<?php echo $item_image; ?>" >
                </a>
                <?php }else{ ?>
                <a class="fancybox-media ft-<?php echo $video->id; ?>" rel="fancybox-thumb" href="<?php echo $item_url; ?>" title="<?php echo $image_caption; ?>" style="display: none;">
                    <img title="<?php echo $image_caption; ?>" alt="<?php echo $image_caption; ?>" src="<?php echo $item_image; ?>"  style="display: none;" >
                </a>
                <?php }}}?>
                <div class="caption">
                    <p class="grid_title"><a href="<?php echo $uri; ?>" title="<?php echo $video->title; ?>"><?php echo $short_title; ?></a></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    </div>
    <div class="divider"></div>
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <?php }else echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>'; ?>
</div>
