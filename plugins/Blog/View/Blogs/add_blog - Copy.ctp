<?php 
	$this->Cms->autoCompileLess(ROOT.DS.APP_DIR.DS.'webroot'.DS.'less_'.$locale. DS .'index.less', ROOT.DS.APP_DIR.DS.'webroot'.DS.'css'.DS.'index_'.$locale.'.css');
	
	echo $this->Html->css('index_'.$locale);
	 
 ?>
<div class="clear" style="margin-top: 10px"></div>
<br />
 
<section id="homePage">
    
	<div class="col-md-9 col-sm-9" >
		 
		<div id="w" class="clearfix">
			    <ul id="sidemenu">
			      <li>
			        <div title="#home-content"  class="nav" >
					 <span class="bl_ax">
					 	<img src="<?php echo __SITE_URL.'img/new_blog.png' ?>" />
					 </span>
					 <span class="blog_title">
					 	کدام مهم تر است صنعت یا صنایع وابسته؟
					 </span>
					 <span class="blog_date">
					 	<?php echo '2014-05-16 14:49:57'; ?>
					 </span>
					</div>
			      </li>

			      <li>
			        <div title="#about-content" class="nav open">
					 <span class="bl_ax">
					 	<img src="<?php echo __SITE_URL.'img/new_blog.png' ?>" />
					 </span>
					 <span class="blog_title">
					 	کدام مهم تر است صنعت یا صنایع وابسته؟
					 </span>
					 <span class="blog_date">
					 	<?php echo '2014-05-16 14:49:57'; ?>
					 </span>
					</div>
			      </li>
				  
			    </ul>
			    
			    <div id="content">
			        <div id="home-content" class="contentblock hidden">
			          home
			        </div>

			        <div id="about-content" class="contentblock">
						about-content
			        </div>		       
			    </div>
			  </div>
		                         
    </div>
	
 <aside class="col-md-3">
	<aside class="dataBox">
		
	</aside>
 </aside>
 
 
</section>
<script>
	$(function(){
  $('#sidemenu .nav').on('click', function(e){
    e.preventDefault();

    if($(this).hasClass('open')) {
      // do nothing because the link is already open
    } else {
      var oldcontent = $('#sidemenu .nav.open').attr('title');
      var newcontent = $(this).attr('title');
      
      $(oldcontent).fadeOut('fast', function(){
        $(newcontent).fadeIn().removeClass('hidden');
        $(oldcontent).addClass('hidden');
      });
      
     
      $('#sidemenu .nav').removeClass('open');
      $(this).addClass('open');
    }
  });
}); 
</script> 