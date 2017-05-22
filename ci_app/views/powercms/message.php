<?php if (isset($options['error']) && $options['error'] !== ''): ?>
<div class="message error">
    <?php echo $options['error']; ?>
</div>
<?php endif; ?>
<?php if (isset($options['succeed']) && $options['succeed'] !== ''): ?>
<div class="message succeed">
    <?php echo $options['succeed']; ?>
</div>
<?php endif; ?>
<?php if (isset($options['warning']) && $options['warning'] !== ''): ?>
<div class="message warning">
    <?php echo $options['warning']; ?>
</div>
<?php endif; ?>