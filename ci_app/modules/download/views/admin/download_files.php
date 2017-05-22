<?php
if(isset($files)){
foreach($files as $index => $row)
{
    $file_title     = is_null($row->name) ? 'Không rõ tên' : $row->name;
    $id             = $row->id;
    echo <<< eob
            <div class="t-wrapper" style="width:auto; margin-right: 10px;" id="id_{$id}">
            <div class="t-square" style="padding:5px;">
                <span>
                    <a title="Xóa" class="delete_me close" href="javascript:void(0);" onclick="delete_file_download($id)"><em>&nbsp;</em></a>
                </span>
                <div class="t-img">
                    <span>{$file_title}</span>
                </div>
            </div>
        </div>
eob;
}
echo '<br style="clear:both;"/>';
}
?>