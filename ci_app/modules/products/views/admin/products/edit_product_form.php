<?php 

echo form_open_multipart($submit_uri); 

if (isset($product_id)) echo form_hidden('id', $product_id);

echo form_hidden('is_add_edit_category', TRUE);

echo form_hidden('form', 'products_cat');

?>



<div class="page_header">

    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>

    <small class="fleft">"Thay đổi thông tin về sản phẩm"</small>

    <span class="fright">

        <a class="button close" href="<?php echo PRODUCTS_ADMIN_BASE_URL;?>"><em>&nbsp;</em>Đóng</a>

    </span>

    <br class="clear"/>

</div>



<div id="sort_success">Vị trí ảnh đã được cập nhật</div>

<div class="form_content">

    <?php $this->load->view('powercms/message'); ?>

    <ul class="tabs">

            <li><a href="#tab1">Ảnh sản phẩm</a></li>

            <li><a href="#tab2">Nội dung</a></li>

            <li><a href="#tab3">Meta data</a></li>

    </ul>

    <div class="tab_container">

        <div id="tab1" class="tab_content">

            <div style="margin-top: 10px;">

                <input id="file_upload" name="file_upload" type="file" />

            </div>

            <input id="session_upload" name="session_upload" type="hidden" value="<?php echo session_id(); ?>" />

            <input id="process_url" name="process_url" type="hidden" value="/upload_products_images" />

            <i>(Ảnh 400x400. Định dạng jpg, jpeg, png. Dung lượng nhỏ hơn 1Mb. Tên ảnh và tên thư mục không dấu)</i><br />

            <br class="clear-both"/>

            <div id="products_images">

                <ul>

                    <?php if(isset($images)) echo $images;?>

                </ul>

            </div>

        </div>

        

        <div id="tab2" class="tab_content">

            <table>

                <tr class="display_status_block"><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>

                <tr class="display_status_block"><td><?php if(isset($lang_combobox)) echo $lang_combobox;?></td></tr>

                

                <tr><td class="title">Tên sản phẩm: (<span>*</span>)</td></tr>

                <tr><td><?php echo form_input(array('name' => 'product_name', 'size' => '30', 'maxlength' => '255', 'style' => 'width:560px;', 'onkeyup'=>'convert_to_slug(this.value);', 'value' => isset ($product_name) ? $product_name : set_value('product_name'))); ?></td></tr>

                

                <?php if(SLUG_ACTIVE>0){ ?>

                <tr><td class="title">Slug (vd: ten-san-pham): (<span>*</span>)</td></tr>

                <tr>

                    <td><?php echo form_input(array('name' => 'slug', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($slug) ? $slug : set_value('slug'))); ?></td>

                </tr>

                <?php } ?>

                

                <tr><td class="title">Phân loại: (<span>*</span>)</td></tr>

                <tr><td id="category"><?php if($categories){echo $categories;} ?></td></tr>

                

                <<!-- tr><td class="title">Xuất xứ: (<span>*</span>)</td></tr>

                <tr><td id="category"><?php //if($products_origin){echo $products_origin;} ?></td></tr> -->

                

            <!--     <tr><td class="title">Thương hiệu: (<span>*</span>)</td></tr>

                <tr><td id="category"><?php //if($products_trademark){echo $products_trademark;} ?></td></tr> -->

                                

                <tr><td class="title">Màu sắc: (<span>*</span>)</td></tr>

                <tr><td id="category"><?php if($products_color){echo $products_color;} ?></td></tr>

                <tr><td class="hint">Ấn giữ phím Ctrl để click chọn nhiều màu.</td></tr>

                

                <tr><td class="title">Kích cỡ: (<span>*</span>)</td></tr>

                <tr><td id="category"><?php if($products_size){echo $products_size;} ?></td></tr>

                <tr><td class="hint">Ấn giữ phím Ctrl để click chọn nhiều cỡ.</td></tr>

                

              <!--   <tr><td class="title">Chất liệu: (<span>*</span>)</td></tr>

                <tr><td id="category"><?php //if($products_material){echo $products_material;} ?></td></tr>
 -->
                

               <!--  <tr><td class="title">Kiểu dáng: (<span>*</span>)</td></tr>

                <tr><td id="category"><?php //if($products_style){echo $products_style;} ?></td></tr> -->

                 

                <tr><td class="title">Tình trạng sản phẩm: </td></tr>

                <tr><td id="category"><?php if($products_state){echo $products_state;} ?></td></tr>

            

<!--                <tr><td class="title">Sản phẩm nổi bật: </td></tr>

                <tr><td><?php // if(isset($typical_product)) echo $typical_product;?></td></tr>-->

                

                <!-- <tr><td class="title">Sản phẩm mới: </td></tr>

                <tr><td><?php //if(isset($new_product)) echo $new_product;?></td></tr>

                

                <tr><td class="title">Sản phẩm bán chạy: </td></tr>

                <tr><td><?php //if(isset($top_sell_product)) echo $top_sell_product;?></td></tr>

                 -->

<!--                <tr><td class="title">Mã sản phẩm: </td></tr>

                <tr><td><?php // echo form_input(array('name' => 'code', 'size' => '30', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => isset ($code) ? $code : set_value('code'))); ?></td></tr>-->

                

                <tr><td class="title">Giá tiền: </td></tr>

                <tr><td>

                    <?php echo form_input(array('name' => 'price', 'size' => '30', 'maxlength' => '10', 'class'=>'number', 'value' => $price)); ?>

                    <?php echo $unit;?>

                    <?php // echo ' / ' . $product_unit;?>

                </td></tr>

                

                <tr><td class="title">Giá cũ: </td></tr>

                <tr><td>

                    <?php echo form_input(array('name' => 'price_old', 'size' => '30', 'maxlength' => '10', 'class'=>'number', 'value' => $price_old)); ?>

                    <?php echo $unit_old;?>

                    <?php // echo ' / ' . $product_unit_old;?>

                </td></tr>

                

                <tr><td class="title">Mô tả ngắn: </td></tr>

                <tr><td><?php echo form_textarea(array('id' => 'summary', 'name' => 'summary','style' => 'width:560px; height: 80px;', 'value' =>  ($summary != '') ? $summary : set_value('summary'))); ?></td></tr>

                

<!--                <tr><td class="title">Thông số kỹ thuật: </td></tr>

                <tr><td><?php // echo form_textarea(array('id' => 'specifications', 'name' => 'specifications', 'value' =>  ($specifications != '') ? $specifications : set_value('specifications'), 'class' => 'wysiwyg elm1')); ?></td></tr>-->

                

                <tr><td class="title">Thông tin sản phẩm: </td></tr>

                <tr><td><?php echo form_textarea(array('id' => 'content', 'name' => 'description', 'value' =>  ($description != '') ? $description : set_value('description'), 'class' => 'wysiwyg elm1')); ?></td></tr>

                

<!--                <tr><td class="title">Thông tin nhà sản xuất: (<span>*</span>)</td></tr>

                <tr><td><?php // echo form_textarea(array('id' => 'manufacturer', 'name' => 'manufacturer', 'value' =>  ($manufacturer != '') ? $manufacturer : set_value('manufacturer'), 'class' => 'wysiwyg elm1')); ?></td></tr>

                -->

                

                

<!--                <tr><td class="title">Link demo: </td></tr>

                <tr><td><?php // echo form_input(array('name' => 'link_demo', 'size' => '30', 'maxlength' => '500', 'style' => 'width:560px;', 'value' => $link_demo)); ?></td></tr>-->

                

            </table>

        </div>

        

        <div id="tab3" class="tab_content">

            <table>

            <tr><td class="title">Meta title: </td></tr>

            <tr>

                <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '255', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>

            </tr>



            <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>

            <tr>

                <td>

                    <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '255', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>

                </td>

            </tr>



            <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>

            <tr>

                <td>

                    <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>

                </td>

            </tr>

            <tr><td class="title">Tags:</td></tr>

            <tr><td><?php echo form_input(array('name' => 'tags', 'size' => '50', 'style' => 'width:560px;', 'value' => $tags)); ?></td></tr>

            <tr><td class="hint">Mỗi tag cách nhau bởi dấu phấy.</td></tr>

        </table>

    </div>

</div>

    <br class="clear">

    <div style="margin-top: 10px;"></div>

    <input type="submit" name="btnSubmit" value="<?php if(isset($button_name)) echo $button_name;?>" class="btn" />

    <input type="reset" value="Làm lại" class="btn" />

    <br class="clear">&nbsp;

</div>

<?php echo form_close(); ?>

