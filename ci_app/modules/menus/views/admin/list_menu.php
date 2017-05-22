<?php
    $this->load->view('admin/menu_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', MENUS_ADMIN_BASE_URL);
    echo form_close();
?>

<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%;margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left">TÊN MENU</th>
            <th class="left" style="width: 30%">ĐƯỜNG DẪN</th>
            <th class="left" style="width: 25%">PHÂN LOẠI</th>
            <!--<th class="left" style="width: 5%">NỘI BỘ</th>-->
            <th class="left" style="width: 5%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php 
        if(isset($menus)){
        $stt = 0;
        foreach($menus as $index => $cat):
            $i = 0;
            $padding = '';
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
            $check = $cat->active == STATUS_ACTIVE ? 'checked' : '';
            if($cat->level <> 0){
                $padding = '';
                while($i<$cat->level){
                    $padding .= '- - ';
                    $i++;
                }
            }
            $change_private = $cat->private == STATUS_ACTIVE ? 'checked' : '';
            $this_lang = ($cat->lang<>DEFAULT_LANGUAGE)?'/'.$cat->lang:'';
        ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><a href="<?php echo $this_lang . $cat->url_path; ?>"><?php echo $padding.$cat->caption; ?></a></td>
            <td class="left"><?php echo $cat->url_path; ?></td>
            <td class="left"><?php echo $cat->name; ?></td>
<!--            <td class="center" style="white-space:nowrap;">
                <?php // if($cat->level == 0){ ?>
                <input type="checkbox" <?php // echo $change_private;?> onclick="change_private(<?php // echo $cat->id;?>,'menus')">
                <?php // } ?>
            </td>-->
            <td class="center"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $cat->id;?>,'menus')"></td>
            <td class="center">
                <a class="edit" title="Sửa menu này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo MENUS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa menu này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo MENUS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Cập nhật (up) lên trước" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo MENUS_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
        <?php $left_page_links = 'Tổng số: ' . $total_rows; ?>
        <tr class="list-footer">
            <th colspan="6">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>