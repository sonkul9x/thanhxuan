<?php $data = modules::run('supports/get_supports',array('data'=>TRUE)); ?>
<?php if(!empty($data)) : ?>
<div class="sidebox sidesupports">
    <h3><?php echo __('IP_support_online'); ?></h3>
    <div class="row">
        <div class="col-sm-12 side_item">
        <?php
            foreach ($data as $key => $value) :
                if ($value->type == YAHOO) :
                    ?>
                    <p class="supports_yahoo">
                        <?php if($value->title <> ''){ ?>
                        <strong><?php echo $value->title; ?></strong>
                        <?php } ?>
                        <a href="ymsgr:sendIM?<?php echo $value->content; ?>">
                            <img border=0 src="http://opi.yahoo.com/online?u=<?php echo $value->content; ?>&m=g&t=2" />
                        </a>
                    </p>
                    <?php
                endif;
                if ($value->type == SKYPE) :
                    ?>
                    <p class="supports_skype">
                        <?php if($value->title <> ''){ ?>
                        <strong><?php echo $value->title; ?></strong>
                        <?php } ?>
                        <a href="Skype:<?php echo $value->content; ?>?chat">
                            <img alt="Chat" style="border: none;" src="<?php echo base_url().'/images/skype_online_small.png'; ?>" title="<?php echo $value->content; ?>">
                            <!--<img alt="Chat" style="border: none;" src="http://mystatus.skype.com/bigclassic/<?php // echo $value->content; ?>" title="<?php // echo $value->content; ?>">-->
                        </a>
                    </p>
                    <?php
                endif;
                if ($value->type == TELEPHONE) :
                    ?>
                    <p class="supports_tel">
                        <?php if($value->title <> ''){ ?>
                        <?php echo $value->title; ?>: <a href="tel:<?php echo $value->content; ?>"><span><?php echo $value->content; ?></span></a>
                        <?php } ?>
                        
                    </p>
                    <?php
                endif;
            endforeach;
        ?>
        </div>
    </div>
</div>
<?php endif; ?>
