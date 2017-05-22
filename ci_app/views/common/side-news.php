<?php $data = modules::run('news/get_side_news'); ?>
<?php if(!empty($data)) { ?>
<div class="side">
    <h4><?php echo __('IP_news_topview'); ?></h4>
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
        $date = $value->created_date;
        $newDate = date("d/m/Y", strtotime($date));
    ?>
   
    <div class="entry">
        <div class="da-thumbs">
            <div>
                 <img alt="" src="<?php echo $image; ?>" title="<?php echo $value->title; ?>" >
                <article class="da-animate da-slideFromRight" style="display: block;">
                    <p><a href="<?php echo $uri; ?>" title="<?php echo $value->title; ?>" class="link"></a></p>
                </article>
            </div>
        </div>
        <h3><a href="<?php echo $uri; ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a></h3>
        <span><a href="<?php echo $uri; ?>" title="<?php echo $value->title; ?>"><?php echo $newDate; ?></a></span>
    </div>
     <?php } ?>    
</div><!--end:side-->
<?php } ?>