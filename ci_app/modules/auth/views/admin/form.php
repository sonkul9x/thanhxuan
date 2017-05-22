<?php 
echo form_open($submit_uri); 
if (isset($id)) {echo form_hidden('id', $id);}
$username = isset($username) ? $username : '';
$password = isset($password) ? $password : '';
$fullname = isset($fullname) ? $fullname : '';
$email = isset($email) ? $email : '';
$tel = isset($tel) ? $tel : '';
$submit_uri = isset($submit_uri) ? $submit_uri : '';
echo form_hidden('form', 'auth_cat');
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thông tin người dùng"</small>
    <span class="fright"><a class="button close" href="<?php echo AUTH_USERS_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('powercms/message'); ?>
    <table>
        <tr><td class="title">Tên đăng nhập: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'username', 'size' => '50', 'maxlength' => '30', 'style' => 'width:560px;', 'value' => $username)); ?></td>
        </tr>
        <?php if(!isset($is_edit)){ ?>
        <tr><td class="title">Mật khẩu: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_password(array('name' => 'password', 'size' => '50', 'maxlength' => '50', 'style' => 'width:560px;', 'value' => $password)); ?></td>
        </tr>
        <?php }else{ ?>
        <tr><td class="title">Mật khẩu: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_password(array('name' => 'password', 'size' => '50', 'maxlength' => '50', 'style' => 'width:560px;', 'value' => $password)); ?> <span style="color:#999;">(để trống nếu không thay đổi)</span></td>
        </tr>
        <?php } ?>
        <tr><td class="title">Họ tên: </td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '50', 'style' => 'width:560px;', 'value' => $fullname)); ?></td>
        </tr>
        <tr><td class="title">Email: </td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $email)); ?></td>
        </tr>
        <tr><td class="title">Điện thoại: </td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '25', 'style' => 'width:560px;', 'value' => $tel)); ?></td>
        </tr>
        <tr><td class="title">Quyền hạn: (<span>*</span>)</td></tr>
        <tr>
            <td id="category"><?php if (isset($roles_combobox)){echo $roles_combobox;} ?></td>
        </tr>
    </table>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'btn')); ?>
    <input type="reset" value="Làm lại" class="btn" />
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>