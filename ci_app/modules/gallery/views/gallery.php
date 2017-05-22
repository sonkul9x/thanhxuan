<div class="box">
    <?php if(!empty($galleries)) { ?>
<!--    <ol class="breadcrumb">
        <li><a href="<?php // echo get_base_url(); ?>" title="<?php // echo __('IP_default_company'); ?>"><?php // echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php // echo $category; ?></li>
    </ol>-->
    <div class="grid">
        <h3><?php echo $category; ?></h3>
        <div class="row">
            <?php foreach($galleries as $key => $gallery){
                if(SLUG_ACTIVE==0){
                    $uri = get_base_url() . url_title(trim($gallery->gallery_name), 'dash', TRUE) . '-gs' . $gallery->id;    
                }else{
                    $uri = get_base_url() . $gallery->slug;
                }
                $image_url = is_null($gallery->image_name) ? base_url().'images/no-image.png' : base_url().'images/gallery/thumbnails/'.$gallery->image_name;
                $short_gallery_name = limit_text($gallery->gallery_name, 100);
//                $short_gallery_summary = limit_text($gallery->summary, 150);
                $gallery_images = modules::run('gallery/list_gallery_images',$gallery->id);
            ?>
            <div class="col-sm-4 grid_item_3">
                <div class="thumbnail">
                    <?php if(!empty($gallery_images)){ ?>
                    <?php foreach($gallery_images as $key => $image){
                        $image_b = is_null($image->image_name) ? base_url().'images/no-image.png' : base_url().'images/gallery/'.$image->image_name;
                        $image_s = is_null($image->image_name) ? base_url().'images/no-image.png' : base_url().'images/gallery/smalls/'.$image->image_name;
                        if($image->caption <> ''){
                            $image_caption = $image->caption;
                        }else{
                            $image_caption = $gallery->gallery_name;
                        }
                    ?>
                    <?php if($key==0){ ?>
                    <a class="grid_image fancybox-thumb ft-<?php echo $gallery->id; ?>" rel="fancybox-thumb" href="<?php echo $image_b; ?>" title="<?php echo $image_caption; ?>" onclick="fancyshow(<?php echo $gallery->id; ?>)">
                        <img title="<?php echo $image_caption; ?>" alt="<?php echo $image_caption; ?>" src="<?php echo $image_url; ?>" >
                    </a>
                    <?php }else{ ?>
                    <a class="fancybox-thumb ft-<?php echo $gallery->id; ?>" rel="fancybox-thumb" href="<?php echo $image_b; ?>" title="<?php echo $image_caption; ?>" style="display: none;">
                        <img title="<?php echo $image_caption; ?>" alt="<?php echo $image_caption; ?>" src="<?php echo $image_s; ?>"  style="display: none;" >
                    </a>
                    <?php }}}?>
                    <div class="caption">
                        <p class="grid_title"><a href="<?php echo $uri; ?>" title="<?php echo $gallery->gallery_name; ?>"><i class="fa fa-arrow-right"></i><?php echo $short_gallery_name; ?></a></p>
                        <!--<p class="grid_summary"><?php // echo $short_gallery_summary; ?></p>-->
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
