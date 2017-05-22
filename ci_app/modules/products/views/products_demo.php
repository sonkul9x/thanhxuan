<?php if(!empty($product)){ ?>
<div class="demo_panel">
    <h1 class="pull-left"><?php echo $product->product_name; ?></h1>
    <a class="pull-right" href="javascript:window.history.back();"><i class="fa fa-arrow-left"></i>Quay lại trang trước</a>
</div>
<?php if(!empty($product->link_demo) && $product->link_demo =='#'){ ?>
<div class="demo_image"><?php echo $product->description; ?></div>
<?php }else{ ?>
<iframe class="demo_iframe" src="<?php echo $product->link_demo; ?>"></iframe>
<?php } ?>
<?php } ?>