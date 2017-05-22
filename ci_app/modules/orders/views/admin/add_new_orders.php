<?php
echo form_open($submit_uri);
$submit_uri = ORDER_ADMIN_BASE_URL.'/add';

 $created_date = date('Ymd H:i:s');



echo form_hidden('is_add_edit_category', TRUE);


?>

<div class="page_header">

    <h1 class="fleft">Thêm Orders Mới</h1>

    <small class="fleft">"Nội dung order"</small>

    <span class="fright"><a class="button close" href="<?php echo ORDER_ADMIN_BASE_URL; ?>/" title="Đóng"><em>&nbsp;</em>Đóng</a></span>

    <br class="clear"/>

</div>



<div class="form_content">

    <?php $this->load->view('powercms/message'); ?>

            <table>
 

                <tr><td class="title">Họ tên (Người order):</td></tr>

                <tr>

                    <td><?php echo form_input(array('name' => 'fullname', 'size' => '50', 'maxlength' => '255','required' => 'required','style' => 'width:560px;')); ?></td>

                </tr>

                <tr><td class="title">Số điện thoại (Người order):</td></tr>

                <tr>

                    <td><?php echo form_input(array('name' => 'tel', 'size' => '50', 'maxlength' => '255','required' => 'required','style' => 'width:560px;')); ?></td>

                </tr>



                <tr><td class="title">Email: </td></tr>

                <tr>

                    <td><?php echo form_input(array('name' => 'email', 'size' => '50', 'maxlength' => '255','style' => 'width:560px;')); ?></td>

                </tr>
                <tr><td class="title">Facebook:</td></tr>
                <tr>

                    <td><?php echo form_input(array('name' => 'facebook', 'size' => '50', 'maxlength' => '255','style' => 'width:560px;')); ?></td>

                </tr>
                <?php for ($i=1; $i < 4; $i++) { ?>
                
                 <tr><td class="title">Order đơn hàng <?php echo $i; ?>: </td></tr>

                <tr>

                    <td id="category">
                        <select class="btn" name="hang_sk[<?php echo $i; ?>][order_hang]">
                        <option  selected="selected"  value="">Chọn Sản Phẩm</option>
                    <?php if(isset($order_hang)){ ?>
                    <?php foreach ($order_hang as $vorder_hang) { ?>
                      <option  value="<?php echo $vorder_hang->id; ?>"><?php echo $vorder_hang->product_name; ?></option>
                    <?php } } ?>
                    </select></td>
                </tr>
                 <tr><td class="title">Số lượng: </td></tr>
                
                 <tr>

                    <td id="category">
                        <select class="btn" name="hang_sk[<?php echo $i; ?>][order_sl]">    
                        <?php for ($j=1; $j < 20; $j++) { ?>
                                    
                      <option <?php if($j==1) { ?> selected="selected" <?php }; ?> value="<?php echo $j; ?>"><?php echo $j; ?></option>
                        <?php }; ?>
                    </select></td>
                </tr>
                <?php      } ?>
                    <tr><td class="title">Phí Ship: </td></tr>

                <tr>  
                    <td id="category">
                        <select class="btn" name="phiship">                      
                            <option selected="selected" value="0">Miễn Phí</option>
                            <option value="15000">15.000 VNĐ</option>
                            <option value="30000">30.000 VNĐ</option>   
                            <option value="50000">50.000 VNĐ</option>                     
                        </select>
                    </td>

                </tr>               
                <tr><td class="title">Địa chỉ giao hàng:</td></tr>

                <tr>

                    <td><?php echo form_input(array('name' => 'address', 'size' => '50', 'maxlength' => '255','style' => 'width:560px;')); ?></td>

                </tr>
                

            <tr style="display: none;"><td class="title">Ngày đặt hàng: </td></tr>

                <tr style="display: none;">

                    <td>

                        <?php  echo form_input(array('name' => 'create_time', 'size' => '50','maxlength' => '10', 'value' => $created_date)); ?>

                    </td>

                </tr>            


           
                <tr><td class="title">Khách hàng chọn hình thức thanh toán: </td></tr>

                <tr>  
                    <td id="category">
                        <select class="btn" name="kind_pay">                      
                            <option selected="selected" value="1">Thanh toán khi nhận hàng</option>
                            <option value="2">Thanh toán chuyển khoản ngân hàng</option>
                            <option value="3">Thanh toán tại cửa hàng</option>                        
                        </select>
                    </td>

                </tr>
                <tr><td class="title">Nguồn KH Orders: </td></tr>

                <tr>  
                    <td id="category">
                        <select class="btn" name="source_order">                      
                            <option selected="selected" value="1">SEO</option>
                            <option value="2">Facebook ADS</option>
                            <option value="3">Google Adwords</option>                        
                        </select>
                    </td>

                </tr>

                <tr><td class="title">Tình trạng hóa đơn: </td></tr>

                <tr>

                    <td id="category"><?php if(isset($combo_order)) echo $combo_order;?></td>

                </tr>
               
            <tr><td class="title">Ghi Chú: </td></tr>

                <tr>

                    <td>
                        <?php  echo form_textarea(array('name' => 'ghichu','rows' => '5', 'cols'   => '20','style' => 'width:560px;')); ?>
                    </td>

                </tr> 
            <tr ><td class="title">Nhắc Lịch Chăm Sóc: </td></tr>

                <tr>

                    <td>
                        <?php // echo form_input(array('id' => 'nhaclich','name' => 'nhaclich','class' => 'hasDatepicker','style' => 'width:560px;')); ?>
                        <?php echo form_input(array('id' => 'nhacnho', 'name' => 'nhacnho', 'size' => '50', 'maxlength' => '10', 'value' => '', 'style'=>'width: 125px;')); ?>
                    </td>

                </tr> 

            </table>

        
          

    <div style="margin-top: 10px;"></div>

    <?php echo form_submit(array('name' => 'addsubmit', 'value' =>'Thêm Đơn Hàng Mới', 'class' => 'btn')); ?>

    <br class="clear"/>&nbsp;

</div>

<?php echo form_close(); ?>

