<?php if(!empty($advs)){ ?>
<div class="slide_main">
<!--<div class="container">
    <div class="row">-->
        <div class="slidex">
            <?php if(count($advs) == 1){ ?>
            <?php $slide = $advs[0];
                $url_path = ($slide->url_path === "" || $slide->url_path === "#") ? "" : $slide->url_path;
                $title = ($slide->title == NULL || $slide->title == DOMAIN_NAME) ? '' : $slide->title;
                $image = $slide->image_name;
                $image_url = base_url() . ADVS_IMAGE_URL . $image;
            ?>
            <a <?php if($url_path){ ?> href="<?php echo $url_path; ?>" <?php } ?> title="<?php echo $title;?>">
                <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" />
            </a>
            <?php }else{ ?>
            <div class="slider-wrapper theme-default">
                <div id="slider" class="nivoSlider">
                    <?php foreach($advs as $key => $slide){ 
                        $url_path = ($slide->url_path === "" || $slide->url_path === "#") ? "" : $slide->url_path;
                        $title = ($slide->title == NULL || $slide->title == '') ? '' : $slide->title;
                        $image = $slide->image_name;
                        $image_url = base_url() . ADVS_IMAGE_URL . $image;
                    ?>
                    <a <?php if($url_path){ ?> href="<?php echo $url_path; ?>" <?php } ?>  data-thumb="<?php echo $image_url; ?>" title="<?php echo $title;?>">
                        <img src="<?php echo $image_url; ?>" data-thumb="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" title="<?php echo $title;?>" />
                    </a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            
        </div>
<!--    </div>
</div>-->
</div>
<?php } ?>