
<?php 
	echo $this->Html->css('blog_'.$locale);
	echo $this->Html->script('blog'); 
	 $User_Info= $this->Session->read('User_Info');
?>

<script>

var count=0;
	refresh_blog(0);
$(window).scroll(function(){  
		if  ($(window).scrollTop() == $(document).height() - $(window).height()){    
		   count++; 
		   refresh_blog(count);
		}  
}); 
</script>
	


<?php /*echo $this->element('Blogs/blog_head');*/ ?>
<div class="posts">  
 <div id="blog_body"></div><div id="blog_loading"></div>
   	
</div>
<?php echo $this->element('Blogs/search'); ?>

    