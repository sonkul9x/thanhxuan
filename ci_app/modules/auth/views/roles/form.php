<?php 
echo form_open($submit_uri); 
if (isset($id)) {echo form_hidden('id', $id);}
$name = isset($name) ? $name : '';
$submit_uri = isset($submit_uri) ? $submit_uri : '';
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Vai trò người dùng"</small>
    <span class="fright"><a class="button close" href="<?php echo AUTH_ROLES_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <table>
        <tr><td class="title">Tên vai trò: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'name', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $name)); ?></td>
        </tr>
        <tr><td class="title">Cho phép duyệt và sửa bài viết:
            <?php $publisher = (!empty($publisher) && $publisher == STATUS_ACTIVE)?TRUE:FALSE; ?>
            <?php echo form_checkbox(array('name'=>'publisher','value'=>STATUS_ACTIVE,'checked'=>$publisher,'style'=>'height:auto;')); ?>
            </td>
        </tr>
        <tr><td class="title">Vai trò:</td></tr>
        <tr> <td> <table style="width: 100%;">
            <tr>
                <td style="width: 5%;">
                    <?php $check_all = (!empty($roles_check) && $roles_check == AUTH_ROLES_ALL)?TRUE:FALSE; ?>
                    <?php echo form_checkbox(array('name'=>'roles_all','id'=>'roles_all','value'=>AUTH_ROLES_ALL,'checked'=>$check_all,'style'=>'height:auto;')); ?>
                </td>
                <td style="width: 95%;">
                    <label for="roles_all">Tất cả</label>
                </td>
            </tr>
            <?php if(!empty($roles_list)) { 
            foreach($roles_list as $key => $value) { 
                $check = (!empty($roles_check) && $roles_check <> AUTH_ROLES_ALL && in_array($value->id, $roles_check))?TRUE:FALSE;
                ?>
            <tr>
                <td  style="width: 5%;">
                    <?php echo form_checkbox(array('name'=>'roles[]','id'=>'roles_'.$key,'value'=>$value->id,'checked'=>$check,'style'=>'height:auto;')); ?>
                </td>
                <td style="width: 95%;">
                    <label for="roles_<?php echo $key; ?>"><?php echo $value->label; ?></label>
                </td>
            </tr>
            <?php }} ?>
            <tr>
                <td  style="width: 5%;">
                    <?php echo form_checkbox(array('checked'=>TRUE,'disabled'=>TRUE,'style'=>'height:auto;')); ?>
                </td>
                <td style="width: 95%;">
                    <label>Thay đổi mật khẩu</label>
                </td>
            </tr>
            <tr>
                <td  style="width: 5%;">
                    <?php echo form_checkbox(array('checked'=>TRUE,'disabled'=>TRUE,'style'=>'height:auto;')); ?>
                </td>
                <td style="width: 95%;">
                    <label>Dashboard</label>
                </td>
            </tr>
        </table> </td> </tr>
    </table>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
    <input type="reset" value="Làm lại" class="btn" />
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>