<?php

$config = get_cache('configurations_' . get_language());
if (!empty($config['pay_bank'])) {
    echo $config['pay_bank'];
}
?>