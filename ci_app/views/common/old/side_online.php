<?php 
//onlineusers_helper loaded in autoload.php
$onl = get_online();
?>
<div class="sidebox sideonline">
    <h3><?php echo __('IP_onlineusers'); ?></h3>
    <ul>
        <li><?php echo __('IP_online_total'); ?>:&nbsp;<span><?php echo (!empty($onl['online_total']))?$onl['online_total']:125; ?></span></li>
        <li><?php echo __('IP_online_today'); ?>:&nbsp;<span><?php echo (!empty($onl['online_today']))?$onl['online_today']:1; ?></span></li>
        <li><?php echo __('IP_online_yesterday'); ?>:&nbsp;<span><?php echo (!empty($onl['online_yesterday']))?$onl['online_yesterday']:0; ?></span></li>
        <li><?php echo __('IP_online_now'); ?>:&nbsp;<span><?php echo (!empty($onl['online_now']))?$onl['online_now']:1; ?></span></li>
    </ul>
</div>