 
<?php
	
  
echo "<rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom'>\n";
echo "<channel>\n";

echo "<title>Demo RSS Feed</title>\n";
echo "<description>RSS Description</description>\n";
echo "<link>http://www.mydomain.com</link>\n";

 
$stmt = $conn->query('SELECT * FROM news ORDER BY newsDate DESC LIMIT 10');
foreach ($blogs as $blog) {
    $blogTime = strtotime($blog['Blog']['created']);

    $blogLink = array(
        'controller' => 'blogs',
		'plugin' =>'blog',
        'action' => 'view',
         $blog['Blog']['id']
    );

    // Remove & escape any HTML to make sure the feed content will validate.
    $bodyText = h(strip_tags($blog['Blog']['little_detail']));
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));
     echo "<item>n";
         echo "<title>".$blog['Blog']['title']."</title>\n";
         echo "<description>".$bodyText."</description>\n";
         echo "<pubDate>".date('D, d M Y H:i:s',$blogTime." GMT</pubDate>\n";
         echo "<link>".$blogLink."</link>\n";
         echo "<guid>".$blogLink."</guid>\n";
         echo "<atom:link href='".$blogLink."' rel='self' type='application/rss+xml'/>\n"
     echo "</item>\n";

}

echo "</channel>\n";
echo "</rss>\n";

	
?>