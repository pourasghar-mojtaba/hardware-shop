<?php

class AdminHtmlHelper extends AppHelper
{
	public $helpers = array('Html','Form');
	private $_typs = array(
		'select'=>'select',
		'link'  =>'link'
	);
	private $_tags = array(
		'selectstart'        => '<select name="%s"%s>',
		'selectmultiplestart'=> '<select name="%s[]"%s>',
		'selectempty'        => '<option value=""%s>&nbsp;</option>',
		'selectoption'       => '<option value="%s">%s</option>',
		'selectend'          => '</select>',
		'group_input'        => '<div class="form-group"><label >%s</label>%s</div>',
		'span'               => '<span %s>%s</span>',
		'spanlink'           => '<span %s>%s</span> %s ',
		'div'                => '<div %s>%s</div>',
		'divstart'           => '<div %s>',
		'divend'             => '</div>'
	);
	var $settings = array();
	/**
	*
	* @param undefined $view
	* @param undefined $settings
	*
	*/
	public
	function __construct(View $view, $settings = array())
	{
		parent::__construct($view, $settings);
		$this->settings = array_merge(array('seprator'=>',','space'   =>' ','title'   =>'title','name'    =>'name','value'   =>'value','url'     =>'url'), $settings);
	}
	/**
	*
	* @param undefined $name
	* @param undefined $options
	* @param undefined $selectAttr
	* @param undefined $optionAttr
	*
	*/
	public
	function select($name,$options = array(),$selectAttr = array(),$optionAttr = array())
	{
		$selAttr = '';
		$select  = '';
		if(!empty($selectAttr)){
			foreach($selectAttr as $attribute=>$value){
				$seprator = '';
				$selAttr .= $seprator.$attribute .'="'.$value.'"';
				$seprator = $this->settings['seprator'];
			}
		}
		$select = sprintf($this->_tags['selectstart'],'data['.$this->settings['action'].']['.$name.']',$selAttr);
		if(!empty($options)){
			foreach($options as $option){
				$select .= sprintf($this->_tags['selectoption'],$option[$this->settings['value']],$option[$this->settings['title']]);
			}
		}
		$select .= $this->_tags['selectend'];
		return $select;
	}
	/**
	*
	* @param undefined $items
	* @param undefined $attributs
	*
	*/
	public
	function addButton($items = array(),$attributs = array())
	{
		if(!isset($items) || empty($items)){
			return '';
		}
		if(isset($items[$this->_typs['select']])){
			return $this->select($items[$this->_typs['select']]['name'],$items[$this->_typs['select']]['options'],$attributs);
		}
		if(isset($items[$this->_typs['link']])){
			return $this->Html->link($items[$this->_typs['link']][$this->settings['title']],$items[$this->_typs['link']][$this->settings['url']],$attributs);
		}
	}

	public
	function groupInput($name,$title,$options = array())
	{

		$input = $this->Form->input($name,array_merge(array('name' =>'data['.$this->settings['action'].']['.$name.']','div'  =>false,'label'=>false),$options));
		return sprintf($this->_tags['group_input'],$title,$input);
	}

	function __extractAttribute($options = array(),$sep = ' ')
	{
		$attribut = '';
		if(!empty($options)){
			foreach($options as $option=>$value){
				$seprator = '';
				$attribut .= $seprator.$option .'="'.$value.'"';
				$seprator = $sep;
			}
		}
		return $attribut;
	}

	public
	function status($title,$options = array())
	{
		$attr = $this->__extractAttribute($options);
		return sprintf($this->_tags['span'],$attr,$title);
	}

	public
	function createActionLink($options = array('class'=>'row-actions visible'))
	{
		$attr = $this->__extractAttribute($options);
		return sprintf($this->_tags['divstart'],$attr);
	}
	public
	function actionLink($title,$url,$action = '',$seprator = '',$options = array())
	{
		$defaultAttribute = array();
		if(!empty($action) && $action == 'delete'){
			if(!isset($options['class'])){
				$defaultAttribute = array('class'  =>'delete');
			}
			if(!isset($options['onclick'])){
				$defaultAttribute = array_merge($defaultAttribute,array('onclick'=>"return confirm('".__('r_u_sure')."')"));
			}
		}
		if(!empty($action) && $action == 'permission'){
			if(!isset($options['class'])){
				$defaultAttribute = array('class'  =>'permission');
			}
		}
		$attr = $this->__extractAttribute(array_merge($defaultAttribute,$options));
		return sprintf($this->_tags['spanlink'],'',$this->Html->link($title,$url,$attr),$seprator);
	}
	function endActionLink()
	{
		return $this->_tags['divend'];
	}

}






?>