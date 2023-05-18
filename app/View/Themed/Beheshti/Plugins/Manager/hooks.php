<?php

$this->add_hook('admin_menu','message_menu');

function message_menu($arg)
{
	$active = NULL;
	if($arg['request']->params['controller'] == 'messages')	 $active = 'class="active"';
	echo
	"<li  ".$active.">
	<a href='".__SITE_URL."admin/manager/messages/index'>
	<i class='fa fa-commenting-o'></i>
	<span>".__d('manager','manager_message_managment')."</span>
	</a>
	</li>";
}

$this->add_hook('manager_image','show_manager_images');
function show_manager_images($arg)
{
	App::uses('User', 'Model');
	$user = new User();
	$user->recursive = - 1;
	$options['fields'] = array(
		'User.id',
		'User.name',
		'User.image',
	);

	$options['conditions'] = array(
		'User.role_id'=> 4
	);
	$users = $user->find('all',$options);
	if(!empty($users)){
		echo "<div class='row front-team'>
				<ul class='list-unstyled'>";
		foreach($users as $user){
			echo "
					<li class='col-md-3 space-mobile'>
						<div class='thumbnail'>
							".
							$arg['Html']->image(__SITE_URL.__USER_IMAGE_PATH.$user['User']['image'],array('alt'=>$user['User']['name'],'class'=>'pull-left'))
							."
							<h3>
								<a>
									".$user['User']['name']."
								</a>
								<small>
									".__d('manager','manager')."
								</small>
							</h3>
						</div>
					</li>
				";
		}
		echo "</ul>
			</div>";
	}
	 
	
}
$this->add_hook('manager_message','show_manager_message');

function show_manager_message($arg){
	
	App::uses('ManagerAppModel', 'Manager.Model');
	App::uses('Message', 'Manager.Model');
	$message = new Message();
	$message->recursive = - 1;
	$options['fields'] = array(
		'Message.id',
		'Message.user_id',
		'Message.message',
		'User.name',
		'User.image'
	);
	$options['joins'] = array(
    		array('table' => 'users',
        		'alias' => 'User',
        		'type' => 'INNER',
        		'conditions' => array(
        		'User.id = Message.user_id'
    		)
		)
    );	 
	$options['conditions'] = array(
		'Message.status'=> 1
	);
	$messages = $message->find('all',$options);
	 
	if(!empty($messages)){
		echo "
				<h2 class='block'>
					".__d('manager','with_managers')."
				</h2>
				<div class='carousel slide' id='myCarousel1'>
					<!-- Carousel items -->
					<div class='carousel-inner'>";
		foreach($messages as $key=>$message){
			
			if ($key ==0) $active= 'active'; else $active= '';
			echo "
					<div class='item ".$active."'>
						<span class='testimonials-slide'>
							".$message['Message']['message']."
						</span>
						<div class='carousel-info'>";
							echo $arg['Html']->image(__SITE_URL.__USER_IMAGE_PATH.$message['User']['image'],array('alt'=>$message['User']['name'],'class'=>'pull-left'));								
							echo"<div class='pull-left'>
								<span class='testimonials-name'>
									".$message['User']['name']."
								</span>
								<span class='testimonials-post'>
									".__d('manager','manager')."
								</span>
							</div>'
						</div>
					</div>						
				";
		}
		echo "</div>
					<!-- Carousel nav -->
					<a data-slide='prev' href='#myCarousel1' class='left-btn'>
					</a>
					<a data-slide='next' href='#myCarousel1' class='right-btn'>
					</a>
				</div>
			";
	}
	
}
?>