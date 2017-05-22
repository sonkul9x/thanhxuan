<?php
    $this->load->view('admin/news_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', NEWS_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 0%">&nbsp;</th>
            <th class="left">TIÊU ĐỀ BÀI VIẾT</th>
            <th class="left" style="width: 15%">PHÂN LOẠI BÀI VIẾT</th>
            <th class="center" style="width: 7%">TẠO</th>
            <th class="center" style="width: 7%">SỬA</th>
            <th class="center" style="width: 5%">XEM</th>
            <th class="center" style="width: 5%">NGÀY ĐĂNG</th>
            <!--<th class="center" style="width: 7%">TRANG CHỦ</th>-->
            <th class="center" style="width: 7%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($news)){
        $stt = 0;
        foreach($news as $index => $new):
            if(SLUG_ACTIVE==0){
                $row_uri = '/' . url_title(trim($new->title), 'dash', TRUE) . '-ns' . $new->id;
            }else{
                $row_uri = '/' . $new->slug;
            }
            $created_date   = get_vndate_string($new->created_date);
            $updated_date   = get_vndate_string($new->updated_date);
            $check          = $new->status == STATUS_ACTIVE ? 'checked' : '';
//            $check_home     = $new->home == STATUS_ACTIVE ? 'checked' : '';
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
            $this_lang = ($new->lang<>DEFAULT_LANGUAGE)?'/'.$new->lang:'';
            $creator_username = !empty($new->creator_username)?$new->creator_username:'admin';
            $editor_username = !empty($new->editor_username)?$new->editor_username:'';
        ?>
        <tr class="<?php echo $style ?>">
            <td><img src="<?php echo $new->thumbnail; ?>" style="height: 20px;"/></td>
            <td><a href="<?php echo $this_lang . $row_uri; ?>"><?php echo $new->title; ?></a></td>
            <td style="white-space:nowrap;"><?php echo $new->category; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $creator_username; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $editor_username; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $new->viewed; ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $created_date; ?></td>
            <!--<td class="center" style="white-space:nowrap;"><input type="checkbox" <?php // echo $check_home;?> onclick="change_home(<?php // echo $new->id;?>,'news')"></td>-->
            <?php if($this->phpsession->get('roles_publisher') == STATUS_ACTIVE){ ?>
            <td class="center" style="white-space:nowrap;"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $new->id;?>,'news')"></td>
            <?php }else{ ?>
            <td class="center"><?php echo status_show_label($new->status); ?></td>
            <?php } ?>
            <td class="center" style="white-space:nowrap;" class="action">
                <?php if($this->phpsession->get('user_id') == $new->creator || $this->phpsession->get('roles_publisher') == STATUS_ACTIVE){ ?>
                <a class="edit" title="Sửa bài viết" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $new->id ?>,'<?php echo NEWS_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <?php } ?>
                <?php if($this->phpsession->get('user_id') == $new->creator || $this->phpsession->get('roles_publisher') == STATUS_ACTIVE){ ?>
                <a class="del" title="Xóa bài viết" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $new->id ?>,'<?php echo NEWS_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <?php } ?>
                <a class="up" title="Cập nhật (up) lên đầu trang" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $new->id ?>,'<?php echo NEWS_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' bài viết</span>)'; ?>
        <tr class="list-footer">
            <th colspan="10">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>