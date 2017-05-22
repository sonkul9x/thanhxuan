<?php if(!empty($faqs)) { ?>
<div class="same_list">
    <h5 class="label label-default"><?php echo $category; ?></h5>
    <ul>
    <?php foreach($faqs as $key => $faq){
        if(SLUG_ACTIVE==0){
            $uri = get_base_url() . url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;
        }else{
            $uri = get_base_url() . $faq->slug;
        }  
    ?>
    <li>
        <a href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>"><?php echo $faq->title; ?></a>
    </li>
    <?php } ?>
    </ul>
</div>
<?php } ?>