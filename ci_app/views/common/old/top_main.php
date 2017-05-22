<?php 
    $config = get_cache('configurations_' .  get_language());
    if(!empty($config)){
        $facebook_url = !empty($config['facebook_id'])?'https://www.facebook.com/'.$config['facebook_id']:'#';
        $logo = !empty($config['logo'])?base_url().UPLOAD_URL_LOGO.$config['logo']:base_url().'images/logo.png';
    }
    $this->load->library('Mobile_Detect');
    $detect = new Mobile_Detect();
    if($detect->isMobile() && !$detect->isTablet()){
        $isMobile = TRUE;
    } else {
        $isMobile = FALSE;
    }
?>
<div class="top_main">
    <div class="container">
        <?php if(empty($isMobile)){ ?>
        <div class="row">
            <div class="col-sm-2">
                <a href="<?php echo get_base_url(); ?>" class="logo" title="<?php echo __('IP_DEFAULT_TITLE'); ?>" >
                    <img src="<?php echo $logo; ?>" />
                </a>
            </div>
            <div class="col-sm-7 top_hotline">
                <?php $supports = modules::run('supports/get_supports',array('tel'=>TRUE,'onehit'=>TRUE)); ?>
                <?php if(!empty($supports)){ ?>
                <a class="top_support"><i class="fa fa-phone"></i>
                    <span><?php echo $supports->title; ?>:</span> <?php echo $supports->content; ?>
                </a>
                <?php } ?>
                <a href="<?php echo $facebook_url; ?>" target="_blank" title="FACEBOOK" class="t_facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" target="_blank" title="GOOGLE+" class="t_google"><i class="fa fa-google-plus"></i></a>
                <a href="#" target="_blank" title="TWITTER" class="t_twitter"><i class="fa fa-twitter"></i></a>
                <a href="/gio-hang" title="<?php echo __('IP_shopping_cart'); ?>" class="t_cart" rel="nofollow"><i class="fa fa-shopping-cart"></i></a>
                <a href="/gio-hang" title="<?php echo __('IP_shopping_cart'); ?>" class="t_cart_text" rel="nofollow"><?php echo __('IP_shopping_cart'); ?> (<?php echo $this->cart->total_items(); ?>)</a>
            </div>
            <div class="col-sm-3 top_search">
                <!--<div id="google_translate_element" class="google-language-bar"></div>-->
<!--                <div class="top_lang">
                    <a href="<?php // echo base_url(); ?>" title="Tiếng việt"><img src="<?php // echo base_url().'images/flag-vietnam.png'; ?>" title="Tiếng việt" alt="Tiếng việt" /></a>
                    <a href="<?php // echo base_url().'en'; ?>" title="English"><img src="<?php // echo base_url().'images/flag-uk.png'; ?>" title="English" alt="English" /></a>
                </div>-->
                <form class="searchform" method="post" roll="form" action="<?php echo get_form_submit_by_lang(get_language(),'searchform'); ?>">
                    <input type="text" class="searchinput" placeholder="<?php echo __('IP_search'); ?>" name="keyword" value="" title="<?php echo __('IP_search_input_title'); ?>">
                    <input type="submit" class="searchsubmit" value="<?php echo __('IP_search'); ?>" title="<?php echo __('IP_search'); ?>">
                </form>
            </div>
        </div>
        <?php }else{ ?>
        <div class="row">
            <div class="col-sm-12 top_search">
                <form class="searchform" method="post" roll="form" action="<?php echo get_form_submit_by_lang(get_language(),'searchform'); ?>">
                    <input type="text" class="searchinput" placeholder="<?php echo __('IP_search'); ?>" name="keyword" value="" title="<?php echo __('IP_search_input_title'); ?>">
                    <input type="submit" class="searchsubmit" value="<?php echo __('IP_search'); ?>" title="<?php echo __('IP_search'); ?>">
                </form>
            </div>
        </div>
        <?php } ?>
    </div>
</div>