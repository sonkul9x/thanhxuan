<?php $advs = modules::run('advs/get_advs_slide_show',array('type'=>3, 'onehit'=>TRUE));
?>
<?php if(!empty($advs)) {
    $url_path = ($advs->url_path == "" || $advs->url_path == "#") ? "" : $advs->url_path;
    $title = ($advs->title == NULL || $advs->title == '') ? '' : $advs->title;
    $image = $advs->image_name;
    $image_url = base_url() . ADVS_IMAGE_URL . $image;
?>
<div class="boxtel">
    <a <?php if($url_path <> ''){ ?>href="<?php echo $url_path; ?>"<?php } ?> title="<?php echo $title; ?>" >
        <img title="<?php echo $title; ?>" alt="" src="<?php echo $image_url; ?>" border="0" >
    </a>
</div>
<?php } ?>