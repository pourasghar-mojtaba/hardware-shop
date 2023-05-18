<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('role_id');
		echo $this->Form->input('name');
		echo $this->Form->input('sex');
		echo $this->Form->input('age');
		echo $this->Form->input('user_name');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		echo $this->Form->input('image');
		echo $this->Form->input('last_login');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('User.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Log Logins'), array('controller' => 'user_log_logins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Log Login'), array('controller' => 'user_log_logins', 'action' => 'add')); ?> </li>
	</ul>
</div>
