<?php if(!empty($product)) {
    if(SLUG_ACTIVE==0){
        $uri = get_base_url() . url_title(trim($product->product_name), 'dash', TRUE) . '-ps' . $product->id;
        $uri2 = get_base_url() . url_title(trim($category), 'dash', TRUE) . '-p' . $product->categories_id;
    }else{
        $uri = get_base_url() . $product->slug;
        $uri2 = get_base_url() . $category_slug;
    }
    $image = is_null($product->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/'.$product->image_name;   
    $image_thumb = is_null($product->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/thumbnails/'.$product->image_name;
    $price = $product->price != 0 ? get_price_in_vnd($product->price) . ' ₫' : get_price_in_vnd($product->price);
    $price_old = $product->price_old != 0 ? get_price_in_vnd($product->price_old) . ' ₫' : 0;
    $summary = limit_text($product->summary, 1000);
    $specifications = $product->specifications;
    $description = $product->description;
    $code = $product->code;
    echo form_hidden('id', $product->id);
    echo form_hidden('addUri', get_uri_by_lang(get_language(),'cart'));
    echo form_hidden('lang', get_language());
?>

<div class="prod">
    <div class="clearfix"> 
    <a href="<?php echo $image; ?>" class="jqzoom" rel='gal1'  title="triumph" > <img src="<?php echo $image_thumb; ?>" style="border: 4px solid #e5e5e5;"> </a>
    </div>
    <div class="clearfix" >
        <ul id="thumblist" class="clearfix" >
        <?php for ($i=0; $i < count($products_images); $i++) {  
       
          $bigimg = is_null($products_images[$i]->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/'.$products_images[$i]->image_name; 
          $image_thumb = is_null($products_images[$i]->image_name) ? base_url().'images/no-image.png' : base_url().'images/products/thumbnails/'.$products_images[$i]->image_name; 

          ?>
          <?php if($i==0){
           ?>
            <li>
              <a class="zoomThumbActive" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo $image_thumb; ?>',largeimage: '<?php echo $bigimg; ?>'}"><img title="<?php echo $products_images[$i]->image_name; ?>" src='<?php echo $image_thumb; ?>'></a>
          </li>
          <?php  }elseif($i > 0){ ?>
               <li><a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo $image_thumb; ?>',largeimage: '<?php echo $bigimg; ?>'}"><img src='<?php echo $image_thumb; ?>'></a></li>
          <?php } ?>
         <?php } ?>
         
        </ul>
    </div>
  </div><!--end:prod-->
  <div class="prod-detail">
 
    <h2><?php echo $product->product_name; ?></h2>  
       <?php if(!empty($price_old) && $price_old <> 0){ ?>
                    <span class="sale"><?php echo $price_old; ?></span>&nbsp;&nbsp;<span  class="price"><?php echo $price; ?></span>
                <?php }else{ ?>
            <span class="price"><?php echo $price; ?></span>
                         <?php    } ?>
   
        Chọn kích cỡ :&nbsp;
        <select id="product_size" name="product_size">
            <?php if(!empty($product->size)){ ?>
            <div>
            <?php 
                $size_arr = @explode(",", $product->size);
                $size = modules::run('products/get_size',$size_arr);
                foreach($size as $k => $v){            ?>               
                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
            <?php } ?>

            </div>
            <?php } ?>  

         </select>
        
            <?php // if(!empty($product->colors)){ ?>
<!--            <div><label><?php // echo __('IP_color'); ?>: </label>
            <?php 
//                $colors_arr = @explode(",", $product->colors);
//                $colors = modules::run('products/get_colors',$colors_arr);
//                foreach($colors as $k => $v){
            ?>
                <span style="width:15px;height:15px;border:1px solid #000;background:#<?php // echo $k; ?>;cursor:pointer;margin-right:5px;display:inline-block;vertical-align:middle;" title="<?php // echo $v; ?>"></span>
            <?php // } ?>
            </div>    -->
            <?php // } ?>







         &nbsp;&nbsp;
         Số lượng:&nbsp;
         <input value="1" name="qty" type="text">                             

      <?php if($product->price > 0){ ?>
      <button type="button" class="addtocart" id="addtocart"><i class="fa fa-shopping-cart"></i>&nbsp;<?php echo __('IP_products_add_cart'); ?></button>
      <?php }else{ ?>
            <form method="post" action="<?php echo base_url().CONTACT_HOME_URL; ?>">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>" />
                <input type="submit" class="contact_order_submit" value="<?php echo __('IP_products_contact'); ?>" />
            </form>
            <?php } ?>
        <?php $config = get_cache('configurations_' .  get_language());
                if(!empty($config)){
            ?>
            <div class="order_tel">
                Hoặc gọi hotline <a href="tel:<?php echo $config['telephone'] ?>"><span><?php echo $config['telephone'] ?></span></a> <br />để mua hàng nhanh nhất
            </div>
            <?php } ?>
       <div id="tab">
        <ul class="nav">
            <li class="nav-one"><a href="#details" class="current"><?php echo __('IP_summary'); ?></a></li>
          
            <li class="nav-three"><a href="#reviews"><?php echo __('IP_products_infomation'); ?></a></li>
            <li class="nav-four last"><a href="#tags">Tags</a></li>
        </ul>
        <div class="list-wrap">
            <div id="details">
                <?php echo $summary; ?>
            </div>
            
            <div id="reviews" class="hide">
                <?php echo $description; ?>
            </div>

            <ul id="tags" class="hide">
               <?php if(!empty($tags)) { ?>
                <?php foreach($tags as $key => $tag){
            $taglink = get_url_by_lang(get_language(),'products_tags').'/'.url_title(trim($tag), 'dash', TRUE);
        ?>
                <li><a href="<?php echo $taglink; ?>" title="<?php echo $tag; ?>"><?php echo $tag; ?></a></li>
                 <?php } ?>
                  <?php } ?>              
            </ul>
        </div>
    </div>
  </div><!--prodetail-->
  <script type="text/javascript">
$(document).ready(function() {
  $('.jqzoom').jqzoom({
            zoomType: 'innerzoom',
            preloadImages: false,
            zoomWidth: 300,
            alwaysOn:false
        });
});
</script>
<script type="text/javascript">
$(function() {        
  $("#tab").organicTabs({
      "speed": 200
  });    
});
</script>
  <?php }else {echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>';} ?>
