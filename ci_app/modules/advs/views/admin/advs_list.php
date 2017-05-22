<?php
    $this->load->view('admin/advs_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', ADVS_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 3%">Mã số</th>
            <th class="left" style="width: 10%">HÌNH ẢNH</th>
            <th class="left" style="width: 20%">TIÊU ĐỀ</th>
            <th class="left" style="width: 20%">LOẠI QUẢNG CÁO</th>
            <th class="left" style="">ĐƯỜNG DẪN</th>
            <!--<th class="center" style="width: 5%">CLICK</th>-->
            <th class="center" style="width: 9%">THỜI HẠN</th>
            <th class="center" style="width: 8%">CỠ THỰC</th>
            <th class="center" style="width: 8%">CỠ CHUẨN</th>
            <th class="center" style="width: 5%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($advs)){
        $stt = 0;
        foreach($advs as $index => $adv):
        $images = $adv->image_name;
        //$images         = base_url().'images/img/thumbnails/' . $adv->image_name;
        //$url_path_sort  = character_limiter($adv->url_path,20);
        
        if($adv->url_path <> '')
            $url_path_sort  = limit_text($adv->url_path, 25);
//            $url_path_sort  = substr($adv->url_path, 0, 45) . '...';
        else $url_path_sort = $adv->url_path;
        
        $check = $adv->status == STATUS_ACTIVE ? 'checked' : '';
        
//        $number_click = modules::run('advs/advs_click/count_click',array('advs_id'=>$adv->id));
        
        if($adv->end_time > ADVS_ZERO_TIME){
            $time = ($adv->end_time > now())?(date('d/m/Y H:i',$adv->end_time)):'<span style="color: red;">Quá hạn</span>';
        }else{
            $time = '';
        }
        
        $style = $stt++ % 2 == 0 ? 'even' : 'odd';
        ?>
        <tr class="<?php echo $style ?>">
            <td><?php echo $adv->id; ?></td>
            <td><img src="<?php echo ADVS_IMAGE_THUMB_UPLOAD_URL. $images;?>" style="height: 40px;" /></td>
            <td><?php echo $adv->title; ?></td>
            <td><?php echo $adv->cat_title; ?></td>
            <td style="white-space:nowrap;"><a href="<?php echo isset($adv->url_path)?$adv->url_path:''; ?>" target="_blank"><?php echo $url_path_sort; ?></a></td>
            <!--<td class="center" style="white-space:nowrap;"><?php // echo $number_click; ?></td>-->
            <td class="center" style="white-space:nowrap;"><?php echo $time; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $adv->image_dimension; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $adv->cat_dimension; ?></td>
            <td class="center" style="white-space:nowrap;"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $adv->id;?>,'advs')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa quảng cáo" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $adv->id ?>,'<?php echo ADVS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa quảng cáo" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $adv->id ?>,'<?php echo ADVS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Lên trước" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $adv->id ?>,'<?php echo ADVS_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Tổng số: ' . $total_rows; ?>
        <tr class="list-footer">
            <th colspan="11">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>