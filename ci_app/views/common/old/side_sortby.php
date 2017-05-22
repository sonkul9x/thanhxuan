<input type="hidden" value="<?php echo current_url(); ?>" name="redirect_url">
<select name="sortby" onchange="javascript:sort_by();" class="form-control sortby">
    <option value="" <?php if($sortby_value==''){ ?>selected="selected"<?php } ?>>Sắp xếp theo mặc định</option>
    <option value="price_asc" <?php if($sortby_value=='price_asc'){ ?>selected="selected"<?php } ?>>Sắp xếp theo giá tăng dần</option>
    <option value="price_desc" <?php if($sortby_value=='price_desc'){ ?>selected="selected"<?php } ?>>Sắp xếp theo giá giảm dần</option>
</select>