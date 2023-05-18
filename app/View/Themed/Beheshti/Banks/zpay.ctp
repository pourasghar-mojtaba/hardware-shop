<?php
	//echo "mojtaba";
	echo $this->Html->css('/getway/css/getway');
	echo $this->Html->css('profile');
?>	
<div class="pageContainer container-fluid" style="padding-bottom: 0px;">
    <?php echo $this->element('header'); ?> 
    <div class="clear"></div>
    
    <div class="midContent">
    	
		<div class="col-md-12 shop"> 
		   
		   
		   		   
		   <div class="col-md-12">
		      <?php echo $this->Session->flash(); ?>
		        <section id="hp-ssod">
		            <div class="shadow_box col-sm-3 settingForms col-md-offset-4" style="margin-top: 50px;margin-bottom:50px;" >
					
					
						 <div class="settingContent">
						 	<div  style="margin-top: 10px;padding: 25">
						         
								 <img style="float: right;margin-bottom: 20px" width="64" src="<?php echo __SITE_URL; ?>img/loader/loader.gif" >	
								 <div style="margin-top: 20px;margin-right: 10px;float: right;">درحال اتصال به درگاه</div>	
						    </div>
							 			
						 </div>
 
 					</div>
		        </section>
		   </div> 
		   <div class="clear"></div> 
		         	
        </div>
		
    </div>
</div>
 
 
<script>
	document.location.href = '<?php echo $back_url; ?>';
</script>
    