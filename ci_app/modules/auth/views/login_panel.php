<div style="float:right;">
<?php if (modules::run('auth/auth/is_logged_in')): ?>
<ul class="nav">
    <li><a href="/dashboard"><?php echo $this->phpsession->get('username');?></a></li>
    <li><a href="/logout"><?php echo __('IP_log_out');?></a></li>
</ul>
<?php else: ?>
<ul class="nav">
    <li><a href="/login"><?php echo __('IP_log_in');?></a></li>
</ul>
<?php endif; ?>
</div>