<?php
    $this->load->view('admin/download_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', DOWNLOAD_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%; margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 25%">TIÊU ĐỀ</th>
            <th class="left" style="width: 25%">PHÂN LOẠI</th>
            <th class="left" style="width: 25%">TÊN FILE</th>
            <th class="left" style="width: 10%">DUNG LƯỢNG</th>
            <th class="left" style="width: 10%">LOẠI FILE</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php 
        if(isset($downloads)){
        $stt = 0;
        foreach($downloads as $index => $download):
//        $date   = date('d-m-Y',strtotime($download->date));
        $style = $stt++ % 2 == 0 ? 'even' : 'odd';
        ?>
        <tr class="<?php echo $style ?>">
            <td style="word-wrap:break-word;"><?php echo $download->title; ?></td>
            <td style="word-wrap:break-word;"><?php echo ($download->category)?$download->category:'<span style="color: red;">Chưa phân loại</span>'; ?></td>
            <td style="word-wrap:break-word;"><a href="<?php echo DOWNLOAD_ADMIN_FILE_URL.$download->id; ?>"><?php echo $download->name; ?></a></td>
            <td style="word-wrap:break-word;"><?php echo $download->size; ?></td>
            <td style="word-wrap:break-word;"><?php echo $download->ext; ?></td>
            <td class="center" style="white-space:nowrap;" class="action">
                <a class="edit" title="Sửa" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $download->id; ?>,'<?php echo DOWNLOAD_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="download" title="Tải về" href="<?php echo DOWNLOAD_ADMIN_FILE_URL.$download->id; ?>"><em>&nbsp;</em></a>
                <a class="del" title="Xóa bỏ" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $download->id; ?>,'<?php echo DOWNLOAD_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach;?>
        <?php } ?>
        <?php $left_page_links = 'Trang ' . $e_page . ' / ' . $total_pages . ' (<span>Tổng: ' . $total_rows . '</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9">
                <div style="float:left; margin-top: 9px;"><?php echo $left_page_links; ?></div>
                <div style="float:right;" class="pagination"><?php if(isset($page_links) && $page_links!=='') echo $page_links; ?></div>
            </th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>