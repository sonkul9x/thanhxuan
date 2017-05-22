<?php

    $config = get_cache('configurations_' .  get_language());

    if(!empty($config)){

//        $facebook_url = !empty($config['facebook_id'])?'https://www.facebook.com/'.$config['facebook_id']:'#';

        $logo = !empty($config['logo'])?base_url().UPLOAD_URL_LOGO.$config['logo']:base_url().'images/logo.jpg';

    }

    $this->load->library('Mobile_Detect');

    $detect = new Mobile_Detect();

    if($detect->isMobile() && !$detect->isTablet()){

        $isMobile = TRUE;

    } else {

        $isMobile = FALSE;

    }

?>
<header>
            <div id="top">
                <span>Hello! default welcome message</span>
              <?php /*   <div class="top_lang">

                    <a href="<?php // echo base_url(); ?>" title="Tiếng việt"><img src="<?php // echo base_url().'images/flag-vietnam.png'; ?>" title="Tiếng việt" alt="Tiếng việt" /></a>

                    <a href="<?php // echo base_url().'en'; ?>" title="English"><img src="<?php // echo base_url().'images/flag-uk.png'; ?>" title="English" alt="English" /></a> */ ?>
                <div>
                    <p>Ngôn Ngữ:
                    <label>
                        <select>
                            <option selected>Việt nam </option>
                            <option>EngLish</option>                           
                        </select>

                    </label>​
                    </p>                   
                </div>
            </div><!--end:top-->            
            <div id="top3">
                <h1 class="logo"><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_DEFAULT_TITLE'); ?>"><img src="<?php echo $logo; ?>" alt="" /></a></h1>
                 <form class="searchform search_bar" method="post" roll="form" action="<?php echo get_form_submit_by_lang(get_language(),'searchform'); ?>">
					<fieldset>
                    <input type="text" class="searchinput" placeholder="<?php echo __('IP_search'); ?>" name="keyword" value="" title="<?php echo __('IP_search_input_title'); ?>">

                    <input type="submit" class="submit" class="submit" value="<?php echo __('IP_search'); ?>" title="<?php echo __('IP_search'); ?>">
					</fieldset>
                </form>
               
            </div><!--end:top3-->
        </header>