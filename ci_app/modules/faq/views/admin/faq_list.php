<?php
    $this->load->view('admin/faq_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', FAQ_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 0%">&nbsp;</th>
            <th class="left" style="width: 55%">TIÊU ĐỀ</th>
            <th class="left" style="width: 25%">PHÂN LOẠI</th>
            <th class="center" style="width: 5%">XEM</th>
            <th class="center" style="width: 5%">NGÀY ĐĂNG</th>
            <th class="center" style="width: 5%">HIỂN THỊ</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($faqs)){
        $stt = 0;
        foreach($faqs as $index => $faq):
            if(SLUG_ACTIVE==0){
                $row_uri = '/' . url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;
            }else{
                $row_uri = '/' . $faq->slug;
            }
            $created_date   = get_vndate_string($faq->created_date);
            $updated_date   = get_vndate_string($faq->updated_date);
            $check          = $faq->status == STATUS_ACTIVE ? 'checked' : '';
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
            $this_lang = ($faq->lang<>DEFAULT_LANGUAGE)?'/'.$faq->lang:'';
        ?>
        <tr class="<?php echo $style ?>">
            <td><img src="<?php echo $faq->thumbnail;?>" style="height: 20px;"/></td>
            <td><a href="<?php echo $this_lang . $row_uri; ?>"><?php echo $faq->title?></a></td>
            <td style="white-space:nowrap;"><?php echo $faq->category ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $faq->viewed ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $created_date?></td>
            <td class="center" style="white-space:nowrap;"><input type="checkbox" <?php echo $check;?> onclick="change_status(<?php echo $faq->id;?>,'faq')"></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $faq->id ?>,'<?php echo FAQ_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $faq->id ?>,'<?php echo FAQ_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Up lên" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $faq->id ?>,'<?php echo FAQ_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng số: ' . $total_rows . ' bài viết</span>)'; ?>
        <tr class="list-footer">
            <th colspan="8">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>