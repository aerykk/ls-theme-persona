<?
echo '<?xml version="1.0" encoding="UTF-8"?>';

$page_list = Cms_Page::create()
  ->where('is_published=1')
  ->where('navigation_visible=1')
  ->where('security_mode_id <> "customers"')
  ->find_all(); // only published, visible and accessible for guests

$category_list = Shop_Category::create()->find_all();

$product_list = new Shop_Product(
  null, 
  array(
    'no_column_init' => true, 
    'no_validation' => true
  )
); // isn't a necessity, but prevents loading some service objects during loading

$product_list = $product_list->apply_filters()->find_all(); 
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <? foreach($page_list as $page): ?>
  <url>
    <loc><?= site_url($page->url) ?></loc>
    <lastmod><?= str_replace(' ', 'T', $page->updated_at).substr(date('O'), 0, -2) . ':00' ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <? endforeach ?>
  <? foreach($category_list as $category): ?>
  <url>
    <loc><?= site_url($category->page_url('/category')) ?></loc>
    <lastmod><?= str_replace(' ', 'T', $category->updated_at).substr(date('O'), 0, -2) . ':00' ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.3</priority>
  </url>
  <? endforeach ?>
  <? foreach($product_list as $product): ?>
  <url>
    <loc><?= site_url($product->page_url('/product')) ?></loc>
    <lastmod><?= str_replace(' ', 'T', $product->updated_at).substr(date('O'), 0, -2) . ':00' ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
  <? endforeach ?>
</urlset>