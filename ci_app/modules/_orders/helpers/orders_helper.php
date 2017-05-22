<?php
function get_status_orders($status = 0)
{
    $output = '';
    switch ($status)
    {
        case PRODUCTS_ILLUSIVE_ORDER : $output = 'Đơn hàng ảo'; break;
        case PRODUCTS_NEW_ORDER      : $output = 'Đơn hàng mới'; break;
        case PRODUCTS_PAID_ORDER     : $output = 'Đã thanh toán'; break;
    }
    return $output;
}

function get_status_payment($status = 0)
{
    $output = '';
    switch ($status)
    {
        case PRODUCTS_ILLUSIVE_ORDER :
        case PRODUCTS_NEW_ORDER      :
            $output = 'Chưa thanh toán'; break;
        case PRODUCTS_PAID_ORDER     : $output = 'Đã thanh toán'; break;
    }
    return $output;
}


// Hàm đọc số có 3 chữ số
function DocSo3ChuSo($param = 0)
{
    $chuso = array(' không ',' một ',' hai ',' ba ',' bốn ',' năm ',' sáu ',' bảy ',' tám ',' chín ');
//    $tien  = array('', ' nghìn', ' triệu', ' tỷ', ' nghìn tỷ', ' triệu tỷ');
    $tram = 0;
    $chuc = 0;
    $donvi = 0;
    $kq = '';
    $tram = floor($param / 100);
    $chuc = floor(($param%100)/10);
    $donvi = $param%10;

    if($tram == 0 && $chuc == 0 && $donvi == 0)
        return '';
    if($tram != 0)
    {
        $kq .= $chuso[$tram] . 'trăm ';
        if($chuc == 0 && $donvi != 0)
            $kq .= ' linh ';
    }
    if($chuc != 0 && $chuc != 1)
    {
        $kq .= $chuso[$chuc] . ' mươi ';
        if($chuc == 0 && $donvi != 0)
            $kq .= ' linh ';
    }
    if($chuc == 1)
        $kq .= 'mười';
    switch ($donvi) {
        case 1:
            if($chuc != 0 && $chuc != 1)
                $kq .= ' mốt ';
            else
                $kq .= $chuso[$donvi];
            break;
        case 5:
            if($chuc == 0)
                $kq .= $chuso[$donvi];
            else
                $kq .= ' lăm ';
            break;

        default:
            if($donvi != 0)
                $kq .= $chuso[$donvi];
            break;
    }
    return $kq;
}
function get_form_orders_icon($status = 0)
{
    $output = '';
    switch ($status)
    {
        case NEW_ORDER  : $output = 'Thanh toán trực tiếp'; break;
        case ILLUSIVE_ORDER : $output = 'Thanh toán chuyển khoản'; break;
     
    }
    return $output;
}

function get_status_orders_icon($status = 0)
{
    $output = '';
    switch ($status)
    {
        case NEW_ORDER_NEW  : $output = '<img src="/powercms/images/absent.png" title="Đơn hàng chờ xử lý" />'; break;
        case ILLUSIVE_ORDER : $output = '<img src="/powercms/images/Cancel-icon.png" title="Đơn hàng bị hủy"/>'; break;
        case NEW_ORDER      : $output = '<img src="/powercms/images/absent.png" title="Đơn hàng chưa giao" />'; break;
        case GCTT           : $output = '<img src="/powercms/images/ontime.png" title="Đơn hàng thanh toán nhưng chưa giao" />'; break;
        case PAID_ORDER     : $output = '<img src="/powercms/images/done.png" style="width: 19px;" title="Đơn hàng đã hoàn tất" />'; break;
    }
    return $output;
}
function DocTienBangChu($sotien = 0)
{
    $chuso = array(' không ',' một ',' hai ',' ba ',' bốn ',' năm ',' sáu ',' bảy ',' tám ',' chín ');
    $tien  = array('', ' nghìn', ' triệu', ' tỷ', ' nghìn tỷ', ' triệu tỷ');
    $count = 0;
    $i = 0;
    $so = 0;
    $kq = '';
    $temp = '';
    $vitri = array();
    if($sotien < 0) return '';
    if($sotien == 0) return 'Không đồng';
    if($sotien > 0)
        $so = $sotien;
    if($sotien > 8999999999999999)
        $sotien = 0;
    $vitri[5] = floor($so / 1000000000000000);
    $so = $so - $vitri[5] * 1000000000000000;
    $vitri[4] = floor($so / 1000000000000);
    $so = $so - $vitri[4] * 1000000000000;
    $vitri[3] = floor($so / 1000000000);
    $so = $so - $vitri[3] * 1000000000;
    $vitri[2] = floor($so / 1000000);
    $vitri[1] = floor(($so % 1000000)/1000);
    $vitri[0] = floor($so % 1000);

    if($vitri[5] > 0)
    {
        $count = 5;
    }
    else if($vitri[4] > 0)
    {
        $count = 4;
    }
    else if($vitri[4] > 0)
    {
        $count = 4;
    }
    else if($vitri[3] > 0)
    {
        $count = 3;
    }
    else if($vitri[2] > 0)
    {
        $count = 2;
    }
    else if($vitri[1] > 0)
    {
        $count = 1;
    }
    else
        $count = 0;

    for($i = $count;$i>=0;$i--)
    {
        $temp = DocSo3ChuSo($vitri[$i]);
        $kq .= $temp;
        if($vitri[$i] != 0) $kq .= $tien[$i];
//        if($i > 0 && strlen($temp) > 0) $kq .= ',';
    }

//    if(substr($kq, strlen($kq) - 1, 1) == ',')
//        $kq = substr ($kq, 0, strlen($kq) - 1);
    $kq = trim($kq) . ' đồng';
    $kq = strtoupper(substr($kq, 0, 1)) . substr($kq, 1);
    return $kq;
}
?>