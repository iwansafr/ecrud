<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($field))
{
	$hidden_value = !empty($data[$field]) ? $data[$field] : '';
	if(!empty($this->value[$field]))
	{
		$hidden_value = $this->value[$field];
	}
	echo form_hidden($field,$hidden_value);
}