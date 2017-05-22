<?php

$config = get_cache('configurations_' . get_language());
if (!empty($config['pay_people'])) {
    echo $config['pay_people'];
}
?>