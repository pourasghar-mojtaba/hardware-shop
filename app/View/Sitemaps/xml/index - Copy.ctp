<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
	
	<!-- urls -->    	 
	
	<url>
        <loc><?php echo __SITE_URL."product/products/search" ?></loc>
		<changefreq>daily</changefreq>
        <lastmod> <?php echo date('Y-m-d'); ?></lastmod>
        <priority>0.85</priority>
    </url>
	 
	<url>
        <loc><?php echo __SITE_URL."blog/blogs/last" ?></loc>
		<changefreq>daily</changefreq>
        <lastmod> <?php echo date('Y-m-d'); ?></lastmod>
        <priority>0.85</priority>
    </url>
	
	<url>
        <loc><?php echo __SITE_URL."pages/about" ?></loc>
		<changefreq>daily</changefreq>
        <lastmod> <?php echo date('Y-m-d'); ?></lastmod>
        <priority>0.85</priority>
    </url>
	
	<url>
        <loc><?php echo __SITE_URL."pages/contact_us" ?></loc>
		<changefreq>daily</changefreq>
        <lastmod> <?php echo date('Y-m-d'); ?></lastmod>
        <priority>0.85</priority>
    </url>
	
    <!-- static pages -->    
    <?php foreach ($pages as $page):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'pages','action'=>'view',$page['Page']['id']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo  $page['0']['dt']; ?></lastmod>
        <priority>0.85</priority>
    </url>
    <?php endforeach; ?>
		 
	<!-- blogs-->    
    <?php foreach ($blogs as $blog):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'blogs','action'=>'view',$blog['Blog']['id'].'/'.$blog['Blog']['title']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo $blog['0']['dt'] ; ?></lastmod>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
	
	<!-- products-->    
    <?php foreach ($products as $product):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'products','action'=>'view',$product['Product']['id'].'/'.$product['Product']['title']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo $product['0']['dt'] ; ?></lastmod>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>

</urlset> 