<?php 
$data = Modules::run('menus/get_menu_data',array('cat_id'=>FRONT_END_MENU_TOP_CAT_ID,'url_path'=>'/'.$this->uri->segment(1)));
if(!empty($data)){
    $thumbnail = !empty($data->thumbnail)?$data->thumbnail:'';
?>
<?php if($thumbnail<>''){ ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <a class="top_banner" href="<?php echo $data->url_path; ?>" title="<?php echo $data->caption; ?>" >
                <img title="<?php echo $data->caption; ?>" alt="<?php echo $data->caption; ?>" src="<?php echo $thumbnail; ?>" border="0" />
            </a>
        </div>
    </div>
</div>
<?php } ?>
<?php } ?>