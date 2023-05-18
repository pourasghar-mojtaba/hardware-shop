
<?php 
	echo $this->Html->css('blog_'.$locale);
	echo $this->Html->script('blog'); 
	 $User_Info= $this->Session->read('User_Info');
	 
?>

<script>

var count=0;
add_search(0,'<?php echo $year;?>','<?php echo $month;?>','<?php echo $writer;?>','<?php echo $search_text; ?>','<?php echo $tag; ?>');
$(window).scroll(function(){  
		if  ($(window).scrollTop() == $(document).height() - $(window).height()){    
		   count++; 
		   add_search(count,'<?php echo $year;?>','<?php echo $month;?>','<?php echo $writer;?>','<?php echo $search_text; ?>','<?php echo $tag; ?>');
		}  
}); 
</script>
	
<div id="content">

<?php echo $this->element('Blogs/blog_head'); ?>
<div class="posts">  
 <div id="blog_searchbody"></div><div id="blog_searchloading"></div>
   	
</div>
<?php echo $this->element('Blogs/search'); ?>

    </div>