<div class="central-content">
    <div class="cm-notification-container"></div>
    <div class="mainbox-container">
        <h1 class="mainbox-title"><span>Đơn hàng</span></h1>
        <div class="mainbox-body">
          
            <form id="cat_form" method="post" accept-charset="utf-8" action="#">
                <input type="hidden" name="order_detail_id" value="0" />
                <div class="pagination-container" id="pagination_contents">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table">
                        <tbody><tr>
                                <th width="10%"><a class=""  rev="pagination_contents">ID</a></th>
                                <th width="10%"><a class="" rev="pagination_contents">Trạng thái</a></th>
                                <th width="45%">Đơn hàng bao gồm</th>
                                <th width="10%"><a class="" rev="pagination_contents">Ngày</a>&nbsp;&nbsp;↓</th>
                                <th width="15%" class="right"><a class="" rev="pagination_contents">Trị giá đơn hàng</a></th>
                                <th width="10%" class="right"><a class="" rev="pagination_contents">Chức năng</a></th>
                            </tr>
                            <?php
                            foreach ($orders as $order):
                                ?>
                                <tr>
                                    <td class="center"><a href="javascript:details_order('<?php echo $order->id; ?>')"><strong><?php echo $order->id; ?></strong></a></td>
                                    <td style="text-align: center;vertical-align: middle;">
                                        <?php $status = get_status_orders_icon($order->order_status);
                                        echo $status; ?>
                                    </td>
                                    <td>
                                        <ul class="no-markers">
                                            <?php
                                            $order_detals = $order->order_details;
                                          
                                            foreach ($order_detals as $detail):
                                                ?>
                                                <li><?php echo $detail->product_name; ?></li>
    <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td><a href="#">
                                            <?php
                                            $sale_date = $order->sale_date;
                                            $sale_date = date('d/m/Y <br/> H:i:s', strtotime($sale_date));
                                            echo $sale_date;
                                            ?>
                                        </a>
                                    </td>
                                    <td class="right" style="text-align: right; color: rgb(196, 0, 0)"><?php echo get_price_in_vnd($order->total); ?></td>
                                    <td style="text-align:center; vertical-align: middle;"><a href="javascript:details_order('<?php echo $order->id; ?>')"><img src="/images/view_detail.png" width="20px" title="Xem chi tiết đơn hàng" /></a></td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                            <tr class="table-footer">
                                <td colspan="6">
                                    <div class="pull-right">
                                        <ul>
                                            <div class="pagination">
<?php if (isset($pagination)) echo $pagination; ?>
                                            </div>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>

                </div>
            </form>

        </div>
    </div>  
</div>