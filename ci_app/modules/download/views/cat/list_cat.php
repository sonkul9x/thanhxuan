<?php
    $this->load->view('cat/cat_nav');
    echo form_open('', array('id' => 'submit_form'), array('id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', DOWNLOAD_CAT_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('cat/filter_form'); ?>
    <table class="list" style="width: 100%; margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 5%">ID</th>
            <th class="left">PHÂN LOẠI</th>
            <th class="left" style="width: 35%">ĐƯỜNG DẪN</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
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
                $uri = '/'.url_title($cat->title, 'dash', TRUE) . '-d' .$cat->id;
            }else{
                $uri = '/'.$cat->slug;
            }
            $this_lang = ($cat->lang<>DEFAULT_LANGUAGE)?'/'.$cat->lang:'';
            ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><?php echo $cat->id; ?></td>
            <td class="left"><a href="<?php echo $this_lang . $uri; ?>"><?php echo $padding.$cat->title; ?></a></td>
            <td><?php echo $uri;?></td>
            <td class="center">
                <a class="edit" title="Sửa phân loại này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo DOWNLOAD_CAT_ADMIN_EDIT_URL; ?>','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa phân loại này" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo DOWNLOAD_CAT_ADMIN_DELETE_URL; ?>','delete');"><em>&nbsp;</em></a>
                <a class="up" title="Cập nhật (up) lên trước" href="javascript:void(0);" onclick="submit_action_admin(<?php echo $cat->id; ?>,'<?php echo DOWNLOAD_CAT_ADMIN_UP_URL; ?>','up');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>