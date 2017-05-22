<?php echo form_open('/dashboard/auth/change_password'); ?>

    <div class="page_header">
        <h1 class="fleft">Đổi mật khẩu</h1>
        <small class="fleft">"Thay đổi mật khẩu của bạn"</small>
        <span class="fright"><a class="button close" href= "/dashboard"><em>&nbsp;</em>Đóng</a></span>
        <br class="clear"/>
    </div>

    <div class="form_content">
        <?php $this->load->view('powercms/message'); ?>
        <table>
            <tr><td class="title">Mật khẩu cũ: (<span>*</span>)</td></tr>
            <tr><td><?php echo form_password(array('name' => 'password', 'size' => '50', 'maxlength' => '50', 'value' => set_value('password'))); ?></td></tr>
            <tr><td class="title">Mật khẩu mới: (<span>*</span>)</td></tr>
            <tr><td><?php echo form_password(array('name' => 'new_password', 'size' => '50', 'maxlength' => '50', 'value' => set_value('new_password'))); ?></td></tr>
            <tr><td class="title">Xác nhận mật khẩu mới: (<span>*</span>)</td></tr>
            <tr><td><?php echo form_password(array('name' => 'new_password2', 'size' => '50', 'maxlength' => '50', 'value' => set_value('new_password2'))); ?></td></tr>
            <tr><td class="title">Nhập mã an toàn ở hình bên dưới: (<span>*</span>)</td></tr>
            <tr><td><?php echo form_input(array('name' => 'security_code', 'size' => '50', 'maxlength' => '10')); ?><br/><img src="/security_code" style="margin: 5px;"/></td></tr>
            <tr><td>
                <input type="submit" name="Submit" value="Đổi mật khẩu" class="btn" />
                <input type="reset" value="Làm lại" class="btn" />
            </td></tr>
        </table>
        <br class="clear"/>&nbsp;
    </div>

<?php echo form_close(); ?>