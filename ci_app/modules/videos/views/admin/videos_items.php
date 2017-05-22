<?php 
if(isset($items)){

foreach($items as $index => $row)
{
    $images_url     = $row->image_name;
    $id             = $row->id;
    $caption        = is_null($row->caption) ? '' : $row->caption;
    $content        = is_null($row->content) ? '' : $row->content;
    echo <<< eob
            <div class="t-wrapper" id="id_{$id}">
            <div class="t-square">
                <span>
                    <a class="delete_me close" href="javascript:void(0);" onclick="delete_videos_items({$id})"><em>&nbsp;</em></a>
                </span>
                <div class="t-img">
                    <em style="background-size:130px; background-image: url('{$images_url}');"></em>
                </div>
                <div class="t-caption">
                    <span>Nhập tiêu đề</span>
                    <input id="caption_{$id}" value="{$caption}" type="text" onchange="add_caption_videos_items({$id})" />
                </div>
            </div>
        </div>
eob;
}
echo '<br style="clear:both;"/>';
}
?>