<?php
class Slug extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
//        modules::run('auth/auth/validate_permission', array('operation' => OPERATION_MANAGE));
//        modules::run('auth/auth/validate_login');
        // Khoi tao cac bien
        $this->_layout = 'admin_ui/layout/main';
    }
    
    /**
     * Dieu huong cho tung module
     * @param type $para1
     * @param type $para2
     * @param type $para3
     * @param type $para4
     */
    public function get_slug($para1=NULL,$para2=DEFAULT_LANGUAGE,$para3=NULL,$para4=NULL)
    {
        $options = array('slug'=>$para1,'lang'=>switch_language($para2),'page'=>$para3,'html'=>$para4);
        
        if(isset($options['html'])){
            $slug = $this->slug_model->get_slug(array('slug'=>$options['slug'].SLUG_CHARACTER_URL,'onehit'=>TRUE));
            switch($slug->type){
                case SLUG_TYPE_NEWS:
                    echo modules::run('news/get_news_detail',$slug->type_id,$options['lang']);
                    break;
                case SLUG_TYPE_PRODUCTS:
                    echo modules::run('products/get_products_detail',$slug->type_id,$options['lang']);
                    break;
                case SLUG_TYPE_GALLERY:
                    echo modules::run('gallery/get_gallery_detail',$slug->type_id,$options['lang']);
                    break;
                case SLUG_TYPE_VIDEOS:
                    echo modules::run('videos/get_videos_detail',$slug->type_id,$options['lang']);
                    break;
                case SLUG_TYPE_FAQ:
                    echo modules::run('faq/get_faq_detail',$slug->type_id,$options['lang']);
                    break;
                case SLUG_TYPE_PAGES:
                    echo modules::run('pages/page_detail',$options['lang']);
                    break;
//                case SLUG_TYPE_DOWNLOAD:
//                    break;
            }
        }else{
            $slug = $this->slug_model->get_slug(array('slug'=>$options['slug'],'onehit'=>TRUE));
            switch($slug->type){
                case SLUG_TYPE_NEWS_CATEGORIES:
                    echo modules::run('news/get_list_news_by_cat',$slug->type_id, $options['page'], $options['lang']);
                    break;
                case SLUG_TYPE_PRODUCTS_CATEGORIES:
                    echo modules::run('products/get_list_products_by_cat',$slug->type_id, $options['page'], $options['lang']);
                    break;
                case SLUG_TYPE_GALLERY_CATEGORIES:
                    echo modules::run('gallery/get_list_gallery_by_cat',$slug->type_id, $options['page'], $options['lang']);
                    break;
                case SLUG_TYPE_VIDEOS_CATEGORIES:
                    echo modules::run('videos/get_list_videos_by_cat',$slug->type_id, $options['page'], $options['lang']);
                    break;
                case SLUG_TYPE_FAQ_CATEGORIES:
                    echo modules::run('faq/get_list_faq_by_cat',$slug->type_id, $options['page'], $options['lang']);
                    break;
//                case SLUG_TYPE_PAGES_CATEGORIES:
//                    break;
                case SLUG_TYPE_DOWNLOAD_CATEGORIES:
                    echo modules::run('download/download_list',$slug->type_id, $options['page'], $options['lang']);
                    break;
            }
        }
        
    }
    
}