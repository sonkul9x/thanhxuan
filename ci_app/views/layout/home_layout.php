<?php  echo $this->load->view('common/header'); ?>
    <div id="page_wrap">
        <?php  echo $this->load->view('common/sk-top'); ?>
        <div id="container">
             <?php  echo $this->load->view('common/sk-top_nav'); ?>
            <div class="content-wrap">
                <?php  echo $this->load->view('common/sk-top_slide'); ?>
                <?php  echo $this->load->view('common/sk-intro'); ?>
                <div class="container-2">
                    <section class="content">
                        <?php   echo $this->load->view('common/sk-product-featured'); ?>
                        <?php   echo $this->load->view('common/sk-product-news'); ?>
                         <?php echo $this->load->view('common/sk-ads'); ?>
                        <?php   echo $this->load->view('common/sk-product-sale'); ?>
                    </section>
                    <aside class="sidebar">

                        <?php //  echo $this->load->view('common/side-filter'); ?>
                        <?php   echo $this->load->view('common/side-products'); ?>
                        <?php   echo $this->load->view('common/side-news'); ?>
                        <?php   echo $this->load->view('common/side-customer'); ?>
                    </aside> 
                </div><!--end:container-2-->
                <?php   echo $this->load->view('common/sk-footer-top'); ?>
            </div><!--end:content-wrap-->
<?php echo $this->load->view('common/footer'); ?>

<?php /* echo $this->load->view('common/header'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="main">
                <?php echo $this->load->view('common/top'); ?>
                <?php echo $this->load->view('common/top_nav'); ?>
                <?php echo $this->load->view('common/home1'); ?>
                <?php echo $this->load->view('common/home2'); ?>
                <?php echo $this->load->view('common/home3'); ?>
                <?php echo $this->load->view('common/home_ads'); ?>
                <?php echo $this->load->view('common/home4'); ?>
                <?php echo $this->load->view('common/home5'); ?>
                <?php echo $this->load->view('common/home6'); ?>
                <?php echo $this->load->view('common/home7'); ?>
                <?php echo $this->load->view('common/footer'); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
*/ ?>