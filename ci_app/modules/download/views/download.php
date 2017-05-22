<?php if(!empty($downloads)) { ?>
<div class="box">
    <?php if($type == 0){ ?>
    <h3><?php echo __('IP_download_title'); ?></h3>
    <?php }else{ ?>
    <h3><?php echo __('IP_download_title') . ' - ' . $category; ?></h3>
    <?php } ?>
    
    <div class="divider"></div>
    
    <ol class="breadcrumb">
        <li><a href="<?php echo get_base_url(); ?>" title="<?php echo __('IP_default_company'); ?>"><?php echo __('IP_home_page'); ?></a></li>
        <?php // if($type <> 0){ ?>
            <!--<li><?php // echo __('IP_download_title'); ?></li>-->
        <?php // } ?>
        <li class="active"><?php echo $category; ?></li>
    </ol>
    
    <div class="download_combo">
        <strong><?php echo __('IP_type'); ?>: </strong><?php echo isset($categories_combobox)?$categories_combobox:''; ?>
    </div>
    
    <div class="download_box">
        <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th><?php echo __('IP_download_label'); ?></th>
                    <th><?php echo __('IP_download_size'); ?></th>
                    <th><?php echo __('IP_download_type'); ?></th>
                    <th><?php echo __('IP_download_time'); ?></th>
                    <th><?php echo __('IP_download_title'); ?></th>
                </tr>
            </thead>
            <tbody>
        <?php 
        foreach($downloads as $key => $download)
        {
            //download direct link
            $downloadlink1 = DOWNLOAD_FILE_URL.$download->id;
            //download direct link for google api
            $downloadlink2 = base_url().DOWNLOAD_FILE_URI.$download->id;      
            //download direct link with file name
            $downloadurl = base_url().UPLOAD_URL_FILES.$download->name;
            //download in google docs api
            $downloadlinkapi = 'http://docs.google.com/viewer?url='.$downloadurl;
        ?>
            <tr>
                <td style="word-wrap:break-word;"><?php echo $download->title; ?></td>
                <td style="text-align: center;"><?php echo $download->size; ?></td>
                <td style="text-align: center;"><?php echo $download->ext; ?></td>
                <td style="text-align: center;"><?php echo get_vndate_string($download->date); ?></td>
                <td style="text-align: center;"><a href="<?php echo $downloadlink1; ?>" title="Download"><img src="<?php echo base_url().'images/box_download.png'; ?>" alt="Download" title="Download" /></a></td>
                <!--<td style="text-align: center;"><a target="_blank" href="<?php // echo $downloadlinkapi; ?>" title="Download"><img src="<?php // echo base_url().'images/box_download.png'; ?>" alt="Download" title="Download" /></a></td>-->
            </tr>
        <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
    
    <div class="divider"></div>
    
    <div class="paging">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php }else echo '<h4 class="alert alert-info">' . __('IP_comming_soon') . '</h4>'; ?>