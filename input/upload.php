<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($field))
{
	if(!empty($this->id))
	{
		$data_image = $this->data_model->get_one_data($this->table, ' WHERE id = '.$this->id);
		$image    = !empty($data_image[$field]) ? $this->id.'/'.$data_image[$field] : '';
	}else if($this->init == 'param')
	{
		$image    = !empty($data[$field]) ? $name.'/'.$data[$field] : '';
	}
	echo form_label(ucfirst($label), $label);
	if(!empty($image))
	{
		?>
		<div class="image">
			<a href="#">
				<img src="<?php echo image_module($this->table, $image) ?>" class="img-responsive image-thumbnail image" style="object-fit: cover;width: 200px;height: 140px;" data-toggle="modal" data-target="#img_<?php echo $field?>">
			</a>
			<span><a href="#del_image" class="del_image"><i class="fa fa-close" style="position: relative;top: -135px;right: -180px;color: red;"></i></a></span>
		</div>

		<div class="modal fade" id="img_<?php echo $field?>" tabindex="-1" role="dialog" aria-labelledby="img_<?php echo $field?>">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="img_title_<?php echo $field?>"><?php echo $field;?></h4>
		      </div>
		      <div class="modal-body" style="text-align: center;">
		        <img src="<?php echo image_module($this->table, $image); ?>" class="img-thumbnail img-responsive">
		      </div>
		      <div class="modal-footer">
		      </div>
		    </div>
		  </div>
		</div>
		<?php
	}
	echo form_upload(array(
		'name'   => $field,
		'class'  => 'form-control',
		'accept' => @$this->accept[$field],
		$required => $required,
		'value'  => $data[$field]
		)
	);

	if(!empty($this->id) || ($this->init == 'param'))
	{
		echo form_hidden($field,$data[$field]);
	}else{
		echo form_hidden($field,'');
	}
	// $this->session->set_userdata('link_js', base_url().'templates/admin/');
}