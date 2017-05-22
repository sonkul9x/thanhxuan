<?php if(!empty($galleries)) { ?>
<div class="grid_same">
    <h3><i class="fa fa-arrow-circle-right"></i><?php echo $category; ?></h3>
    <div class="grid">
        <div class="row">
            <?php foreach($galleries as $key => $gallery){
                $image_url = is_null($gallery->image_name) ? base_url().'images/no-image.png' : base_url().'images/gallery/thumbnails/'.$gallery->image_name;
                $short_gallery_name = limit_text($gallery->gallery_name, 45);
                if(SLUG_ACTIVE==0){
                    $uri = get_base_url() . url_title(trim($gallery->gallery_name), 'dash', TRUE) . '-gs' . $gallery->id;    
                }else{
                    $uri = get_base_url() . $gallery->slug;
                }
            ?>
            <div class="col-sm-3 grid_item">
                <div class="thumbnail">
                    <a class="grid_image" href="<?php echo $uri; ?>" title="<?php echo $gallery->gallery_name; ?>">
                        <img title="<?php echo $gallery->gallery_name; ?>" alt="<?php echo $gallery->gallery_name; ?>" src="<?php echo $image_url; ?>" >
                    </a>
                    <div class="caption">
                        <p class="grid_title"><a href="<?php echo $uri; ?>" title="<?php echo $gallery->gallery_name; ?>"><?php echo $short_gallery_name; ?></a></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
