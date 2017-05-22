<?php if(!empty($services)) { ?>
<div class="box">
    <h3><i class="fa fa-dedent"></i><?php echo $category; ?></h3>
    <div class="divider"></div>
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php echo limit_text($category,90); ?></li>
    </ol>
    <div class="col-sm-12 list_services">
        <div class="row">
            <ul>
            <?php foreach($services as $key => $value){ 
                $url_path = ($value->url_path == "" || $value->url_path == "#") ? "" : $value->url_path;
                $title = ($value->title == NULL || $value->title == '') ? '' : $value->title;
                $image = $value->image_name;
                $image_url = base_url() . ADVS_IMAGE_URL . $image;
                $summary = limit_text($value->summary, 500);
            ?>
            <li>
                <img title="<?php echo $title; ?>" alt="<?php echo $title; ?>" src="<?php echo $image_url; ?>" >
                <div class="list_services_content">
                    <a <?php if($url_path){ ?> href="<?php echo $url_path; ?>" <?php } ?> title="<?php echo $title; ?>"><?php echo $title; ?></a>
                    <p><?php echo $summary; ?></p>
                </div>
            </li>
            <?php } ?>
            </ul>
        </div>
    </div>
        
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php }else echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>'; ?>