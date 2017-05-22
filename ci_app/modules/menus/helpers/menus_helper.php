<?php

function print_list_menu($params = array(), $is_child = false){
    $srt_list = '';
    $srt_list = $is_child ? '<ul class="childs" >' :'<ul>';
    if(isset($params) && sizeof($params) > 0){
        foreach($params as $key => $value){
            $srt_list .= '<li><a href="#">'.$value['caption'].'</a>';
            if(isset($value['childs']) && count($value['childs']) > 0){
                $srt_list .= print_list_menu($value['childs'], true);
            }
            $srt_list .= '</li>';
        }
    }
    $srt_list .= '</ul>';
    return $srt_list;
}

?>
