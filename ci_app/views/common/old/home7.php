<div class="homebox padding_side">
    <div class="row">
        <div class="col-sm-3">
            <?php $advs = modules::run('advs/get_advs_slide_show',array('type'=>6, 'onehit'=>TRUE));
			?>
			<?php if(!empty($advs)) {
			    $url_path = ($advs->url_path == "" || $advs->url_path == "#") ? "" : $advs->url_path;
			    $title = ($advs->title == NULL || $advs->title == '') ? '' : $advs->title;
			    $image = $advs->image_name;
			    $image_url = base_url() . ADVS_IMAGE_URL . $image;
			?>
			<div class="boxhomeimage">
			    <a <?php if($url_path <> ''){ ?>href="<?php echo $url_path; ?>"<?php } ?> title="<?php echo $title; ?>" >
			        <img title="<?php echo $title; ?>" alt="" src="<?php echo $image_url; ?>" border="0" >
			    </a>
			</div>
			<?php } ?>
        </div>
        <div class="col-sm-9">
            <?php $data = modules::run('products/products_by_cond',array('cat_id'=>4));
			if(!empty($data)){ ?>
			<div class="homeproducts">
			    <div class="homeproducts_inner">
			        <?php foreach($data as $key => $value){
	                    if(SLUG_ACTIVE==0){
	                        $uri = get_base_url() . url_title(trim($value->product_name), 'dash', TRUE) . '-ps' . $value->id;
	                    }else{
	                        $uri = get_base_url() . $value->slug;
	                    }
	                    $image = is_null($value->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/thumbnails/'.$value->image_name;
	                    $value_name = limit_text($value->product_name, 100);
	                    $value_summary = limit_text($value->summary, 200);
	                    //$value_category = limit_text($value->category, 100);
	                    $price = $value->price > 0 ? get_price_in_vnd($value->price) . ' ₫' : get_price_in_vnd($value->price);
	                ?>
			       <div class="homeproducts_item">
			           <a href="<?php echo $uri; ?>" title="<?php echo $value->product_name; ?>" >
			               <img title="<?php echo $value->product_name; ?>" alt="" src="<?php echo $image; ?>" >
			           </a>
			           <a href="<?php echo $uri; ?>" title="<?php echo $value->product_name; ?>" ><strong><?php echo $value_name; ?></strong></a>
			           <p><?php echo $value_summary; ?></p>
			           <div class="homeproducts_button">
			           		<span><?php echo $price; ?></span>
			           		<a href="<?php echo $uri; ?>">Mua hàng</a>
			           		<div class="clearfix"></div>
			           </div>
			       </div>
			       <?php } ?>
			    </div>
			</div>
			<?php } ?>
        </div>
    </div>
</div>