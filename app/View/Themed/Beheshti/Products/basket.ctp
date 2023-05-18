
<div class="inner-head overlap">
	<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2>سبد خرید</h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
				<li><a href="#" title="">سبد خرید</a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->
<?php echo $this->Session->flash(); ?>
<div id="basket_place">
</div>
<div id="loading"></div>


<script>

	function delete_basket_product(obj,id){

		if (confirm('<?php echo __('r_u_sure'); ?>')){

			$(obj).attr('disabled','disabled');

			$.ajax({
				type:"POST",
				url:_url+'products/delete_from_basket',
				data:'product_id='+id,
				dataType: "json",
				success:function(response){
					// hide table row on success
					if(response.success == true) {
						//$(obj).parent().parent().fadeOut(function(){$(this).remove()});
						$('#basket_place').html('');
						if(response.count==0){
							window.location.href = '<?php echo __SITE_URL.'products'; ?>';
						}
						else{
							refresh_basket_preview(id);
						}
					}
					else
					 {
						if( response.message ) {
							show_message('error',_error_title,response.message,_yes);
						}
					 }
					 $(obj).removeAttr('disabled');
				}
			});

		}
	}

	function refresh_basket_preview(id){

		$('#basket_place').html('');
		$("#loading").html('<img src="'+_url+'/<?php echo __SITE_URL.__THEME_PATH;?>img/loader/loader.gif" >');
			$.ajax({
				type:"POST",
				url:_url+'products/refresh_basket_preview',
				data:'product_id='+id,
				success:function(response){
					$('#basket_place').html(response);
					$("#loading").html('');
				}
			});
	}



</script>
