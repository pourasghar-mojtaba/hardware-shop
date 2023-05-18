<?php
App::uses('AppModel', 'Model');
/**
* User Model
*
* @property Role $Role
* @property UserLogLogin $UserLogLogin
*/
class User extends AppModel
{

	/**
	* Display field
	*
	* @var string
	*/
	public $displayField = 'name';

	/**
	* Validation rules
	*
	* @var array
	*/
	public $validate = array(
		'role_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	* belongsTo associations
	*
	* @var array
	*/
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey'=> 'role_id',
			'conditions'=> '',
			'fields'    => '',
			'order'     => ''
		)
	);

	/**
	* hasMany associations
	*
	* @var array
	*/
	public $hasMany = array(
		'Userloglogin' => array(
			'className'   => 'Userloglogin',
			'foreignKey'  => 'user_id',
			'dependent'   => false,
			'conditions'  => '',
			'fields'      => '',
			'order'       => '',
			'limit'       => '',
			'offset'      => '',
			'exclusive'   => '',
			'finderQuery' => '',
			'counterQuery'=> ''
		)
	);

	public
	function beforeSave($options = NULL)
	{
		if(isset($this->data[$this->alias]['password'])){
			if($this->data[$this->alias]['password'] != '')
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
			else $this->data[$this->alias]['password'] = $this->data[$this->alias]['old_password'];
		}
		return true;
	}

	function _getUser($email)
	{
		$this->recursive = - 1;
		$options['fields'] = array(
			'User.id',
			'User.name',
			'User.email',
			'User.role_id',
			'User.user_name'
		);

		$options['conditions'] = array(
			'User.email'=> $email
		);
		$user = $this->find('first',$options);
		return $user;
	}

}
?>