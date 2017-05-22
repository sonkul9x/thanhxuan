<?php
    $this->load->view('admin/videos_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', VIDEOS_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
     <?php 
        if(isset ($filter)) echo $filter;
        $this->load->view('admin/toggle_add_videos_form');
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
        if(isset($videos)){
        $stt = 0;
        foreach ($videos as $index => $video):
            if(SLUG_ACTIVE==0){
                $uri            = get_base_url() . url_title(trim($video->title), 'dash', TRUE) . '-vs' . $video->id;    
                $short_uri      = '/' . url_title(trim($video->title), 'dash', TRUE) . '-vs' . $video->id;
            }else{
                $uri = get_base_url() . $video->slug;
                $short_uri = '/' . $video->slug;
            }
            $video_id      = $video->id;
            $title          = $video->title;
            $category       = $video->category;
            $warning        = strlen($video->image_name)==0 ? '<img src="/powercms/images/warning.png"' : '';
            $updated_date   = get_vndate_string(date('Y-m-d H:i:s',$video->update_time));
            $created_date   = get_vndate_string(date('Y-m-d H:i:s',$video->create_time));
            $style          = ($stt++ % 2 == 0) ? 'even' : 'odd';
            $image          = '<img src="' . $video->image_name . '" alt="' . $video->image_name . '" style="height: 20px;" />';
            $check          = $video->status == STATUS_ACTIVE ? 'checked' : '';
            $this_lang = ($video->lang<>DEFAULT_LANGUAGE)?'/'.$video->lang:'';
        ?>
        <tr class="<?php echo $style ?>">
            <td style="width:1%;"><?php echo $image; ?></td>
            <td class="left">
                <a href="<?php echo $this_lang . $short_uri; ?>"><?php echo $title;?></a> <span title="Chưa có hình ảnh sẽ không được hiển thị"><?php echo $warning;?></span>
            </td>
            <td class="left" style="word-wrap:break-word;"><?php echo $category; ?></td>
            <td class="center"><?php echo $short_uri; ?></td>
            <td class="center"><?php echo $updated_date; ?></td>
            <td class="center"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $video_id;?>,'videos')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $video_id ?>,'<?php echo VIDEOS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $video_id ?>,'<?php echo VIDEOS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Cập nhật (up) đầu trang" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $video_id ?>,'<?php echo VIDEOS_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>

        <?php endforeach; ?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' videos</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>