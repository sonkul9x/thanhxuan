<?php echo form_open_multipart($submit_uri);
if (isset($id)) echo form_hidden('id', $id);
echo form_hidden('back_url', CONFIGURATIONS_ADMIN_BASE_URL);
?>

<div class="page_header">
    <h1 class="fleft">Cấu hình chung</h1>
    <small class="fleft">"Chỉnh sửa cấu hình chung hệ thống"</small>
    <span class="fright"><a class="button close" href= "<?php echo ADMIN_BASE_URL; ?>"><em>&nbsp;</em>Đóng</a></span>
    <!--<span class="fright"><a class="button save" href= "/dashboard/system_config/save-cache"><em>&nbsp;</em>Ghi nhớ</a></span>-->
    <br class="clear"/>
</div>

<div class="form_content">
    
    <div class="filter display_status">
        Ngôn ngữ: <?php if (isset($lang_combobox)) {echo $lang_combobox;} ?>
    </div>
    
    <?php $this->load->view('powercms/message'); ?>
    <ul class="tabs">
            <li><a href="#tab1">Email</a></li>
            <li><a href="#tab2">Sản phẩm</a></li>
            <li><a href="#tab3">Bài viết</a></li>
            <!--<li><a href="#tab4">Giới thiệu ở trang chủ</a></li>-->
            <li><a href="#tab7">Thông tin cuối trang</a></li>
            <li><a href="#tab8">Trang liên hệ</a></li>
            <li><a href="#tab5">Tracker</a></li>
            <li><a href="#tab6">Meta data</a></li>
            <li><a href="#tab10">Thanh toán</a></li>
            <li><a href="#tab9">Khác</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
            <tr><td class="title">Email nhận liên hệ của khách hàng: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'contact_email', 'style' => 'width:400px;', 'value' => $contact_email)); ?></td>
            </tr>
            <tr><td class="title">Email nhận đơn đặt hàng: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'order_email', 'style' => 'width:400px;', 'value' => $order_email)); ?></td>
            </tr>
            <tr><td class="title">Email gửi cho khách hàng khi khách đặt hàng thành công: </td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'order_email_content', 'style' => 'width:560px; height: 80px;', 'value' =>  ($order_email_content != '') ? $order_email_content : set_value('order_email_content'), 'class' => 'wysiwyg elm1')); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab2" class="tab_content">
            <table>
            <tr><td class="title">Số sản phẩm hiển thị trên mỗi trang: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'products_per_page', 'value' => $products_per_page)); ?></td>
            </tr>
<!--            <tr><td class="title">Số sản phẩm hiển thị trên mỗi danh mục: </td></tr>
            <tr>
                <td><?php // echo form_input(array('name' => 'products_side_per_page', 'value' => $products_side_per_page)); ?></td>
            </tr>-->
            <tr><td class="title">Số sản phẩm hiển thị trên trang chủ: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'number_products_per_home', 'value' => $number_products_per_home)); ?></td>
            </tr>
            <tr><td class="title">Số sản phẩm hiển thị mục bên phải: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'number_products_per_side', 'value' => $number_products_per_side)); ?></td>
            </tr>
            <tr><td class="title">Số điện thoại hiển thị trong trang chi tiết sản phẩm: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'telephone', 'value' => $telephone)); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab3" class="tab_content">
            <table>
            <tr><td class="title">Số bài viết hiển thị mỗi trang tin: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'news_per_page', 'value' => $news_per_page)); ?></td>
            </tr>
            <tr><td class="title">Số bài viết hiển thị trong mục tin bên cạnh: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'number_news_per_side', 'value' => $number_news_per_side)); ?></td>
            </tr>
<!--            <tr><td class="title">Số bài viết trên trang chủ: </td></tr>
            <tr>
                <td><?php // echo form_input(array('name' => 'number_news_per_home', 'value' => $number_news_per_home)); ?></td>
            </tr>-->
            </table>
        </div>
<!--        <div id="tab4" class="tab_content">
            <table>
            <tr><td class="title">Giới thiệu ngắn về công ty (hiển thị trên trang chủ): </td></tr>
            <tr>
                <td><?php // echo form_textarea(array('name' => 'company_infomation', 'value' => $company_infomation,'class' => 'wysiwyg elm1')); ?></td>
            </tr>
            </table>
        </div>-->
        <div id="tab7" class="tab_content">
            <table>
            <tr><td class="title">Thông tin cuối trang: </td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'footer_contact', 'value' => $footer_contact,'class' => 'wysiwyg elm1')); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab8" class="tab_content">
            <table>
            <tr><td class="title">Google map code: </td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'google_map_code', 'style' => 'width:560px; height: 80px;', 'value' => $google_map_code)); ?></td>
            </tr>
            <tr><td class="title">Thông tin liên hệ: </td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'contact_infomation', 'value' => $contact_infomation,'class' => 'wysiwyg elm1')); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab5" class="tab_content">
            <table>
            <tr><td class="title">Google tracker code: </td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'google_tracker', 'style' => 'width:560px; height: 80px;', 'value' => $google_tracker)); ?></td>
            </tr>
            <tr><td class="title">Webmaster tracker code: </td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'webmaster_tracker', 'style' => 'width:560px; height: 80px;', 'value' => $webmaster_tracker)); ?></td>
            </tr>
            </table>
        </div>

        <div id="tab6" class="tab_content">
            <table>
                <tr><td class="title">Meta title: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '256', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                    </td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                    </td>
                </tr>
            </table>
        </div>
        
        <div id="tab9" class="tab_content">
            <table>
<!--            <tr><td class="title">Slogan: </td></tr>
            <tr>
                <td><?php // echo form_input(array('name' => 'slogan', 'size' => '50', 'maxlength' => '500', 'style' => 'width:560px;', 'value' => $slogan)); ?></td>
            </tr>-->
            <tr><td class="title">LOGO: </td></tr>
            <tr>
                <td><input id="image_name" name="userfile" type="file" value="" class="btn" />
                <?php if(!empty($logo)){ ?>
                &nbsp;<img src="<?php echo base_url().'images/uploads/logo/'.$logo; ?>" height="50px" /><a href="/dashboard/delete-images-logo/<?php echo get_language(); ?>">Xóa</a></td>
                <?php } ?>
            </tr>
            <tr><td class="title">Favicon: </td></tr>
            <tr>
                <td><input id="image_name_2" name="userfile2" type="file" value="" class="btn" />
                <?php if(!empty($favicon)){ ?>
                &nbsp;<img src="<?php echo base_url().'images/uploads/favicon/'.$favicon; ?>" height="50px" /><a href="/dashboard/delete-images-favicon/<?php echo get_language(); ?>">Xóa</a></td>
                <?php } ?>
            </tr>
            <tr><td class="title">Facebook ID (Fanpage): </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'facebook_id', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $facebook_id)); ?></td>
            </tr>
            <tr><td class="title" style="vertical-align: top">Mã livechat:</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('name' => 'livechat','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $livechat)); ?>
                </td>
            </tr>
            </table>
        </div>
        
        <div id="tab10" class="tab_content">
            <table>
            <tr><td class="title">Thông báo order thành công: </td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'success_order', 'style' => 'width:560px; height: 80px;', 'value' =>  ($success_order != '') ? $success_order : set_value('success_order'), 'class' => 'wysiwyg elm1')); ?></td>
            </tr>
            <!-- <tr><td class="title">Hình thức thanh toán qua tài khoản ngân hàng: </td></tr>
            <tr>
                <td><?php //echo form_textarea(array('name' => 'pay_bank', 'style' => 'width:560px; height: 80px;', 'value' =>  ($pay_bank != '') ? $pay_bank : set_value('pay_bank'), 'class' => 'wysiwyg elm1')); ?></td>
            </tr>
            <tr><td class="title">Hình thức thanh toán cho nhân viên thu tiền: </td></tr>
            <tr>
                <td><?php //echo form_textarea(array('name' => 'pay_people', 'style' => 'width:560px; height: 80px;', 'value' =>  ($pay_people != '') ? $pay_people : set_value('pay_people'), 'class' => 'wysiwyg elm1')); ?></td>
            </tr>
            <tr><td class="title">Hình thức thanh toán tại văn phòng: </td></tr>
            <tr>
                <td><?php //echo form_textarea(array('name' => 'pay_info', 'style' => 'width:560px; height: 80px;', 'value' =>  ($pay_info != '') ? $pay_info : set_value('pay_info'), 'class' => 'wysiwyg elm1')); ?></td>
            </tr> -->
            </table>
        </div>

        <br class="clear"/>
        <div style="margin-top: 10px;"></div>
        <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Lưu lại', 'class' => 'btn')); ?>
        <input type="reset" value="Làm lại" class="btn" />
        <br class="clear"/>&nbsp;
    </div>
</div>
<?php echo form_close(); ?>