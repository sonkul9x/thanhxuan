<?php 
    if(isset($active_menu)){$active_menu=$active_menu;}else{$active_menu=NULL;} 
    if(isset($current_menu)){$current_menu=$current_menu;}else{$current_menu=NULL;}
  ?>
<?php $data = modules::run('menus/menus/get_main_menus',array('current_menu'=>$current_menu,'active_menu'=>$active_menu,'menu_type'=>FRONT_END_SIDE_RIGHT_CAT_ID)); ?>    
<?php if(!empty($data) && $data <> '<ul></ul>'){ ?>
<div class="sidebox sidemenuright">
    <h3><i class="fa fa-arrow-circle-right"></i><?php echo __('IP_menu_services'); ?></h3>
    <?php echo $data; ?>
</div>
<?php } ?>
