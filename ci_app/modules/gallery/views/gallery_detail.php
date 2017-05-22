<div class="box">
    <?php if(!empty($gallery)) { ?>
    <?php 
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($gallery->gallery_name), 'dash', TRUE) . '-gs' . $gallery->id;    
            $uri2 = get_base_url() . url_title(trim($category), 'dash', TRUE) . '-g' . $gallery->cat_id;
        }else{
            $uri = get_base_url() . $gallery->slug;
            $uri2 = get_base_url() . $category_slug;
        }
    ?>
    
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li><a href="<?php echo $uri2; ?>" title="<?php echo $category; ?>"><?php echo $category; ?></a></li>
        <li class="active"><?php echo $gallery->gallery_name; ?></li>
    </ol>
    <div class="detail">
        <h1><?php echo $gallery->gallery_name; ?></h1>
        <p class="posted_on"><i class="fa fa-calendar"></i><?php echo get_date_by_lang(get_language(), date('Y-m-d H:i:s',$gallery->create_time)); ?><span>&verbar;</span><i class="fa fa-eye"></i><?php echo $gallery->viewed; ?></p>
        <!--sharing-->
        <div class="sharing">
            <div class="sharing_tab sharing_g">
                <script src="https://apis.google.com/js/platform.js" async defer></script>
                <g:plusone size="medium" data-annotation="bubble"></g:plusone>
            </div>
            <div class="sharing_tab sharing_t">
                <a href="https://twitter.com/share" class="twitter-share-button" data-via="">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </div>
            <div class="sharing_tab sharing_f">
                
                <div class="fb-like" data-href="<?php echo current_url(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
            </div>
        </div>
        <h2 class="detail-summary">
            <?php echo $gallery->summary ?>
        </h2>
        <div class="detail-content">
            
            <?php if(!empty($gallery_images)){ ?>
            <div class="html5gallery" data-skin="light" data-width="550" data-height="330" data-slideshadow="false" data-resizemode="fill" data-responsive="true">
            <?php foreach($gallery_images as $key => $value){ 
                $image_url = is_null($value->image_name) ? base_url().'images/no-image.png' : base_url().'images/gallery/'.$value->image_name;
                $image_thumb_url = is_null($value->image_name) ? base_url().'images/no-image.png' : base_url().'images/gallery/smalls/'.$value->image_name;
                $caption = !empty($value->caption)?$value->caption:$gallery->gallery_name;
            ?>
                <a href="<?php echo $image_url; ?>" title="<?php echo $caption; ?>">
                    <img title="<?php echo $caption; ?>" src="<?php echo $image_thumb_url; ?>" alt="<?php echo $caption; ?>">
                </a>
            <?php } ?>
            </div>
            <?php } ?>
        
            <div class="clearfix"></div>
            <?php echo $gallery->content; ?>
        </div>
    </div>
    
    <?php if(isset($gallery_same)){echo $gallery_same;} ?>
    <?php }else{ echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>';} ?>
</div>
