<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($field))
{
	$link_get = $this->link['link_get'][$field];
	$key_get  = $link_get;

	if($this->init == 'edit')
	{
		$data_value = $data[$field];
		$link_get   = $data[$link_get];

		echo form_label(ucfirst($label), $label);
	}else{
		$data_value = $dvalue[$ikey];
		$link_get   = $dvalue[$link_get];
		if(!empty($this->plaintext[$field])){
			$data_value = $this->plaintext[$field];
		}
	}
	?>
	<a href="<?php echo $this->link[$field].'/?'.$key_get.'='.$link_get ?>"><?php echo $data_value ?></a>
	<?php
}