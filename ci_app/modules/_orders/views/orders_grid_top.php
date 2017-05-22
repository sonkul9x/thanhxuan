<?php if(!empty($faq)) { ?>
<!--<div class="">-->
    <?php
    $uri = get_base_url() . url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;
    $image = is_null($faq->thumbnail) ? base_url().'images/no-image.png' : $faq->thumbnail;
    ?>
    <div class="col-sm-12 grid_top">
        <div class="row">
            <div class="col-sm-5 grid_top_image">
                 <a href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>">
                    <img title="<?php echo $faq->title; ?>" alt="<?php echo $faq->title; ?>" src="<?php echo $image; ?>" >
                </a>
            </div>
            <div class="col-sm-7 grid_top_text">
                <strong><?php echo $faq->title; ?></strong>
                <p><?php echo limit_text($faq->summary, 500); ?></p>
                <div class="seemore">
                    <a href="<?php echo $uri; ?>" title="<?php echo __('IP_see_more'); ?>">
                        <img alt="<?php echo __('IP_see_more'); ?>" title="<?php echo __('IP_see_more'); ?>" src="<?php echo base_url().'images/view.png'; ?>" />
                    </a>
                </div>
            </div>
        </div>
    </div>
<!--</div>-->
<?php } ?>