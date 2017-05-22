<?php $data = modules::run('news/get_latest_news', array('cat_id' => 2)); ?>
<div class="homebox padding_side">
    <div class="row">
        <div class="col-sm-8">
            <div class="homenews">
            	<h3><?php echo $data[0]->category; ?></h3>
            	<div class="clearfix"></div>
			    <div class="homenews-image">
			    	<?php
			    		if(SLUG_ACTIVE==0){
		                    $uri1 = get_base_url() . url_title(trim($data[0]->title), 'dash', TRUE) . '-ns' . $data[0]->id;
		                }else{
		                    $uri1 = get_base_url() . $data[0]->slug;
                		}
			    		$image1 = isset($data[0]->thumbnail)?$data[0]->thumbnail:base_url().'images/no-image.png';
			    	?>
			        <a title="<?php echo $data[0]->title; ?>" href="<?php echo $uri1; ?>">
			            <img alt="" title="<?php echo $data[0]->title; ?>" src="<?php echo $image1; ?>" />
			        </a>
			    </div>
			    <div class="homenews-text">
			        <p><a title="<?php echo $data[0]->title; ?>" href="<?php echo $uri1; ?>"><?php echo limit_text($data[0]->title, 100); ?></a></p>
			        <p><?php echo limit_text($data[0]->summary, 300);; ?></p>
			        <span><a href="<?php echo $uri1; ?>">Xem tiếp</a></span>
			        <div class="clearfix"></div>
			    </div>
			</div>
        </div>
        <div class="col-sm-4">
        	<ul class="homenews-side">
        	<?php foreach($data as $key => $value){
                if(SLUG_ACTIVE==0){
                    $uri = get_base_url() . url_title(trim($value->title), 'dash', TRUE) . '-ns' . $value->id;
                }else{
                    $uri = get_base_url() . $value->slug;
                }
                $image = isset($value->thumbnail)?$value->thumbnail:base_url().'images/no-image.png';
                $value_title = limit_text($value->title, 100);
                $value_summary = limit_text($value->summary, 300);
                $value_category = limit_text($value->category, 100);
                $created_date   = get_date_by_lang(get_language(), $value->created_date);
                $author = $value->creator_fullname;
            ?>
            	<?php if($key>0){ ?>
				<li>
					<a title="<?php echo $value->title; ?>" href="<?php echo $uri1; ?>">
						<img src="<?php echo $image ?>" alt="<?php $value->title ?>" />
						<strong><?php echo $value_title; ?></strong>
					</a>
				</li>
				<?php } ?>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>