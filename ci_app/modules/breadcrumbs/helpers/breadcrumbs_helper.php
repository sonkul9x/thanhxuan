<?php
/**
 * @author : dzung.tt
 * @date : 15-5-2012
 */

/*
 * param có dang 
 *              array(
 *                  0 => array( 
 *                          'uri' => 'linkden trang', 
 *                          'name' => 'text hienthi'
 *                      ) 
 *              )
 */

function _print_breadcrumbs_links($param = array(), $revert = false) {
    $srt = '';
    if ($param && is_array($param) && count($param) > 0) {
        $i = 0;
        foreach ($param as $key => $value) {
            $gt = '»';
            if ($revert) {
                if($i = 0)
                    $gt  = '';
                $srt .= ((isset($value['uri']) && $value['uri'] != '') 
                        ? '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"> ' . $gt . ' <a itemprop="url" href="' . $value['uri'] . '"><span itemprop="title">' . $value['name'] . '</span></a></li>' 
                        : '<li> ' . $gt . ' ' . $value['name'].'</li>');
            } else {
                if( $i == count($param) - 1)
                    $gt  = '';
                $srt = ((isset($value['uri']) && $value['uri'] != '') 
                        ? '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"> ' . $gt . ' <a itemprop="url" href="' . $value['uri'] . '"><span itemprop="title">' . $value['name'] . '</span></a></li>' 
                        : '<li> ' . $gt . ' ' . $value['name'] . '</li>') . $srt;
            }
            $i++;
        }
    }
    return $srt;
}

?>
