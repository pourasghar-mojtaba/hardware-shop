
<?php 
	echo $this->Html->css('blog_'.$locale);
	echo $this->Html->script('blog'); 
	 $User_Info= $this->Session->read('User_Info');
?>

<script>

var count=0;
	refresh_tag(0,<?php echo $tag_id; ?>);
$(window).scroll(function(){  
		if  ($(window).scrollTop() == $(document).height() - $(window).height()){    
		   count++; 
		   refresh_tag(count,<?php echo $tag_id; ?>);
		}  
}); 
</script>
	
<div id="content">

<?php echo $this->element('Blogs/blog_head'); ?>
<div class="posts">  
 <div id="blog_tagbody"></div><div id="blog_tagloading"></div>
   	
</div>
<?php echo $this->element('Blogs/search'); ?>

    </div>