<?php
    $this->load->view('cat/cat_nav');
    echo form_open('', array('id' => 'cat_form'), array('cat_id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', FAQ_CAT_ADMIN_BASE_URL);
    echo form_close();
?>
<div class="form_content">
    <?php // $this->load->view('cat/filter_form'); ?>
    <table class="list" style="width: 100%; margin: 10px 0;">
        <?php $this->load->view('powercms/message'); ?>
        <tr>
            <th class="left" style="width: 30%">PHÂN LOẠI</th>
            <th class="left" style="width: 65%">ĐƯỜNG DẪN</th>
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
            $uri            = '/'.url_title($cat->category, 'dash', TRUE) . '-q' .$cat->id;
            ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><a href="<?php echo $uri;?>"><?php echo $padding.$cat->category; ?></a></td>
            <td><?php echo $uri;?></td>
            <td class="center">
                <a class="edit" title="Sửa phân loại này" href="javascript:void(0);" onclick="submit_action_cat(<?php echo $cat->id; ?>,'faq','edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa phân loại này" href="javascript:void(0);" onclick="submit_action_cat(<?php echo $cat->id; ?>,'faq','delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br class="clear"/>&nbsp;
</div>