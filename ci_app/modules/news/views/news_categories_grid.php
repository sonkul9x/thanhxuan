<div class="box">
    
<!--    <ol class="breadcrumb">
        <li><a href="<?php // echo get_base_url(); ?>" title="<?php // echo __('IP_default_company'); ?>"><?php // echo __('IP_home_page'); ?></a></li>
        <li class="active"><?php // echo $category; ?></li>
    </ol>-->
    
    <h3><?php echo $category; ?></h3>
    <div class="divider"></div>

    <?php if(!empty($data)) { ?>
    <div class="grid">
        <div class="row">
            <?php foreach ($data as $key => $value) {
                if(SLUG_ACTIVE==0){
                    $uri = get_base_url() . url_title(trim($value->category), 'dash', TRUE) . '-n' . $value->id;
                }else{
                    $uri = get_base_url() . $value->slug;
                }
                $image_thumbnail = (isset($value->thumbnail) && $value->thumbnail <> '')?$value->thumbnail:base_url().'images/no-image.png';
            ?>
            <div class="col-sm-4 grid_item_31">
                <div class="thumbnail">
                    <a class="grid_image" href="<?php echo $uri; ?>" title="<?php echo $value->category; ?>">
                        <img title="<?php echo $value->category; ?>" alt="<?php echo $value->category; ?>" src="<?php echo $image_thumbnail; ?>" >
                    </a>
                    <div class="caption">
                        <p class="grid_title"><a href="<?php echo $uri; ?>" title="<?php echo $value->category; ?>"><?php echo limit_text($value->category, 100); ?></a></p>
                    </div>
                </div>
                <div class="triangle"></div>
                <div class="triangle-down"></div>
                <?php $news = modules::run('news/get_news_by_conditions',array('cat_id'=>$value->id)); ?>
                <?php if(!empty($news)){ ?>
                <div class="grid_child">
                    <?php foreach($news as $k => $v){ 
                        if(SLUG_ACTIVE==0){
                            $uri = get_base_url() . url_title(trim($v->title), 'dash', TRUE) . '-ns' . $v->id;
                        }else{
                            $uri = get_base_url() . $v->slug;
                        }
                        $image_thumbnail = (isset($v->thumbnail) && $v->thumbnail <> '')?base_url().$v->thumbnail:base_url().'images/no-image.png';
                    ?>
                    <div class="row">
                        <div class="col-sm-4 grid_child_image">
                            <a href="<?php echo $uri; ?>" title="<?php echo $v->title; ?>">
                                <img src="<?php echo $image_thumbnail; ?>" title="<?php echo $v->title; ?>" alt="<?php echo $v->title; ?>" />
                            </a>
                        </div>
                        <div class="col-sm-8 grid_child_title">
                            <a href="<?php echo $uri; ?>" title="<?php echo $v->title; ?>">
                                <span><?php echo $v->title; ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="divider"></div>
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <div class="clearfix"></div>
    <?php } ?>
    
    <div class="facebook_comment">
        <!--facebook comment-->

        <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light" style="margin: 20px 0"></div>
    </div>
</div>
