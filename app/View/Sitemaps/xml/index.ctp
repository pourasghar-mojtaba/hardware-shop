<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
	
	<!-- urls -->    	 
	
	
	 
	<url>
        <loc><?php echo __SITE_URL."blog/blogs/last" ?></loc>
		<changefreq>daily</changefreq>
        <lastmod> <?php echo date('Y-m-d'); ?></lastmod>
        <priority>0.85</priority>
    </url>
	
	 <?php foreach ($project_categories as $project_category):?>
	<url>
        <loc><?php echo __SITE_URL."project/projects/index/".$project_category['slug']; ?></loc>
		<changefreq>daily</changefreq>
        <lastmod> <?php echo date('Y-m-d'); ?></lastmod>
        <priority>0.85</priority>
    </url>
	<?php endforeach; ?>
	
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
		 
	<!-- blogs-->    
    <?php foreach ($blogs as $blog):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'blogs','action'=>'view',$blog['Blog']['id']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo $blog['0']['dt'] ; ?></lastmod>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
	
	<!-- projects-->    
    <?php foreach ($projects as $project):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'projects','action'=>'view',$project['Project']['id']),true); ?></loc>
		<changefreq>daily</changefreq>
        <lastmod><?php echo $project['0']['dt'] ; ?></lastmod>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>

</urlset> 