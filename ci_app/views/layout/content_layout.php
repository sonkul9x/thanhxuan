

<?php  echo $this->load->view('common/header'); ?>
    <div id="page_wrap">
        <?php  echo $this->load->view('common/sk-top'); ?>
        <div id="container">
             <?php  echo $this->load->view('common/sk-top_nav'); ?>
            <div class="content-wrap">         
                <?php  echo $this->load->view('common/sk-intro'); ?>
                 <div class="container-2">
                    <div style="clear:both; display:block; height:40px"></div>
                    <?php if (isset($main_content)) {echo $main_content;} ?>
                    
                    <?php // echo $this->load->view('common/ct-relatedprod'); ?>
                </div><!--end:container-2-->
                <?php   echo $this->load->view('common/sk-footer-top'); ?>
            </div><!--end:content-wrap-->
<?php echo $this->load->view('common/footer'); ?>