
<?php

    echo $this->Html->css('/shop/css/addrow');
	echo $this->Html->css('/css/ListSelector/autocomplete.css'); 
	echo $this->Html->css('/css/ListSelector/ui-lightness/jquery-ui-1.8.custom'); 
	echo $this->Html->script('/js/ListSelector/admin-jquery-ui-custom.min');

?>
 
<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- right menu starts -->
				<?php echo $this->element('Admin/right_menu'); ?>       
			<!-- right menu ends -->
			
			
			<div id="content" class="span10">
			<!-- content starts -->
			

			<div>
				<?php if($this->Session->check('Message.flash')) {?>
				<div>
					  <?php echo $this->Session->flash(); ?>
				</div>
				<?php } ?>
			</div>
			<?php echo $this->Form->create('Product', array('id'=>'AddFrom','name'=>'AddFrom','enctype'=>'multipart/form-data')); ?>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i><?php echo __('add_product') ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal">
						 <table border="0" cellpadding="0" cellspacing="0" align="center" width="99%">
						 	 <tr>
							 	<td colspan="5">
									<label class="control-label" for="focusedInput"><?php echo __('title') ?> :</label>
								  <input class="input-xlarge focused" style="width:500px" value="" name="data[Product][title]" id="focusedInput" type="text" >
								</td>
							 </tr>
                             <tr>
							 	<td colspan="5">
									<label class="control-label" for="focusedInput"><?php echo __('slug') ?> :</label>
								  <input class="input-xlarge focused" style="width:300px" value="" name="data[Product][slug]" id="focusedInput" type="text" >
								</td>
							 </tr>
							 <tr>
							 	<td width="20%">
									<label class="control-label" for="focusedInput"><?php echo __('price') ?> :</label> 
								  <input class="input-xlarge focused" style="width:100px" value="0" name="data[Product][price]" id="focusedInput" type="text" > ريال
								</td>
								<td width="20%">
									<label class="control-label" for="focusedInput"><?php echo __('discount') ?> :</label> 
								  <input class="input-xlarge focused" style="width:30px" value="0" name="data[Product][discount]" id="focusedInput" type="text" maxlength="3"  > درصد
								</td>
								<td width="20%">
									 <label class="control-label" for="focusedInput"><?php echo __('num') ?> :</label> 
								  <input class="input-xlarge focused" style="width:50px" value="0" name="data[Product][num]" id="focusedInput" type="text"  > 
								</td>
								<td width="20%">
									<label class="control-label" for="focusedInput"><?php echo __('weight') ?> :</label> 
								  <input class="input-xlarge focused" style="width:50px" value="0" name="data[Product][weight]" id="focusedInput" type="text"  > 
								</td>
								<td width="20%">
									<label class="control-label" for="focusedInput"><?php echo __('arrangment') ?> :</label> 
								  <input class="input-xlarge focused" style="width:30px" value="0" name="data[Product][arrangment]" id="focusedInput" type="text"  > 
								</td>
							 </tr>
							 <tr>
							 	<td width="20%">
									<label class="control-label" for="focusedInput"><?php echo __('status') ?> :</label>
								  <select id="selectError3" style="width:auto" name="data[Product][status]">
									<option value="1"><?php echo __('active') ?></option>
									<option value='0'><?php echo __('inactive') ?></option>
								  </select>
								</td>
								<td width="20%">
									<label class="control-label" for="focusedInput"><?php echo __('rate') ?> :</label> 
								  <input class="input-xlarge focused" style="width:30px" value="" name="data[Productrate][rate]" id="focusedInput" type="text"  > از 1 تا 10
								</td>
								<td>
									<label class="control-label" for="focusedInput"><?php echo __('technicalinfoitem') ?> :</label> 
									<select id="technical_info_id" style="width:auto" name="data[Product][technical_info_id]">
									  <option selected="" value='0'> --------- </option>
									<?php
										 if(!empty($technicalinfos)){
										 	foreach($technicalinfos as $technicalinfo)
											{
												echo"<option value='".$technicalinfo['Technicalinfo']['id']."'>
													".$technicalinfo['Technicalinfo']['title']."			
												</option>";
											}
										 }
										  
									?>
								   </select>
								</td>
							 </tr>
							 <tr>
								<td colspan="5">
								  <div id="technicalinfoitem">
								     <div id="body"></div>
									 <span id="technicalinfoitem_loading"></span>
								  </div>
								</td>
							 </tr>
							 <tr>
							 	<td colspan="5">
									<label class="control-label" for="focusedInput"><?php echo __('product_images') ?> :
									</label>
	                                    <table id="expense_table" class="expense_table" cellspacing="0" cellpadding="0" width="500">
	                                        <thead>
	                                            <tr>
	                                                <th><?php echo __('image'); ?></th>
                                                    <th><?php echo __('title'); ?></th>
	                                                <th>&nbsp;</th>
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                            <tr>
	                                                <td>
	                                                    <input type="file" name="data[Productimage][image][]" id="image_no_01" maxlength="255"  />
	                                                </td>
                                                    <td>
	                                                    <input type="text" name="data[Productimage][title][]" id="title_no_01" maxlength="255"  />
	                                                </td>
	                                                <td>&nbsp;</td>
	                                            </tr>
	                                        </tbody>
	                                    </table>
	                                   
	                                    <input type="button" value="<?php echo __('add_image'); ?>" id="add_ExpenseRow" />
								</td>
							 </tr>
							 <tr>
							 	<td colspan="5">
									<label class="control-label" for="focusedInput"><?php echo __('tag') ?> :</label>
								  <div id="messageForm">
									  <div id="friends" class="ui-helper-clearfix"   >
											<input id='friend_input' type='text' dir='rtl' size='30' >
											<input class="btn btn-small btn-success" type="button" id="add_tag" value="<?php echo __('add') ?>" />
									  </div>
								  </div>
								</td>
							 </tr>
						 </table>
							<fieldset>
							  <div class="control-group">
																
								<div class="controls">
								  <label class="control-label" for="focusedInput">
								  <?php echo __('product_category') ?> :</label>
								  <div id="category">
								     <div id="body"></div>
									 <span id="category_loading"></span>
								  </div>
								   
								</div>
								
								<div class="controls">
								  <label class="control-label" for="focusedInput"><?php echo __('detail') ?> :</label>
								  <textarea class="input-xlarge focused" name="data[Product][detail]" id="first_editor" >
								  	
								  </textarea>
								</div>	
								
								
							  </div>
							  
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary"><?php echo __('save_change') ?></button>
								<button type="reset" class="btn"><?php echo __('cancel') ?></button>
							  </div>
							</fieldset>
						  </form>
					
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			</form>
			
		
    
					<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		 
		
	</div><!--/.fluid-container-->
	
	
	<script>
	//===========================================================================================
	$('#add_tag').click(function(){
		 var tag = $('#friend_input').val();
		 span = $("<span>").text(tag),
			a = $("<a>").addClass("remove").attr({
				href: "javascript:",
				title: "Remove " + tag,
			}).text("x").appendTo(span);
		var hide_input= "<input type='hidden' name='new_tags[]' value='"+tag+"' >";
		//hide_input.appendTo(span);
		span.append(hide_input);
		//add tag to tag div
		 
		span.insertBefore("#friend_input");
		$('#friend_input').val('');
	});	
	//===========================================================================================
		CKEDITOR.replace( 'first_editor' );
	/**
	* *****************************************************************************************************************
	*/	
		function get_product_category(parent_id,current_parent_id)
		 {
			$("#category_loading").html('<img src="'+_durl+'shop/img/loader/5.gif" >');									
			$.ajax({
					type:"POST",
					url:_url+'shop/products/get_product_category/'+parent_id,
					data:'',
					success:function(response){						
						$(".category").each(function(){
							var id = $(this).attr('id');
							if(id>parent_id){
								$("#category #body #"+id).remove();
							}
						 });
						 if(current_parent_id==0){
							 $(".category").each(function(){
							 	var id = $(this).attr('id');
								if(id>0){
									var id = $(this).attr('id');
									$("#category #body #"+id).remove();
								}								
							 });
						 }
						 						 
						console.log('current_parent_id='+current_parent_id+'parent_id='+parent_id)
						$("#category #body").append(response);								
					    $("#category_loading").empty();
					}
					
				});
		 }
		get_product_category(0);
	/**
	* *****************************************************************************************************************
	*/	
		$('#technical_info_id').change(function(){
			//console.log($(this).val());
			$("#technicalinfoitem_loading").html('<img src="'+_durl+'shop/img/loader/5.gif" >');	
			$.ajax({
					type:"POST",
					url:_url+'shop/products/get_technical_info/'+$(this).val(),
					data:'',
					success:function(response){
						$("#technicalinfoitem #body").html(response);								
					    $("#technicalinfoitem_loading").empty();
					}
					
				});
		})
	/**
	* *****************************************************************************************************************
	*/
		$(function(){
        	// GET ID OF last row and increment it by one
        	var $lastChar =1, $newRow;
        	$get_lastID = function(){
        		var $id = $('.expense_table tr:last-child td:first-child input').attr("id");
        		$lastChar = parseInt($id.substr($id.length - 2), 10);
        		console.log('GET id: ' + $lastChar + ' | $id :'+$id);
        		$lastChar = $lastChar + 1;
        		$newRow = "<tr> \
        					<td><div class='uploader' id='uniform-image_no_0"+$lastChar+"'><input type='file' name='data[Productimage][image][]' id='image_no_0"+$lastChar+"' maxlength='255' style='opacity: 0;' /><span class='filename' style='-moz-user-select: none;'>No file selected</span><span class='action' style='-moz-user-select: none;'>Choose File</span></div></td> \<td><input type='text' name='data[Productimage][title][]' id='title_no_0"+$lastChar+"' maxlength='255' /></td> \<td><input type='button' value='Delete' class='del_ExpenseRow' /></td> \
        				</tr>"
        		return $newRow;
        	}
        	
        	// ***** -- START ADDING NEW ROWS
        	$('#add_ExpenseRow').live("click", function(){ 
        		//if($lastChar <= 9){
        			$get_lastID();
        			$('.expense_table tbody').append($newRow);
        		/*} else {
        			alert("Reached Maximum Rows!");
        		};*/
        	});
        	
        	$(".del_ExpenseRow").live("click", function(){ 
        		$(this).closest('tr').remove();
        		$lastChar = $lastChar-2;
        	});	
        });	
	/**
	* *****************************************************************************************************************
	*/	
	var tarr =[];
		var arr = [];
 
	$("#friend_input").autocomplete({
					//define callback to format results
				
					source: function(req, add){
					
						//pass request to server
						$.getJSON(_url+"shop/products/tag_search?callback=?", req, function(data) {
							
							//create array for response objects
							var suggestions = [];
							//var suggestions1 = [];
							//process response
							$.each(data, function(i, val){	
							 						
								suggestions.push({'title':val.title,'id':val.id});
								 
								//suggestions.push(val.name+'<input type=hidden id='+val.user_id+'>');
							 
							});
							
							//pass array to callback
							
							add(suggestions);
							 
							 
						});
					},
					select: function(e, ui) {
						
						//create formatted tag
						var friend = ui.item.value;
						 
						var user_count= $("#friends span").length+1; 
						var id= ui.item.id;
							span = $("<span>").text(friend),
							a = $("<a>").addClass("remove").attr({
								href: "javascript:",
								title: "Remove " + friend,
								id   : id,
							}).text("x").appendTo(span);
						var hide_input= "<input type='hidden' name='data[Productrelatetag][product_tag_id][]' value='"+id+"' >";
						//hide_input.appendTo(span);
						span.append(hide_input);
						//add friend to friend div
						 
						span.insertBefore("#friend_input");
					},
					
					//define select handler
					change: function() {
						
						//prevent 'to' field being updated and correct position
						$("#friend_input").val("").css("top", 2);
					}
				});
				
				//add click handler to user_ids div
				$("#friends").click(function(){
					
					//focus 'to' field
					$("#friend_input").focus();
				});
				
				//add live handler for clicks on remove links
				$(".remove", document.getElementById("friends")).live("click", function(){
				
					//remove current friend
					$(this).parent().remove();
					
					//correct 'to' field position
					if($("#friends span").length === 0) {
						$("#friend_input").css("top", 0);
					}				
				});	
	/**
	* *****************************************************************************************************************
	*/		
	</script>
    
    