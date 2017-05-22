<div class="box">
    <?php if(!empty($faq)) { ?>
<!--    <h3>
        <a href="<?php // echo get_url_by_lang(get_language(), 'faq-send-question'); ?>" class="btn_question_send btn btn-warning btn-sm pull-right" title="<?php // echo __('IP_faq_question_send'); ?>">
            <span class="glyphicon glyphicon-question-sign"></span>
            <?php // echo __('IP_faq_question_send'); ?>
        </a>
    </h3>-->
    <?php 
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;    
            $uri2 = get_base_url() . url_title(trim($faq->category), 'dash', TRUE) . '-q' . $faq->cat_id;     
        }else{
            $uri = get_base_url() . $faq->slug;
            $uri2 = get_base_url() . $category_slug;
        }
    ?>

    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li><a href="<?php echo $uri2; ?>" title="<?php echo $faq->category; ?>"><?php echo $faq->category; ?></a></li>
        <li class="active"><?php echo $faq->title; ?></li>
    </ol>
    
    <div class="detail">
        <h1><?php echo $faq->title; ?></h1>
        <p class="posted_on"><i class="fa fa-calendar"></i><?php echo get_date_by_lang(get_language(), $faq->created_date); ?><span>&verbar;</span><i class="fa fa-eye"></i><?php echo $faq->viewed; ?></p>
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
        <p class="question_sent_by"><i class="fa fa-user"></i><?php echo __('IP_faq_fullname'); ?>:&nbsp;<?php echo $faq->fullname; ?></p>
        <h2 class="detail-summary">
            <?php echo $faq->summary ?>
        </h2>
        <div class="detail-content">
            <?php echo $faq->content; ?>
        </div>
    </div>
    
    <?php if(!empty($tags)) { ?>
    <div class="tags">
        <strong><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<?php echo __('IP_tags'); ?></strong>
        <p>
        <?php foreach($tags as $key => $tag){ 
            $taglink = get_url_by_lang(get_language(),'faq-tags').'/'.url_title(trim($tag), 'dash', TRUE);
        ?>
        <?php if($key > 0){ echo ',';} ?>
        <a href="<?php echo $taglink; ?>" title="<?php echo $tag; ?>"><?php echo $tag; ?></a>
        <?php } ?>
        </p>
    </div>
    <?php } ?>
    
    <div class="facebook_comment">
        <!--facebook comment-->
        
        <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light" style="margin: 20px 0"></div>
    </div>

    <?php if(isset($faq_same)){echo $faq_same;} ?>
    <?php }else {echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>';} ?>
</div>
