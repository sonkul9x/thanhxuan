<?php $config = get_cache('configurations_' .  get_language()); ?>
<?php if(!empty($config['facebook_id'])){ ?>
<div class="sidebox">
    <div class="row">
        <div class="col-sm-12 side_item">
            <iframe frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; height:200px; width:100%; background:#fff;" scrolling="no" src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/<?php echo $config['facebook_id']; ?>&amp;width=700&amp;height=280&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false"></iframe>
        </div>
    </div>
</div>
<?php } ?>