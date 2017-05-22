<?php
    $config = get_cache('configurations_' .  get_language());
    $this->load->library('Mobile_Detect');
    $detect = new Mobile_Detect();
    if($detect->isMobile() && !$detect->isTablet()){
        $isMobile = TRUE;
    } else {
        $isMobile = FALSE;
    }
?>
            <footer>
            <?php if(!$isMobile){ ?>
               <div class="content-wrap">
                    <div class="one-fourth first">
                        <h4>Danh mục sản phẩm</h4>
                         <?php
                            if(isset($active_menu)){$active_menu=$active_menu;}else{$active_menu=NULL;}
                            if(isset($current_menu)){$current_menu=$current_menu;}else{$current_menu=NULL;}
                        ?>
                        <?php echo modules::run('menus/menus/get_main_menus',array('current_menu'=>$current_menu,'active_menu'=>$active_menu,'menu_type'=>5)); ?>
                    </div>
                    <div class="one-fourth">
                        <h4>Hướng dẫn</h4>
                         <?php
                            if(isset($active_menu)){$active_menu=$active_menu;}else{$active_menu=NULL;}
                            if(isset($current_menu)){$current_menu=$current_menu;}else{$current_menu=NULL;}
                        ?>
                        <?php echo modules::run('menus/menus/get_main_menus',array('current_menu'=>$current_menu,'active_menu'=>$active_menu,'menu_type'=>6)); ?>
                    </div>
                    <div class="one-fourth">
                        <h4>Điều khoản chung</h4>
                         <?php
                            if(isset($active_menu)){$active_menu=$active_menu;}else{$active_menu=NULL;}
                            if(isset($current_menu)){$current_menu=$current_menu;}else{$current_menu=NULL;}
                        ?>
                        <?php echo modules::run('menus/menus/get_main_menus',array('current_menu'=>$current_menu,'active_menu'=>$active_menu,'menu_type'=>7)); ?>
                    </div>
                    <div class="one-fourth">
                        <h4>Thông tin khác</h4>
                        <?php
                            if(isset($active_menu)){$active_menu=$active_menu;}else{$active_menu=NULL;}
                            if(isset($current_menu)){$current_menu=$current_menu;}else{$current_menu=NULL;}
                        ?>
                        <?php echo modules::run('menus/menus/get_main_menus',array('current_menu'=>$current_menu,'active_menu'=>$active_menu,'menu_type'=>8)); ?>
                    </div>
                </div>
                <?php } ?>
                <div class="content-wrap">
                    <div style="clear:both; display:block;" class="social-wrap"></div>                     
                    <ul class="social">
                        <li><a href="#" class="tip" title="Facebook"><img src="<?php echo base_url(); ?>frontend/images/social-icon-facebook.png" alt="Facebook"></a></li>
                        <li><a href="#" class="tip" title="Dribbble"><img src="<?php echo base_url(); ?>frontend/images/social-icon-dribbble.png" alt="Dribbble"></a></li>
                        <li><a href="#" class="tip" title="Flickr"><img src="<?php echo base_url(); ?>frontend/images/social-icon-flickr.png" alt="Flickr"></a></li>
                        <li><a href="#" class="tip" title="Pinterest"><img src="<?php echo base_url(); ?>frontend/images/social-icon-pinterest.png" alt="Pinterest"></a></li>
                        <li><a href="#" class="tip" title="Twitter"><img src="<?php echo base_url(); ?>frontend/images/social-icon-twitter.png" alt="Twitter"></a></li>
                        <li><a href="#" class="tip" title="RSS"><img src="<?php echo base_url(); ?>frontend/images/social-icon-rss.png" alt="RSS"></a></li>
                    </ul>
                    <ul class="payment">
                        <li><a href="#" class="tip" title="Paypal"><img src="<?php echo base_url(); ?>frontend/images/payment-icon-paypal.png" alt="Paypal"></a></li>
                        <li><a href="#" class="tip" title="American Express"><img src="<?php echo base_url(); ?>frontend/images/payment-icon-ae.png" alt="American Express"></a></li>
                        <li><a href="#" class="tip" title="Discover"><img src="<?php echo base_url(); ?>frontend/images/payment-icon-discover.png" alt="Discover"></a></li>
                        <li><a href="#" class="tip" title="Master Card"><img src="<?php echo base_url(); ?>frontend/images/payment-icon-mastercard.png" alt="Master Card"></a></li>
                        <li><a href="#" class="tip" title="Visa"><img src="<?php echo base_url(); ?>frontend/images/payment-icon-visa.png" alt="Visa"></a></li>
                    </ul>
                    <p style="clear:both; display:block;">&copy; 2013 <a href="index-2.html">Shopymart</a>, All Rights Reserved. Designed by: <a href="#">louiejiemahusay</a></p>
                </div>
            </footer>
        </div><!--end:container-->
    </div><!--end:page_wrap-->
<?php
if(!empty($config)){
    echo (isset($config['google_tracker']))?$config['google_tracker']:'';
}
?>
<?php if(!empty($is_home) || $is_home == TRUE){ ?>
    <script type="text/javascript">
//------JCAROUSEL-------------
        function mycarousel_initCallback(carousel){
        // Disable autoscrolling if the user clicks the prev or next button.
        carousel.buttonNext.bind('click', function() {
            carousel.startAuto(0);
        });
        carousel.buttonPrev.bind('click', function() {
            carousel.startAuto(0);
        });
        // Pause autoscrolling if the user moves with the cursor over the clip.
        carousel.clip.hover(function() {
            carousel.stopAuto();
        }, function() {
            carousel.startAuto();
        });
    };
    jQuery(document).ready(function() {
        jQuery('#mycarousel, #mycarouselnew').jcarousel({
            auto: 0,
            wrap: 'last',
            initCallback: mycarousel_initCallback
        });
    }); 
</script>    
<script type="text/javascript">
   jQuery(function($){
        $(".tweet").tweet({
          join_text: "auto",
          username: "html5awesome",
          avatar_size: 48,
          count: 3,
          auto_join_text_default: " we said, ",
          auto_join_text_ed: " we ",
          auto_join_text_ing: " we were ",
          auto_join_text_reply: " we replied ",
          auto_join_text_url: " we were checking out ",
          loading_text: "loading tweets..."
        });
      });
  </script>
    <script type="text/javascript">(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "../../../connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php if(isset($scripts)){echo $scripts;} ?>
 <?php } ?>
    
    <?php if(!empty($config['livechat'])){ ?>
    <?php echo $config['livechat']; ?>
    <?php } ?>
   
</body>
</html>