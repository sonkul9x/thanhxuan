<?php if(!empty($news)) { 
    if(SLUG_ACTIVE==0){
        $uri = get_base_url() . url_title(trim($news->title), 'dash', TRUE) . '-ns' . $news->id;    
        $uri2 = get_base_url() . url_title(trim($news->category), 'dash', TRUE) . '-n' . $news->cat_id;    
    }else{
        $uri = get_base_url() . $news->slug;
        $uri2 = get_base_url() . $category_slug;
    }
    $created_date   = get_date_by_lang(get_language(), $news->created_date);
    ?>
<div class="box">
    
    <div class="title">
        <a href="<?php echo $uri2; ?>" title="<?php echo $news->category; ?>" class="heading"><?php echo $news->category; ?></a>
    </div>
    
    <div class="post-header">
        <h1><?php echo $news->title; ?></h1>
        <span class="post-meta">Đăng vào <?php echo $created_date; ?> <span class="line">·</span> lượt xem: <?php echo $news->viewed; ?></span>
    </div>
    
    <div class="post-entry">
        <h2 class="post-summary"><?php echo $news->summary ?></h2>
        
        <?php echo $news->content; ?>
        
        <?php if(isset($news_same)){echo $news_same;} ?>
        
        <?php if(!empty($tags)) { ?>
        <div class="post-tags">
            <?php foreach($tags as $key => $tag){ 
                $taglink = get_url_by_lang(get_language(),'news_tags').'/'.url_title(trim($tag), 'dash', TRUE);
            ?>
            <a rel="tag" href="<?php echo $taglink; ?>" title="<?php echo $tag; ?>"><?php echo $tag; ?></a>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div class="post-share">
        <span class="share-text">
            Share 
        </span>
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
    </div>

    <div id="comments" class="comments-area">
        <div id="respond" class="comment-respond">
            <!--facebook comment-->

            <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light" style="margin: 20px 0"></div>
        </div>
    </div>

</div>
<?php }else {echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>';} ?>