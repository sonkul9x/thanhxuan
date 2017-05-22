<?php if(!empty($faq)) { ?>
<div class="box">
    
    <h3>
        <?php echo $category; ?>
        <a href="<?php echo get_url_by_lang(get_language(), 'faq-send-question'); ?>" class="btn_question_send btn btn-warning btn-sm pull-right" title="<?php echo __('IP_faq_question_send'); ?>">
            <span class="glyphicon glyphicon-question-sign"></span>
            <?php echo __('IP_faq_question_send'); ?>
        </a>
    </h3>
    <div class="divider"></div>
    <?php 
        $uri = get_base_url() . url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;    
        $uri2 = get_base_url() . url_title(trim($faq->category), 'dash', TRUE) . '-q' . $faq->cat_id;    
    ?>

    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li><a href="<?php echo $uri2; ?>" title="<?php echo $faq->category; ?>"><?php echo $faq->category; ?></a></li>
        <li class="active"><?php echo $faq->title; ?></li>
    </ol>
    
    <div class="detail">
        <h1><?php echo $faq->title; ?></h1>
        <p class="detail-dateview">
            <?php echo __('IP_date_time'); ?>: <b><?php echo get_date_by_lang(get_language(),$faq->created_date); ?></b> | 
            <?php echo __('IP_view'); ?>: <b><?php echo $faq->viewed; ?></b> | 
            <?php echo __('IP_fullname'); ?>: <b><?php echo $faq->fullname; ?></b> | 
            <!--//<?php // echo __('IP_email'); ?>: <b><?php // echo $faq->email; ?></b>-->
        </p>
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
    
    <!--sharing-->
    <div class="sharing">
            <a href="mailto:?Subject=<?php echo $faq->title; ?>;Body=<?php echo $uri; ?>">
                <img src="<?php echo base_url(); ?>/images/email.png" alt="Email" title="Email">
            </a>
            <a target="_blank" href="http://twitter.com/share?url=<?php echo $uri; ?>">
                <img src="<?php echo base_url(); ?>/images/twitter.png" alt="Twitter" title="Twitter">
            </a>
            <a target="_blank" href="https://plus.google.com/share?url=<?php echo $uri; ?>">
                <img src="<?php echo base_url(); ?>/images/google.png" alt="Google+" title="Google+">
            </a>
            <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $uri; ?>">
                <img src="<?php echo base_url(); ?>/images/facebook.png" alt="Facebook" title="Facebook">
            </a>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-like" data-href="<?php echo $uri; ?>" data-width="450" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
    </div>

    <div class="box-content facebook_comment">
        <!--facebook comment-->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-comments" data-href="<?php echo $uri; ?>" data-width="100%" data-numposts="10" data-colorscheme="light" style="margin: 20px 0"></div>
    </div>

    <?php if(isset($faq_same)){echo $faq_same;} ?>
    
</div>
<?php }else {echo '<div class="box"><h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4></div>';} ?>