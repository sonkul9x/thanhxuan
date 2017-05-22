<?php $adv_left = modules::run('advs/get_advs_by_type',4); ?>
<?php if(!empty($adv_left)){
    $url_path_left = ($adv_left->url_path === "" || $adv_left->url_path === "#") ? "" : $adv_left->url_path;
    $title_left = ($adv_left->title == NULL || $adv_left->title == '') ? '' : $adv_left->title;
    $image_left = $adv_left->image_name;
    $image_left_url = base_url() . ADVS_IMAGE_URL . $image_left;
?>
<div class="floating_left moveFloat">
    <a <?php if($url_path_left){ ?> href="<?php echo $url_path_left; ?>" <?php } ?> title="<?php echo $title_left;?>">
        <img src="<?php echo $image_left_url; ?>" alt="<?php echo $title_left; ?>" />
    </a>
</div>
<?php }else{ ?>
<div class="floating_left moveFloat">
</div>
<?php } ?>
<?php $adv_right = modules::run('advs/get_advs_by_type',3); ?>
<?php if(!empty($adv_right)){
    $url_path_right = ($adv_right->url_path === "" || $adv_right->url_path === "#") ? "" : $adv_right->url_path;
    $title_right = ($adv_right->title == NULL || $adv_right->title == '') ? '' : $adv_right->title;
    $image_right = $adv_right->image_name;
    $image_right_url = base_url() . ADVS_IMAGE_URL . $image_right;
?>
<div class="floating_right moveFloat">
    <a <?php if($url_path_right){ ?> href="<?php echo $url_path_right; ?>" <?php } ?> title="<?php echo $title_right;?>">
        <img src="<?php echo $image_right_url; ?>" alt="<?php echo $title_right; ?>" />
    </a>
</div>
<?php }else{ ?>
<div class="floating_right moveFloat">
</div>
<?php } ?>
