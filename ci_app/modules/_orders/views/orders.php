<?php if(!empty($faqs)){ ?>
<div class="box">
    <h3>
        <?php echo $category; ?>
        <a href="<?php echo get_url_by_lang(get_language(), 'faq-send-question'); ?>" class="btn_question_send btn btn-warning btn-sm pull-right" title="<?php echo __('IP_faq_question_send'); ?>">
            <span class="glyphicon glyphicon-question-sign"></span>
            <?php echo __('IP_faq_question_send'); ?>
        </a>
    </h3>
    <div class="divider"></div>
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php echo limit_text($category, 60); ?></li>
    </ol>
    <div class="list">
    <?php foreach ($faqs as $key => $faq) {
        $uri = get_base_url() . url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;
        $image_thumbnail = (isset($faq->thumbnail) && $faq->thumbnail <> '')?$faq->thumbnail:base_url().'images/no-image.png';
    ?>
        <div class="row list_item">
            <div class="col-sm-3 list_thumb">
                <a href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>"><img alt="<?php echo $faq->title; ?>" src="<?php echo $image_thumbnail; ?>" title="<?php echo $faq->title; ?>" ></a>
            </div>
            <div class="col-sm-9 list_content">
                <p class="list_title"><a href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>"><?php echo $faq->title; ?></a><span>(<?php echo get_date_by_lang(get_language(), $faq->created_date); ?>)</span></p>
                <p class="list_summary"><?php echo limit_text($faq->summary, 200); ?></p>
                <a class="viewmore" href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>"><?php echo __('IP_view_detail'); ?></a>
            </div>
        </div>
    <?php } ?>
    </div>
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php }else{echo '<div class="box"><h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4></div>';} ?>
