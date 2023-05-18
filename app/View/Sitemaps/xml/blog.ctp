<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
	
	
    <!-- blogs-->    
    <?php foreach ($blogs as $blog):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'blogs','action'=>'view',$blog['Blog']['id'].'/'.$blog['Blog']['title']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo $blog['0']['dt'] ; ?></lastmod>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
</urlset> 