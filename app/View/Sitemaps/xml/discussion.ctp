<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
	
	
	
	<!-- discussions -->    
    <?php foreach ($categorydiscussions as $categorydiscussion):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'discussions','action'=>'dislist',$categorydiscussion['Categorydiscussion']['id']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo  $categorydiscussion['0']['dt']; ?></lastmod>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
	
	<?php foreach ($discussions as $discussion):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'discussions','action'=>'view',$discussion['Discussion']['id']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo  $discussion['0']['dt']; ?></lastmod>
        <priority>0.75</priority>
    </url>
    <?php endforeach; ?>
	
   
</urlset> 