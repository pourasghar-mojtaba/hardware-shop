<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
	
	
    <!-- posts-->    
    <?php foreach ($posts as $post):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'posts','action'=>'view',$post['Post']['id']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo $post['0']['dt'] ; ?></lastmod>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
</urlset> 