<?php
    $this->load->view('admin/pages_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', PAGES_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin-bottom: 10px;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 25%">TÊN TRANG</th>
            <th class="left">ĐƯỜNG DẪN</th>
            <th class="center" style="width: 5%">NGÀY ĐĂNG</th>
            <!--<th class="center" style="width: 5%">HIỂN THỊ</th>-->
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php
        if(isset($pages)){
        $stt = 0;
        foreach($pages as $index => $page):
            if(SLUG_ACTIVE==0){
                $row_url = $page->uri;
                $page_uri = $page->uri;
            }else{
                $row_url = '/' . $page->slug;
                $page_uri = '/' . $page->slug;
            }
            $created_date   = get_vndate_string($page->created_date);
            $style = $stt++ % 2 == 0 ? 'even' : 'odd';
            $check          = $page->status == STATUS_ACTIVE ? 'checked' : '';
            $this_lang = ($page->lang<>DEFAULT_LANGUAGE)?'/'.$page->lang:'';
        ?>
        <tr class="<?php echo $style ?>">
            <td><a href="<?php echo $this_lang . $row_url; ?>"><?php echo $page->title?></a></td>
            <td><?php echo $page_uri;?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $created_date?></td>
            <!--<td class="center" style="white-space:nowrap;"><input type="checkbox" <?php // echo $check;?> onclick="change_status(<?php // echo $page->id;?>,'pages')"></td>-->
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $page->id ?>,'<?php echo PAGES_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $page->id ?>,'<?php echo PAGES_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $e_page . ' / ' . $total_pages . ' (<span>Tổng: ' . $total_rows . '</span>)'; ?>
        <tr class="list-footer">
            <th colspan="7">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>