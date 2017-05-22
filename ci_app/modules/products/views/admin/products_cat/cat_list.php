<?php
    $this->load->view('admin/products_cat/cat_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', PRODUCTS_CAT_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/products_cat/filter_form'); ?>
    <table class="list" style="width: 100%;margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 30%">PHÂN LOẠI</th>
            <th class="left" style="width: 60%">ĐƯỜNG DẪN</th>
            <th class="center" style="width: 5%">TRANG CHỦ</th>
            <!--<th class="center" style="width: 7%">HIỂN THỊ</th>-->
            <!--<th class="center" style="width: 5%">CHỨC NĂNG</th>-->
        </tr>
        <?php 
        if(isset($categories)){
        $stt = 0;
        foreach($categories as $index => $cat):
            $i = 0;
            $padding = '';
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
            if($cat->level <> 0){
                $padding = '';
                while($i<$cat->level){
                    $padding .= '- - ';
                    $i++;
                }
            }
            if(SLUG_ACTIVE==0){
                $uri = '/'.url_title($cat->category, 'dash', TRUE) . '-p' .$cat->id;
            }else{
                $uri = '/'.$cat->slug;
            }
            
            $check = $cat->status == STATUS_ACTIVE ? 'checked' : '';
            $check_home = $cat->home == STATUS_ACTIVE ? 'checked' : '';
            $this_lang = ($cat->lang<>DEFAULT_LANGUAGE)?'/'.$cat->lang:'';
            ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><a href="<?php echo $this_lang . $uri;?>"><?php echo $padding.$cat->category; ?></a></td>
            <td><?php echo $uri;?></td>
            <!--<td class="center" style="white-space:nowrap;">
                <?php //if($cat->level == 0){ ?>
                <input type="checkbox" <?php //echo $check_home;?> onclick="change_home_cat(<?php //echo $cat->id;?>,'products')">
                <?php //} ?>
            </td>
            <!--<td class="center" style="white-space:nowrap;"><input type="checkbox" <?php //echo $check;?> onclick="change_status(<?php //echo $cat->id;?>,'products/cat')"></td>-->
            <td class="center">
                <a class="edit" title="Sửa phân loại này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo PRODUCTS_CAT_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa phân loại này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo PRODUCTS_CAT_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Cập nhật (up) lên trước" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo PRODUCTS_CAT_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php $padding = ''; endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>