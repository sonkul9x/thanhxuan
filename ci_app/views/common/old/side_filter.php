<input type="hidden" value="<?php echo current_url(); ?>" name="redirect_url">
<div class="sidebox sidefilter">
    
    <div class="filter filters">
        <?php if(!empty($total_row)){ ?>
        <p><strong>Tổng số: </strong><?php echo $total_row; ?> sản phẩm</p>
        <?php } ?>
        <?php if(!empty($price)){ ?>
        <?php 
            $price_start_string = ($price_start>0) ? get_price_in_vnd($price_start) . ' ₫' : '0 ₫';
            $price_end_string = ($price_end>0) ? get_price_in_vnd($price_end) . ' ₫' : 'lớn hơn';
        ?>
        <p><strong>Giá: </strong><?php echo $price_start_string . ' - ' . $price_end_string; ?><a onclick="filter_clear('price')" title="Xóa"><i class="fa fa-times"></i></a></p>
        <?php } ?>
        <?php if(!empty($size)){ ?>
        <p><strong>Kích cỡ: </strong><?php echo $size_name; ?><a onclick="filter_clear('size')" title="Xóa"><i class="fa fa-times"></i></a></p>
        <?php } ?> 
        <?php if(!empty($color)){ ?>
        <p><strong>Màu sắc: </strong><?php echo $color_name; ?><a onclick="filter_clear('color')" title="Xóa"><i class="fa fa-times"></i></a></p>
        <?php } ?>
        <?php if(!empty($trademark)){ ?>
        <p><strong>Thương hiệu: </strong><?php echo $trademark_name; ?><a onclick="filter_clear('trademark')" title="Xóa"><i class="fa fa-times"></i></a></p>
        <?php } ?> 
        <?php if(!empty($origin)){ ?>
        <p><strong>Xuất xứ: </strong><?php echo $origin_name; ?><a onclick="filter_clear('origin')" title="Xóa"><i class="fa fa-times"></i></a></p>
        <?php } ?>
        <?php if(!empty($material)){ ?>
        <p><strong>Chất liệu: </strong><?php echo $material_name; ?><a onclick="filter_clear('material')" title="Xóa"><i class="fa fa-times"></i></a></p>
        <?php } ?>
        <?php if(!empty($style)){ ?>
        <p><strong>Kiểu dáng: </strong><?php echo $style_name; ?><a onclick="filter_clear('style')" title="Xóa"><i class="fa fa-times"></i></a></p>
        <?php } ?>
    </div>
    
    <?php if(empty($price)){ ?>
    <div class="filter">
        <h4>Giá</h4>
        <ol>
            <li><a onclick="filter_add('price','0-500000')">0 ₫ - 500.000 ₫</a></li>
            <li><a onclick="filter_add('price','500000-750000')">500.000 ₫ - 750.000 ₫</a></li>
            <li><a onclick="filter_add('price','750000-1000000')">750.000 ₫ - 1.000.000 ₫</a></li>
            <li><a onclick="filter_add('price','1000000-2000000')">1.000.000 ₫ - 2.000.000 ₫</a></li>
            <li><a onclick="filter_add('price','2000000-')">2.000.000 ₫ - lớn hơn</a></li>
        </ol>
    </div>
    <?php } ?>
    <?php if(empty($size)){ ?>
    <div class="filter">
        <h4>Kích cỡ</h4>
        <?php $size_list = Modules::run('products/get_products_filter',array('attr'=>'size','group_by'=>'size','cat_id'=>!empty($category_id)?$category_id:NULL,'is_string_size'=>TRUE)); ?>
        <?php if(!empty($size_list)){ ?>
        <ol>
            <?php foreach($size_list as $key => $value){ ?>
            <li><a onclick="filter_add('size','<?php echo $key; ?>')"><?php echo $value; ?></a></li>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if(empty($color)){ ?>
    <div class="filter">
        <h4>Màu sắc</h4>
        <?php $color_list = Modules::run('products/get_products_filter',array('attr'=>'color','group_by'=>'colors','cat_id'=>!empty($category_id)?$category_id:NULL,'is_string_color'=>TRUE)); ?>
        <?php if(!empty($color_list)){ ?>
        <ol>
            <?php foreach($color_list as $key => $value){ ?>
            <li><a onclick="filter_add('color','<?php echo $key; ?>')"><?php echo $value; ?></a></li>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if(empty($trademark)){ ?>
    <div class="filter">
        <h4>Thương hiệu</h4>
        <?php $trademark_list = Modules::run('products/get_products_filter',array('attr'=>'trademark','group_by'=>'trademark_id','cat_id'=>!empty($category_id)?$category_id:NULL)); ?>
        <?php if(!empty($trademark_list)){ ?>
        <ol>
            <?php foreach($trademark_list as $key => $value){ ?>
            <li><a onclick="filter_add('trademark','<?php echo $value->trademark_id; ?>')"><?php echo $value->trademark_name; ?></a></li>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if(empty($origin)){ ?>
    <div class="filter">
        <h4>Xuất xứ</h4>
        <?php $origin_list = Modules::run('products/get_products_filter',array('attr'=>'origin','group_by'=>'origin_id','cat_id'=>!empty($category_id)?$category_id:NULL)); ?>
        <?php if(!empty($origin_list)){ ?>
        <ol>
            <?php foreach($origin_list as $key => $value){ ?>
            <li><a onclick="filter_add('origin','<?php echo $value->origin_id; ?>')"><?php echo $value->origin_name; ?></a></li>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if(empty($material)){ ?>
    <div class="filter">
        <h4>Chất liệu</h4>
        <?php $material_list = Modules::run('products/get_products_filter',array('attr'=>'material','group_by'=>'material_id','cat_id'=>!empty($category_id)?$category_id:NULL)); ?>
        <?php if(!empty($material_list)){ ?>
        <ol>
            <?php foreach($material_list as $key => $value){ ?>
            <li><a onclick="filter_add('material','<?php echo $value->material_id; ?>')"><?php echo $value->material_name; ?></a></li>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if(empty($style)){ ?>
    <div class="filter">
        <h4>Kiểu dáng</h4>
        <?php $style_list = Modules::run('products/get_products_filter',array('attr'=>'style','group_by'=>'style_id','cat_id'=>!empty($category_id)?$category_id:NULL)); ?>
        <?php if(!empty($style_list)){ ?>
        <ol>
            <?php foreach($style_list as $key => $value){ ?>
            <li><a onclick="filter_add('style','<?php echo $value->style_id; ?>')"><?php echo $value->style_name; ?></a></li>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
    <?php } ?>
</div>