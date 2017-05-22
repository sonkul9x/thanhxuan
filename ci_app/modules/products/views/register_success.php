<div class="box">
    <h1 class="title">Đặt hàng thành công</h1>
    <div class="clearfix"></div>
    <div class="alert alert-success">
        <?php
        $config = get_cache('configurations_' . get_language());
        if (!empty($config['success_order'])) {
            echo $config['success_order'];
        }
        ?>
    </div>
</div>