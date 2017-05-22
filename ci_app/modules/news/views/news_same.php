<?php if(!empty($news)) { ?>
<div class="related">
    <h3><em><?php echo $category; ?></em></h3>
    <div class="clearfix"></div>
    <div class="row">
    <?php foreach($news as $key => $value){
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($value->title), 'dash', TRUE) . '-ns' . $value->id;
        }else{
            $uri = get_base_url() . $value->slug;
        }
        $image = isset($value->thumbnail)?$value->thumbnail:base_url().'images/no-image.png';
        $value_title = limit_text($value->title, 100);
//        if($key%3==0){$related_class='related_first';}
//        elseif(($key+1)%3==0){$related_class='related_last';}
//        else{$related_class='';}
    ?>
        <div class="col-sm-4 related_item <?php // echo $related_class; ?>">
            <div class="related_item_image">
                <a title="<?php echo $value->title; ?>" href="<?php echo $uri; ?>">
                    <img alt="" title="<?php echo $value->title; ?>" src="<?php echo $image; ?>" />
                </a>
            </div>
            <h4><a title="<?php echo $value->title; ?>" href="<?php echo $uri; ?>"><?php echo $value_title; ?></a></h4>
        </div>
    <?php } ?>
    </div>
</div>
<?php } ?>