<?php if (isset($options['error']) && $options['error'] !== ''): ?>

<div class="alert red_alert alert-dismissable">

  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

  <strong><?php echo $options['error']; ?></strong>

</div>

<?php elseif (isset($options['message']) && $options['message'] !== ''): ?>

<div class="alert blue_alert alert-dismissable">

  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

  <strong><?php echo $options['message']; ?></strong>

</div>

<?php elseif (isset($options['succeed']) && $options['succeed'] !== ''): ?>

<div class="alert green_alert alert-dismissable">

  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

  <strong><?php echo $options['succeed']; ?></strong>

</div>

<?php elseif (isset($options['warning']) && $options['warning'] !== ''): ?>

<div class="alert yellow_alert alert-dismissable">

  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

  <strong><?php echo $options['warning']; ?></strong>

</div>

<?php endif; ?>