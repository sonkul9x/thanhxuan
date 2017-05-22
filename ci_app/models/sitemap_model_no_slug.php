<?php 
/*
 * fixed 03/2014 by Dungnm 
 */
class Sitemap_Model extends CI_Model
{
    function  __construct()
    {
        parent::__construct();
    }
    
    private function _generate_pages($number_of_post=10000)
    {
        $today  = date('Y-m-d');
        $output = '';
        $query = $this->db->select('pages.id, pages.title, pages.uri, pages.summary, pages.lang, slug.slug slug, slug.id slug_id')
                            ->join('slug', 'slug.type_id = pages.id AND ' . $this->db->dbprefix . 'slug.type = '.SLUG_TYPE_PAGES, 'left')
                            ->where('pages.status', STATUS_ACTIVE)
                            ->limit($number_of_post) // gioi han chi lay xxx ban ghi moi nhat
                            ->get('pages');
        $data  = $query->result();
        foreach($data as $value)
        {
            $loc = get_base_url($value->lang);
            $loc .= trim($value->uri);
//            $loc .= $value->slug;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>weekly</changefreq>
</url>

EOB;
        }

        return $output;
    }
	
    /**
     * Tao ra danh sach ? posts news moi nhat
     */
    private function _generate_latest_news($number_of_post=10000)
    {
        $today  = date('Y-m-d');
        $output = '';
        $query =
        $this->db->select('news.id, news.title, news.cat_id, news.summary, news.lang, news_categories.category')
                            ->join('news_categories', 'news.cat_id = news_categories.id', 'left')
                            ->where('news.status', STATUS_ACTIVE)
                            ->limit($number_of_post) // gioi han chi lay xxx ban ghi moi nhat
                            ->order_by('news.updated_date', 'DESC')
                            ->get('news');
        $news  = $query->result();
        foreach($news as $new)
        {
            $loc = get_base_url($new->lang);
            $loc .= url_title(trim($new->title), 'dash', TRUE) . '-ns' . $new->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>weekly</changefreq>
</url>

EOB;
        }

        return $output;
    }
    
    private function _generate_categories_subs_news()
    {
        $today  = date('Y-m-d');
        $output = '';
        $query = $this->db->get('news_categories');
        $categories = $query->result();

        foreach($categories as $category)
        {
            $loc = get_base_url($category->lang). url_title($category->category, 'dash', TRUE) . '-n' . $category->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>daily</changefreq>
</url>

EOB;
        }
        return $output;
    }
    
    private function _generate_latest_faq($number_of_post=10000)
    {
        $today  = date('Y-m-d');
        $output = '';
        $query =
        $this->db->select('faq.id, faq.title, faq.cat_id, faq.summary, faq.lang, faq_categories.category')
                            ->join('faq_categories', 'faq.cat_id = faq_categories.id', 'left')
                            ->where('faq.status', STATUS_ACTIVE)
                            ->limit($number_of_post) // gioi han chi lay xxx ban ghi moi nhat
                            ->order_by('faq.updated_date', 'DESC')
                            ->get('faq');
        $faqs  = $query->result();
        foreach($faqs as $faq)
        {
            $loc = get_base_url($faq->lang);
            $loc .= url_title(trim($faq->title), 'dash', TRUE) . '-qs' . $faq->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>weekly</changefreq>
</url>

EOB;
        }

        return $output;
    }
    
    private function _generate_categories_subs_faq()
    {
        $today  = date('Y-m-d');
        $output = '';
        $query = $this->db->get('faq_categories');
        $categories = $query->result();

        foreach($categories as $category)
        {
            $loc = get_base_url($category->lang). url_title($category->category, 'dash', TRUE) . '-q' . $category->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>daily</changefreq>
</url>

EOB;
        }
        return $output;
    }

    /**
     * Tao ra danh sach 50 posts products moi nhat
     */
    private function _generate_latest_posts($number_of_post=10000)
    {
        $today  = date('Y-m-d');
        $output = '';
        $con1 = '(('.$this->db->dbprefix.'product_images.position=1) OR ('.$this->db->dbprefix.'product_images.image_name <> NULL))';
        $query =
        $this->db->select('products.id, products.product_name, products.categories_id, products_categories.category, product_images.position, product_images.image_name, products.lang')
                            ->join('products_categories', 'products.categories_id = products_categories.id', 'left')
                            ->join('product_images', 'products.id = product_images.products_id', 'left')
                            ->where('products.status', STATUS_ACTIVE)
                            //->where('((product_images.position=1) OR (product_images.image_name <> NULL))')
                            ->where($con1)
                            ->limit($number_of_post) // gioi han chi lay 200 ban ghi moi nhat
                            ->order_by('products.updated_date', 'DESC')
                            ->get('products');
        $products  = $query->result();
        foreach($products as $product)
        {
            $loc = get_base_url($product->lang);
            $loc .= url_title(trim($product->product_name), 'dash', TRUE) . '-ps' . $product->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>weekly</changefreq>
</url>

EOB;
        }
        return $output;
    }

    private function _generate_categories_subs()
    {
        $today  = date('Y-m-d');
        $output = '';
        $query = $this->db->get('products_categories');
        $categories = $query->result();

        foreach($categories as $category)
        {
            $loc = get_base_url($category->lang). url_title($category->category, 'dash', TRUE) . '-p' . $category->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>daily</changefreq>
</url>

EOB;
        }
        return $output;
    }

    function generate_sitemap()
    {
        $output = '';
        $today = date('Y-m-d');
        $domain = base_url();
        $output = <<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
    <loc>{$domain}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>daily</changefreq>
</url>
EOB;
        $output .= $this->_generate_pages();
		
        $output .= $this->_generate_categories_subs_news();
        $output .= $this->_generate_latest_news();
        
        $output .= $this->_generate_categories_subs_faq();
        $output .= $this->_generate_latest_faq();
        
        $output .= $this->_generate_categories_subs();
        $output .= $this->_generate_latest_posts();
        
        $output .= '</urlset>';

        return $output;
    }

}
?>