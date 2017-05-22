<?php $page1 = modules::run('pages/get_page','/block-thanh-toan-tai-nha.html');
    $page2 = modules::run('pages/get_page','/block-bao-hang-tron-doi.html');
    $page3 = modules::run('pages/get_page','/block-giao-hang-mien-phi-toan-quoc.html');
    $page4 = modules::run('pages/get_page','/block-doi-tra-hang-trong-365-ngay.html');
    if(!empty($page1)){$page1_content = $page1['content'];}
    if(!empty($page2)){$page2_content = $page2['content'];}
    if(!empty($page3)){$page3_content = $page3['content'];}
    if(!empty($page4)){$page4_content = $page4['content'];}
?>
<div class="panel-group quick_support" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="fa fa-map-marker"></i>Thanh toán tại nhà<i class="fa fa-angle-down"></i>
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <?php echo $page1_content; ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="fa fa-shield"></i>Bảo hành trọn đời<i class="fa fa-angle-down"></i>
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <?php echo $page2_content; ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="fa fa-truck"></i>Giao hàng miễn phí toàn quốc<i class="fa fa-angle-down"></i>
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <?php echo $page3_content; ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingFour">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <i class="fa fa-refresh"></i>Đổi trả hàng trong 365 ngày<i class="fa fa-angle-down"></i>
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
            <div class="panel-body">
                <?php echo $page4_content; ?>
            </div>
        </div>
    </div>
</div>