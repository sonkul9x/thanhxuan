<?php if(!empty($category)) { ?>
<div class="box">
    
<!--    <ol class="breadcrumb">
        <li><a href="<?php // echo get_base_url(); ?>" title="<?php // echo __('IP_default_company'); ?>"><?php // echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php // echo limit_text($category,90); ?></li>
    </ol>-->
    
    <h3 class="grid_top_h3"><?php echo $category; ?></h3>
    <!--<div class="divider"></div>-->
    
    <?php echo modules::run('faq/get_top_faq',$category_id) ?>
    
    <?php if(!empty($faqs)) { ?>
    <div class="col-sm-12 grid">
        <div class="row">
        <?php foreach($faqs as $key => $faq){
        $uri = get_base_url() . url_title(trim($faq->title), 'dash', TRUE) . '-ns' . $faq->id;
        $image = is_null($faq->thumbnail) ? base_url().'images/no-image.png' : $faq->thumbnail;
        ?>
        <div class="col-sm-4 grid_item">
            <div class="thumbnail">
                <a class="grid_image" href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>">
                    <span class="rollover"></span>
                    <img title="<?php echo $faq->title; ?>" alt="<?php echo $faq->title; ?>" src="<?php echo $image; ?>" >
                </a>
                <div class="caption">
                    <a class="grid_title" href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>"><?php echo $faq->title; ?></a>
                    <p class="grid_summary"><?php echo limit_text($faq->summary, 200); ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
        </div>
    </div>
    
    <div class="divider"></div>
    
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <?php } ?>
</div>
<?php }else echo '<div class="box"><h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4></div>'; ?>