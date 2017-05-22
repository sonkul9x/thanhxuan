<?php

$config = get_cache('configurations_' . get_language());
if (!empty($config['pay_info'])) {
    echo $config['pay_info'];
}
?>