<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($field))
{
	if($this->init == 'edit' || $this->init == 'param')
	{
		$data_value =  $data[$field];
		echo form_label(ucfirst($label), $label);
	}else{
		$data_value = $dvalue[$ikey];
	}

	$type = !empty($this->type[$field]) ? $this->type[$field] : 'text';
	$array_input = array(
		'name'    => $field,
		'class'   => 'form-control',
		$required => $required,
		'type'    => $type,
		'value'   => $data_value);
	if(!empty($this->elementid[$field]))
	{
		// $array_input['id'] = $
		pr($this->elementid);
	}
	echo form_input($array_input);
}