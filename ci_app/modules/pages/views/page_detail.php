<?php if(!empty($page)) { ?>
<div class="box pages">

    <h1 class="title"><?php echo $page['title']; ?></h1>
    
    <div class="post-entry">
        
        <span class="post-meta">Đăng bởi <?php echo $page['creator_fullname']; ?> <span class="line">·</span> vào <?php echo get_date_by_lang(get_language(), $page['created_date']); ?> <span class="line">·</span> lượt xem: <?php echo $page['viewed']; ?></span>
        
        <h2 class="post-summary"><?php echo $page['summary']; ?></h2>
        
        <?php echo $page['content']; ?>
        
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