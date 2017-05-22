<div style="width:90%;background-color:#f5f5f5;margin:auto;padding:20px;border:solid 1px #ddd;line-height:20px;font-family:tahoma;font-size:13px;border-bottom:solid 1px #002C3F;">
    <h2 style="background-color:#002C3F;font-size:14px;font-family:tahoma,arial;color:#fff;font-weight:bold;padding:5px;"><?php echo HEADER_EMAIL;?></h2>
    <p style="padding:5px;line-height:20px;">Chào <?php echo $fullname; ?>,</p>
    <p style="padding:5px;line-height:20px;">Bạn đã yêu cầu thay đổi lại mật khẩu từ hệ thống của <a href="<?php echo DOMAIN_NAME;?>"><?php echo DOMAIN_NAME?></a>.</p>
    <p style="padding:5px;line-height:20px;">Sau đây là thông tin đăng nhập mới của bạn:</p>
    <p style="padding:5px;line-height:20px;">Tên đăng nhập: <strong><?php echo $username; ?></strong><br/>
    Mật khẩu: <strong><?php echo $password; ?></strong></p>
</div>