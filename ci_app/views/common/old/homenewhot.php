<?php $data = modules::run('news/get_latest_news', array('onehit' => TRUE)); ?>
<?php if(!empty($data)) {
    if(SLUG_ACTIVE==0){
        $uri = get_base_url() . url_title(trim($data->title), 'dash', TRUE) . '-ns' . $data->id;
    }else{
        $uri = get_base_url() . $data->slug;
    }
    $image = isset($data->thumbnail)?$data->thumbnail:base_url().'images/no-image.png';
    $data_title = limit_text($data->title, 100);
    $data_summary = limit_text($data->summary, 300);
    $data_category = limit_text($data->category, 100);
    $created_date   = get_date_by_lang(get_language(), $data->created_date);
    $author = $data->creator_fullname;
?>
<div class="homenewhot">
    <div class="homenewhot-image">
        <a title="<?php echo $data->title; ?>" href="<?php echo $uri; ?>">
            <img alt="" title="<?php echo $data->title; ?>" src="<?php echo $image; ?>" />
        </a>
    </div>
    <div class="homenewhot-text">
        <h3><?php echo __('IP_news_hot'); ?></h3>
        <p><a title="<?php echo $data->title; ?>" href="<?php echo $uri; ?>"><?php echo $data_title; ?></a></p>
        <p><?php echo $data_summary; ?></p>
        <span><a href="<?php echo $uri; ?>">Xem tiếp</a></span>
        <div class="clearfix"></div>
    </div>
</div>
<?php } ?>
