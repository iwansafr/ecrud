<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($field))
{
	if($this->init == 'edit' || $this->init == 'param')
	{
		$data_value = empty($this->id) ? 1 : $data[$field];
		$values = !empty($data[$field]) ? $data[$field] : '1';
		echo '<br>';
		echo form_label(ucfirst($label), $label);
		$name = $field;
	}else{
		$data_value = $dvalue[$ikey];
		$values = $dvalue['id'];
		$name = $field.'[]';
	}

	if(!empty($this->checkbox[$field]))
	{
			foreach ($this->checkbox[$field] as $cfkey => $cfvalue)
			{
				echo '<div class="checkbox">';
				echo '<label>';
				echo form_checkbox(array(
					'name'    => $name.'[]',
					'value'   => $cfvalue,
					'checked' => 0
					)).ucfirst($cfvalue);
				echo '</label>';
				echo '</div>';
			}
	}else{
		echo '<div class="checkbox">';
		echo '<label>';
		echo form_checkbox(array(
			'name'    => $name,
			'value'   => $values,
			$required => $required,
			'checked' => $data_value
			)).ucfirst($field);
		echo '</label>';
		echo '</div>';
	}

}