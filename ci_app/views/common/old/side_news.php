<?php $data = modules::run('news/get_side_news'); ?>
<?php if(!empty($data)) { ?>
<div class="sidebox">
    <h3><?php echo __('IP_news_topview'); ?></h3>
    <?php foreach($data as $key => $value){
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($value->title), 'dash', TRUE) . '-ns' . $value->id;
        }else{
            $uri = get_base_url() . $value->slug;
        }
        $image = isset($value->thumbnail)?$value->thumbnail:base_url().'images/no-image.png';
//        $value_title = limit_text($value->title, 100);
//        $value_summary = limit_text($value->summary, 300);
        $value_category = limit_text($value->category, 100);
        $created_date   = get_date_by_lang(get_language(), $value->created_date);
        $author = $value->creator_fullname;
    ?>
    <div class="row side_item side_items">
        <?php if($key>0){ ?><div class="line"></div><?php } ?>
        <div class="col-sm-3 side_items_image">
            <a href="<?php echo $uri; ?>" title="<?php echo $value->title; ?>">
                <img alt="" src="<?php echo $image; ?>" title="<?php echo $value->title; ?>" >
            </a>
        </div>
        <div class="col-sm-9 side_items_title">
            <a href="<?php echo $uri; ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>