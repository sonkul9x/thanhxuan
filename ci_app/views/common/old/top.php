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

<div class="top">

    <div class="container">

        <div class="row">

            <div class="col-sm-4">

                <div class="top_logo"><img src="<?php echo $logo; ?>" alt="" /></div>

            </div>

            <div class="col-sm-8">

                <div class="top_bn"><img src="<?php echo site_url().'images/giaohang.jpg' ?>" alt="" /></div>

            </div>

        </div>

    </div>

</div>