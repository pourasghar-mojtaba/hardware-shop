
<?php
$this->Cms->autoCompileLess(ROOT.DS.APP_DIR.DS.'webroot'.DS.'less'. DS .'profile.less', ROOT.DS.APP_DIR.DS.'webroot'.DS.'css'.DS.'profile.css');

echo $this->Html->css('profile');
echo $this->Html->css('blog');
?>




<div class="pageContainer container-fluid">
	<?php echo $this->element('header'); ?>
	<div class="clear">
	</div>

	<div class="midContent" style="padding-top: 5px;">


		<div class="col-md-9">

			<div class="dataBox" style="padding:0px;margin-top: 11px;">
				<div class="tag-title">
				<?php
					echo __('tag_word').' : '.$tag;
				?>
				</div>
				<div class="topdownline2New"></div>
				<div class="clear">
				</div>
				<?php
		
					if(!empty($blogs)){
						$columnCounter = 0;					
						foreach($blogs as $blog)
						{
							$columnCounter++;
				?>			
						<div class="col-md-6">
							<div class="topnews">
								<h2 class="topnewspic">
									<a href="<?php echo __SITE_URL.'blogs/view/'.$blog['Blog']['id'].'/'.$blog['Blog']['title']; ?>" >									
										<?php
										
											$blog_image='';
											$width=70;
											$height=70;
											$image=$blog['Blog']['image'];
										    if(fileExistsInPath(__USER_BLOG_PATH.$image )&& $image!='' ) 
											{
												$blog_image = $this->Html->image('/'.__USER_BLOG_PATH.__UPLOAD_THUMB.'/'.$image,array('width'=>$width,'height'=>$height,'id'=>'blog_thumb_image_'.$blog['Blog']['id'],'alt'=>$blog['Blog']['title']));
											}
											else{		 
												$blog_image = $this->Html->image('new_blog.png',array('width'=>$width,'height'=>$height,'alt'=>$blog['Blog']['title'],'id'=>''));
											}
											echo $blog_image;
										?>
										
									</a>
								</h2>
								<h2 class="topnewsinfo">
									<a href="<?php echo __SITE_URL.'blogs/view/'.$blog['Blog']['id'].'/'.$blog['Blog']['title']; ?>" >
										<h2 class="topnewsinfotitle">
											<?php echo $blog['Blog']['title']; ?>
										</h2>
									</a>
								</h2>
								<h4 class="newslead" style="line-height: 160%;">
									<?php echo $blog['Blog']['little_detail']; ?>
								</h4>
							</div>
						</div>
				<?php
							if ($columnCounter % 2 == 0) 
								echo"<div class='topdownline2New'></div><div class='clear'></div>";
						}
					}
				?>

				
				<div class="clear">	</div> 
				
				<?php
				if(!empty($_REQUEST['page']))
				{
					$page = $_REQUEST['page'];
				}
				else $page    = 1;

				$url_str = __SITE_URL.'blogs/last?';
				$this->Paginate->with_hide($total_count,$page,$limit,$url_str);
				?>
				<div class="clear">	</div>

				<br />
			</div>

		</div>



		<div class="col-md-3">
			<div class="mainPanel">
				<div class="dataBox">
					<div class="clear">
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>




