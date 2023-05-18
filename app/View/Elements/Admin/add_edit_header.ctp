<section class="content-header">
      <h2>
        <?php echo $items['title']; ?>
      </h2>
      <ol class="breadcrumb">
        <li><a href="<?php echo __SITE_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <?php if(!empty($items['link'])){ ?><li><a href="<?php echo $items['link']['url'] ?>">
		<?php echo $items['link']['title'] ?></a></li><?php } ?>
        <li class="active"><?php echo $items['title']; ?></li>
      </ol>
    </section>
<?php echo $this->Session->flash(); ?>	
<section class="content">
	<div class="row">
	
		<div class="col-md-12">
		
		   <div class="box box-primary">
            <div class="box-header with-border">
			<?php

				$languages = $this->requestAction(__SITE_URL.'admin/languages/getall/');
				if(count($languages)>1){
				foreach($languages as  $language){
					if($language['Language']['code']==$_COOKIE['CakeCookie'][__ADMIN_LANG_INDEX]){
						$current_lang = $language['Language']['title'];
					}					
				}	
			?>
              <ul class="nav nav-tabs pull-left">
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                  <?php echo __('language'); ?> : (<?php echo $current_lang; ?>)<span class="caret"></span>
                </a>
				
                <ul class="dropdown-menu">
				  <?php
				  	foreach($languages as  $language){
						echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='".__SITE_URL."admin/languages/change/".$language['Language']['code']."/".$language['Language']['id']."'>".$language['Language']['title']."</a></li>";
					}
				  ?>	
                </ul>
				 
              </li>
             
            </ul>
			<?php
				}
			?>
            </div> 

            <form role="form">              
			  <div class="box-body">