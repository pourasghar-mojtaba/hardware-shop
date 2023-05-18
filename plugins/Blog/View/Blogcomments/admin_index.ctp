<!-- topbar starts -->
	 
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- right menu starts -->
				<?php echo $this->element('Admin/right_menu'); ?>       
			<!-- right menu ends -->
			
			<div id="content" class="span10">
			<!-- content starts -->
			

			 
			<?php if($this->Session->check('Message.flash')) {?>
				<div style="clear:both">
					  <?php echo $this->Session->flash(); ?>
				</div>
				<?php } ?>
				 
			 <div class="row-fluid sortable ui-sortable">	
				<div class="box span12">
					<div data-original-title="" class="box-header well">
						<h2><?php echo __('blogcomments'); ?></h2>
						<div class="box-icon">
							<a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
						</div>
					</div>

					<div class="box-content">
					<?php echo $this->Form->create('Blogcomment', array('id'=>'SearchFrom','name'=>'SearchFrom')); ?>
						<div class="row-fluid">
							<div class="span6">
								<div id="DataTables_Table_0_length" class="dataTables_length">
									<label>
									 <?php echo __('records_per_page'); ?> :
									<select size="1" aria-controls="DataTables_Table_0" onchange="if (this.value) window.location.href=this.value">
										<?php
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==10)
												echo "<option value='". __SITE_URL."admin/blogcomments/index?filter=10 ' selected='selected'>10</option>";
												else echo"<option value='". __SITE_URL."admin/blogcomments/index?filter=10 '>10</option>";
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==25)
												echo "<option value='". __SITE_URL."admin/blogcomments/index?filter=25 ' selected='selected'>25</option>";
												else echo"<option value='". __SITE_URL."admin/blogcomments/index?filter=25 '>25</option>";	
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==50)
												echo "<option value='". __SITE_URL."admin/blogcomments/index?filter=50 ' selected='selected'>50</option>";
												else echo"<option value='". __SITE_URL."admin/blogcomments/index?filter=50 '>50</option>";	
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==100)
												echo "<option value='". __SITE_URL."admin/blogcomments/index?filter=100 ' selected='selected'>100</option>";
												else echo"<option value='". __SITE_URL."admin/blogcomments/index?filter=100 '>100</option>";			
										?>
									</select> 
									</label>
								</div>
							</div>
							<!--<div class="span6">
							
								<div class="dataTables_filter" id="DataTables_Table_0_filter">
								<label><?php echo __('search'); ?>: <input type="text" name="data[Blogcomment][search]" aria-controls="DataTables_Table_0"></label>
								</div>
							  	
							</div>-->
							<h4><?php echo __('blog_title').' : '.$blog['Blog']['title']; ?></h4>
						</div>
						</form>
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th><?php echo $this->Paginator->sort('Blogcomment.id', __('id'));?></th>							  
									  <th><?php echo $this->Paginator->sort('User.name', __('name'));?></th>
									  <th><?php echo $this->Paginator->sort('Blogcomment.comment',__('comment'));?></th>
									  <th><?php echo $this->Paginator->sort('Blogcomment.status',__('status'));?></th>  
									  <th><?php echo $this->Paginator->sort('Blogcomment.created', __('created'));?></th>
									  <th><?php echo __('action'); ?>  </th>                                         
								  </tr>
							  </thead>   
							  <tbody>
							  <?php 
							   
								if(!empty($blogcomments))
								{
									foreach($blogcomments as $blogcomment)
									{
										
								?>
										<tr>								
											<td class="center"><?php echo $blogcomment['Blogcomment']['id']; ?></td>
											<td class="center"><?php echo $blogcomment['User']['name']; ?></td>
											<td class="center"><?php echo $blogcomment['Blogcomment']['comment']; ?></td>
											<td class="center">
											 <?php
											   if($blogcomment['Blogcomment']['status']==1)
											     echo "<span class='label label-success'>".__('active')."</span>";
											   else echo "<span class='label label-important'>".__('inactive')."</span>";	 
											 ?>
												
											</td>  
											<td class="center"><?php echo $blogcomment['Blogcomment']['created']; ?></td>
											<td class="center ">												
												<a href="<?php echo __SITE_URL.'admin/blogcomments/edit/'.$blogcomment['Blogcomment']['id'].'/'.$blog_id;  ?>" class="btn btn-info">
													<i class="icon-edit icon-white"></i>  
													<?php echo __('edit'); ?>                                            
												</a>
												  
												<a href="<?php echo __SITE_URL.'admin/blogcomments/delete/'.$blogcomment['Blogcomment']['id'].'/'.$blog_id; ?>" class="btn btn-danger" 
												onclick="return confirm('<?php echo __('r_u_sure'); ?>')">
													<i class="icon-trash icon-white"></i> 
													<?php echo __('delete'); ?>
												</a>
											</td>                                     
										</tr>  
								<?php
								
									}
								}
							  ?>                                
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
						  <?php echo $this->Paginator->prev(__('prev'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class' => 'prev disabled'));?>
							<!--<li><a href="#">Prev</a></li>->
							<!--<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>-->
							<?php echo $this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active','currentTag'=>'a'));?>
							<!--<li><a href="#">Next</a></li>-->
							<?php echo $this->Paginator->next(__('next'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class' => 'next disabled'));?>
						  </ul>
						</div>     
					</div>
				</div><!--/span-->
			</div>
		
    
					<!-- content ends -->
			</div><!--/#content.span10-->
	</div><!--/fluid-row-->
</div>				
	




	