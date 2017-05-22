<?php $data = modules::run('advs/get_advs_slide_show',array('type'=>3));
if(!empty($data)){ ?>
<div class="partner">
    <div class="partner_inner">
        <?php foreach($data as $key => $value){
           $url_path = ($value->url_path == "" || $value->url_path == "#") ? "" : $value->url_path;
           $title = ($value->title == NULL || $value->title == '') ? '' : $value->title;
           $image = $value->image_name;
           $image_url = base_url() . ADVS_IMAGE_URL . $image;
       ?>
       <div class="partner_item">
           <a <?php if($url_path <> ''){ ?>href="<?php echo $url_path; ?>"<?php } ?> title="<?php echo $value->title; ?>" >
               <img title="<?php echo $value->title; ?>" alt="" src="<?php echo $image_url; ?>" >
           </a>
       </div>
       <?php } ?>
    </div>
</div>
<?php } ?>