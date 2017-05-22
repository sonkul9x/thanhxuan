<?php 

    $this->load->library('Mobile_Detect');

    $detect = new Mobile_Detect();

    if($detect->isMobile() && !$detect->isTablet()){

        $isMobile = TRUE;

    } else {

        $isMobile = FALSE;

    }

?>

</nav>


<nav>  
                 <?php 

                        if(isset($active_menu)){$active_menu=$active_menu;}else{$active_menu=NULL;} 

                        if(isset($current_menu)){$current_menu=$current_menu;}else{$current_menu=NULL;}

                    ?>

                    <?php echo modules::run('menus/menus/get_main_menus',array('current_menu'=>$current_menu,'active_menu'=>$active_menu,'menu_type'=>FRONT_END_MENU_TOP_CAT_ID)); ?>
            </nav><!--end:grey-->