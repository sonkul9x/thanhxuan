<?php if(!empty($advs_main)){ ?>
<?php if(!empty($advs_background) && ($advs_background->image_name <> NULL || $advs_background->image_name <> '')){
    $background_image_url = base_url() . ADVS_IMAGE_URL . $advs_background->image_name;
}else{
    $background_image_url = base_url() . 'images/background-paralax.jpg';
}
?>
<div class="responsive-slider-parallax" data-spy="responsive-slider" data-autoplay="true" data-interval="4000" data-transitiontime="1000" data-parallax="true" data-parallax-direction="1">
    <div class="slides-container" data-group="slides" <?php if(!empty($background_image_url)){ ?>style="background-image: url('<?php echo $background_image_url; ?>');"<?php } ?>>
      <ul>
        <?php foreach($advs_main as $key => $value){ 
              $url_path = ($value->url_path === "" || $value->url_path === "#") ? "" : $value->url_path;
              $title = ($value->title == NULL || $value->title == '') ? '' : $value->title;
              $summary = ($value->summary == NULL || $value->summary == '') ? '' : $value->summary;
              $image = $value->image_name;
              $image_url = base_url() . ADVS_IMAGE_URL . $image;
          ?>
        <li>
          <div class="slide-body" data-group="slide">
            <div class="container">
              <div class="wrapper">
                <div class="caption header" data-animate="slideAppearRightToLeft" data-delay="500" data-length="700">
                  <h2>
                      <a <?php if($url_path){ ?> href="<?php echo $url_path; ?>" <?php } ?> data-thumb="<?php echo $image_url; ?>" title="<?php echo $title;?>">
                      <?php echo $title; ?>
                      </a>
                  </h2>
                  <div class="caption sub" data-animate="slideAppearLeftToRight" data-delay="800" data-length="700">
                      <?php echo $summary; ?>
                  </div>
                </div>
                <div class="caption img-html5" data-animate="slideAppearUpToDown" data-delay="700">
                  <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>">
                </div>
              </div>
            </div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <?php if(count($advs_main)>1){ ?>
    <a class="slider-control left" href="#" data-jump="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="slider-control right" href="#" data-jump="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    <div class="pages">
        <?php foreach($advs_main as $key => $value){ ?>
        <a class="page" href="#" data-jump-to="<?php echo $key+1; ?>"></a>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<?php } ?>
