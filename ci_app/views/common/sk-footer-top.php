<div class="container-2">
    <div style="clear:both; display:block; height:40px"></div>
    <div class="one-third first info-contact">
        <h4>Về Chúng tôi</h4>
         <?php  $config = get_cache('configurations_' .  get_language());
          if(!empty($config['footer_contact'])){ ?>
        <?php echo $config['footer_contact']; ?>
        <?php } ?>
    </div>
    <div class="one-third">
        <div class='tweet query'></div>
    </div>
    <div class="one-third">
        <div class="fb-like-box" data-href="http://www.facebook.com/HTML5Awesome" data-width="280" data-show-faces="true" data-stream="false" data-border-color="#e5e5e5" data-header="false"></div>
    </div>
</div><!--end:container-2-->
<div class="container-2">
    <div style="clear:both; display:block; height:40px"></div>
    <div class="ship">
        <a href="#"><img src="<?php echo base_url(); ?>frontend/images/service-1.png" alt=""></a>
        <h4><a href="#">Miễn phí vận chuyển</a></h4>
        <span>Khi bạn đặt hàng trên 500.000 VNĐ</span>
    </div>
    <div class="subs">
        <h4>Sign up for our Newsletter</h4>
        <form action="#" method="post" class="subscribes">
            <fieldset>
              <input type="text" name="subscribe" class="subscribe" value="Subscribe" onBlur="if (this.value == ''){this.value = 'Subscribe'; }" onFocus="if (this.value== 'Subscribe') {this.value = ''; }" />
              <input type="submit" name="submit" value="Submit" class="submit" />
            </fieldset>
        </form>
    </div>
</div><!--end:container-2-->