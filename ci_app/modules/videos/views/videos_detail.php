<div class="box">
    <?php if(!empty($videos)) { ?>
    <?php 
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($videos->title), 'dash', TRUE) . '-vs' . $videos->id;    
            $uri2 = get_base_url() . url_title(trim($category), 'dash', TRUE) . '-v' . $videos->cat_id;
        }else{
            $uri = get_base_url() . $videos->slug;
            $uri2 = get_base_url() . $category_slug;
        }
    ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li><a href="<?php echo $uri2; ?>" title="<?php echo $category; ?>"><?php echo $category; ?></a></li>
        <li class="active"><?php echo $videos->title; ?></li>
    </ol>
    <h1 class="title"><?php echo $videos->title; ?></h1>
    
    <p class="posted_on"><i class="fa fa-calendar"></i><?php echo get_date_by_lang(get_language(), date('Y-m-d H:i:s',$videos->create_time)); ?><span>&verbar;</span><i class="fa fa-eye"></i><?php echo $videos->viewed; ?></p>
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
    
    <p><?php echo $videos->summary; ?></p>
    <?php if(!empty($videos_items)){ ?>
    <?php foreach($videos_items as $key => $image){
        $item_image = $image->image_name;
        $item_url = $image->url;
        if($image->caption <> ''){
            $image_caption = $videos->title . ' - ' . $image->caption;
        }else{
            $image_caption = $videos->title;
        }
    ?>
    <!-- 16:9 aspect ratio -->
<!--    <div class="embed-responsive embed-responsive-16by9">
      <iframe class="embed-responsive-item" src="..."></iframe>
    </div>-->

    <!-- 4:3 aspect ratio -->
    <div class="embed-responsive embed-responsive-4by3">
      <iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo $image->youtube_video_id; ?>"></iframe>
    </div>

    <?php }} ?>
    
    <div class="facebook_comment">
        <!--facebook comment-->

        <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light" style="margin: 20px 0"></div>
    </div>
    
    <?php if(isset($videos_same)){echo $videos_same;} ?>
    <?php }else echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>'; ?>
</div>
