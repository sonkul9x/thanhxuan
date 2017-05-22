<div class="page_header">
    <h1 class="fleft">Dashboard</h1>
    <small class="fleft">Bảng tin, thống kê</small>
    <!--<span class="fright"><a class="button close" href= "<?php // echo ADMIN_BASE_URL; ?>"><em>&nbsp;</em>Đóng</a></span>-->
    <br class="clear"/>
</div>
<div class="db_box">
    <table>
        <tr>
            <td style="width: 25%;">
                <div class="db_box_item">
                    <h5><i class="fa fa-bar-chart-o fa-2x"></i>Đơn hàng</h5>
                    <div class="db_box_content">
                        Tổng số đơn hàng: <b><?php echo $order_count; ?></b><br />
                        Đơn hàng chờ xử lý: <b><?php echo $order_count_0; ?></b><br />
                        Đơng hàng chưa giao: <b><?php echo $order_count_1; ?></b><br />
                        Đơn hàng bị hủy: <b><?php echo $order_count_2; ?></b><br />
                        Đơn hàng hoàn tất: <b><?php echo $order_count_3; ?></b><br />
                        Đơn hàng thanh toán nhưng chưa giao: <b><?php echo $order_count_4; ?></b><br />
                    </div>
                </div>
            </td>
            <td style="width: 25%;">
                <div class="db_box_item">
                    <h5><i class="fa fa-gift fa-2x"></i>Sản phẩm</h5>
                    <div class="db_box_content">
                        Số sản phẩm chưa hiển thị: <b><?php echo $products_count_inactive; ?></b><br />
                        Số sản phẩm hiển thị: <b><?php echo $products_count_active; ?></b><br />
                        Tổng số sản phẩm: <b><?php echo $products_count_total; ?></b><br />
                    </div>
                </div>
            </td>
            <td style="width: 25%;">
                <div class="db_box_item">
                    <h5><i class="fa fa-file-text fa-2x"></i>Bài viết</h5>
                    <div class="db_box_content">
                        Số bài viết chưa hiển thị: <b><?php echo $news_count_inactive; ?></b><br />
                        Số bài viết hiển thị: <b><?php echo $news_count_active; ?></b><br />
                        Tổng số bài viết: <b><?php echo $news_count_total; ?></b><br />
                    </div>
                </div>
            </td>
            <td style="width: 25%;">
                <div class="db_box_item">
                    <h5><i class="fa fa-phone fa-2x"></i>Liên hệ</h5>
                    <div class="db_box_content">
                        Số liên hệ hôm nay: <b class="db_box_label_red"><?php echo $contact_count_today; ?></b><br />
                        Số liên hệ hôm qua: <b><?php echo $contact_count_yesterday; ?></b><br />
                        Tổng số liên hệ: <b><?php echo $contact_count_total; ?></b><br />
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 50%;">
                <div class="db_box_list">
                    <h5><i class="fa fa-file-text fa-2x"></i>Bài viết xem nhiều nhất</h5>
                    <div class="db_box_content">
                        <?php if(!empty($news_list_view)){ ?>
                        <ul>
                            <?php foreach($news_list_view as $key => $new){ 
                                if(SLUG_ACTIVE==0){
                                    $row_uri = '/' . url_title(trim($new->title), 'dash', TRUE) . '-ns' . $new->id;
                                }else{
                                    $row_uri = '/' . $new->slug;
                                }
                                $this_lang = ($new->lang<>DEFAULT_LANGUAGE)?'/'.$new->lang:'';
                                ?>
                            <li><a target="_blank" href="<?php echo $this_lang . $row_uri; ?>"><?php echo $new->title; ?></a>&nbsp;(<?php echo $new->viewed; ?>)</li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="db_box_list">
                    <h5><i class="fa fa-gift fa-2x"></i>Sản phẩm xem nhiều nhất</h5>
                    <div class="db_box_content">
                        <?php if(!empty($products_list_view)){ ?>
                        <ul>
                            <?php foreach($products_list_view as $key => $product){
                                if(SLUG_ACTIVE==0){
                                    $uri = '/' . url_title(trim($product->product_name), 'dash', TRUE) . '-ps' . $product->id;
                                }else{
                                    $uri = '/' . $product->slug;
                                }
                                $this_lang = ($product->lang<>DEFAULT_LANGUAGE)?'/'.$product->lang:'';
                                ?>
                            <li><a target="_blank" href="<?php echo $this_lang . $uri; ?>"><?php echo $product->product_name;?></a>&nbsp;(<?php echo $product->viewed; ?>)</li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <?php 
//    
//$a = date('Y m d', 1421600400 + 86400);
//                        echo '<pre>';
//                        print_r($a);
//                        echo '</pre>';
//                     
    ?>
    <script type="text/javascript" src="/plugins/jquery/jquery-2.1.0.min.js"></script>
    <script type="text/javascript">
$(function () {

  
        // Create the chart
        $('#container_chart').highcharts('StockChart', {


            rangeSelector : {
                selected : 1,
                inputEnabled: $('#container_chart').width() > 480
            },

            title : {
                text : 'Biểu đồ doanh số'
            },

            series : [{
                name : 'Doanh số',
                data : <?php echo $chart; ?>,
                tooltip: {
                    valueDecimals: 2
                }
            }]
        });
    

});

</script>

<div id="container_chart" style="height: 400px; min-width: 310px"></div>
</div>
