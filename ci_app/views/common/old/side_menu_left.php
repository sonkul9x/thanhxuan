<?php 
    if(isset($active_menu)){$active_menu=$active_menu;}else{$active_menu=NULL;} 
    if(isset($current_menu)){$current_menu=$current_menu;}else{$current_menu=NULL;}
  ?>
<?php $data = modules::run('products/get_products_categories',array('current_menu'=>$current_menu,'active_menu'=>$active_menu,'menu_type'=>FRONT_END_SIDE_LEFT_CAT_ID)); ?>    
<?php if(!empty($data) && $data <> '<ul></ul>'){ ?>
<div class="sidebox sidemenuleft">
    <h3>Danh mục</h3>
    <?php echo $data; ?>
</div>
<?php } ?>
