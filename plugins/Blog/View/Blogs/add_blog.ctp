<?php 
	$this->Cms->autoCompileLess(ROOT.DS.APP_DIR.DS.'webroot'.DS.'less_'.$locale. DS .'index.less', ROOT.DS.APP_DIR.DS.'webroot'.DS.'css'.DS.'index_'.$locale.'.css');
	
	echo $this->Html->css('index_'.$locale);
	
	echo $this->Html->script('jquery.cropit');
    echo $this->Html->script('jquery.form');
    echo $this->Html->script('niceditor/nicEdit');
	echo $this->Html->script('sumoselect/jquery.sumoselect.min');
	echo $this->Html->css('/js/sumoselect/sumoselect');
	
	//print_r($blogs);
	 
 ?>
<div class="clear" style="margin-top: 10px"></div>
<br />
 
<section id="homePage">
    
	<div class="col-md-9 col-sm-9" >
		 
		<div id="w" class="clearfix">
			    <ul id="sidemenu">
				
			      
				  
					
					
			      
				  
			    </ul>
			    
			    <div id="content">
						       
			    </div>
		</div>
		                         
    </div>
	
 <aside class="col-md-3">
	<?php echo $this->element('left_blog'); ?>	
 </aside>
 
 
</section>
<script>

  
  
  function load_blog(id){
  	
		$('body').prepend("<div id='modal'></div>");
		$("#modal").html('<div class="loadingPage"><div class="loaderCycle"></div><span>'+_loading+'</span></div>' );
		$.ajax({
			type:"POST",
			url:_url+'blogs/load_blog_form/'+id,
			data:'id='+id,	
			success:function(response){
				$('#content').html(response);		
				remove_modal();  
			}
		}) ;
  }
  
  function load_blog_tab(blog_id){
  	
		$.ajax({
			type:"POST",
			url:_url+'blogs/load_blog_tab/'+blog_id,
			data:'blog_id='+blog_id,	
			success:function(response){
				$('#sidemenu').html(response);		
			}
		}) ;
  }
  
  
  load_blog('<?php echo $blog_id; ?>');
  load_blog_tab('<?php echo $blog_id; ?>');
  

</script> 