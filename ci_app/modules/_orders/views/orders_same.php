<?php if(!empty($faqs)) { ?>
<div class="same_news">
    <h5 class="label label-default"><?php echo $category; ?></h5>
    <ul>
    <?php foreach($faqs as $key => $faq){
    $uri = get_base_url() . url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;
    ?>
    <li>
        <a href="<?php echo $uri; ?>" title="<?php echo $faq->title; ?>"><?php echo $faq->title; ?></a>
    </li>
    <?php } ?>
    </ul>
</div>
<?php } ?>