<?php
    $this->load->view('admin/gallery_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', GALLERY_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
     <?php 
        if(isset ($filter)) echo $filter;
        $this->load->view('admin/toggle_add_gallery_form');
     ?>
    
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 25%" colspan="2">TIÊU ĐỀ</th>
            <th class="left" style="width: 25%">PHÂN LOẠI</th>
            <th class="center" style="width: 35%">ĐƯỜNG DẪN</th>
            <th class="center" style="width: 5%">NGÀY SỬA</th>
            <th class="center" style="width: 5%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>
        <?php 
        if(isset($galleries)){
        $stt = 0;
        foreach ($galleries as $index => $gallery):
            if(SLUG_ACTIVE==0){
                $uri            = '/' . url_title(trim($gallery->gallery_name), 'dash', TRUE) . '-gs' . $gallery->id;    
                $short_uri      = '/' . url_title(trim($gallery->gallery_name), 'dash', TRUE) . '-gs' . $gallery->id;    
            }else{
                $uri = '/' . $gallery->slug;
                $short_uri = '/' . $gallery->slug;
            }
            $gallery_id     = $gallery->id;
            $gallery_name   = $gallery->gallery_name;
            $category       = $gallery->category;
            $warning        = strlen($gallery->image_name)==0 ? '<img src="/powercms/images/warning.png"' : '';
            $updated_date   = get_vndate_string(date('Y-m-d H:i:s',$gallery->update_time));
            $created_date   = get_vndate_string(date('Y-m-d H:i:s',$gallery->create_time));
            $style          = ($stt++ % 2 == 0) ? 'even' : 'odd';
            $image          = '/images/gallery/smalls/' . ((strlen($gallery->image_name)==0) ? 'no-image.png' : $gallery->image_name);
            $image          = '<img src="' . $image . '" alt="' . $gallery->image_name . '" style="height: 20px;" />';
            $check          = $gallery->status == STATUS_ACTIVE ? 'checked' : '';
            $this_lang = ($gallery->lang<>DEFAULT_LANGUAGE)?'/'.$gallery->lang:'';
        ?>
        <tr class="<?php echo $style ?>">
            <td style="width:1%;"><?php echo $image; ?></td>
            <td class="left">
                <a href="<?php echo $this_lang . $uri; ?>"><?php echo $gallery_name;?></a> <span title="Chưa có hình ảnh sẽ không được hiển thị"><?php echo $warning;?></span>
            </td>
            <td class="left" style="word-wrap:break-word;"><?php echo $category; ?></td>
            <td class="center"><?php echo $short_uri; ?></td>
            <td class="center"><?php echo $updated_date; ?></td>
            <td class="center"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $gallery_id;?>,'gallery')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $gallery_id ?>,'<?php echo GALLERY_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $gallery_id ?>,'<?php echo GALLERY_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Cập nhật (up) đầu trang" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $gallery_id ?>,'<?php echo GALLERY_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>

        <?php endforeach; ?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' gallery</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>