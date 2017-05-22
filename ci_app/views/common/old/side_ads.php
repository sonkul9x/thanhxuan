<?php $advs = modules::run('advs/get_advs_slide_show',array('type'=>4)); ?>
<?php if(!empty($advs)) { ?>
<div class="sidebox sideads">
    <!--<h3><?php // echo __('IP_ads'); ?></h3>-->
    <?php foreach($advs as $key => $value){
        $url_path = ($value->url_path == "" || $value->url_path == "#") ? "" : $value->url_path;
        $title = ($value->title == NULL || $value->title == '') ? '' : $value->title;
        $image = $value->image_name;
        $image_url = base_url() . ADVS_IMAGE_URL . $image;
    ?>
        <div class="row">
            <div class="col-sm-12">
                <a <?php if($url_path <> ''){ ?>href="<?php echo $url_path; ?>"<?php } ?> title="<?php echo $title; ?>" >
                    <img title="<?php echo $title; ?>" alt="" src="<?php echo $image_url; ?>" border="0" >
                </a>
            </div>
        </div>
    <?php } ?>
</div>
<?php } ?>