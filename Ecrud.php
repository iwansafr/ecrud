<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ecrud extends CI_Model
{
  public function __construct()
  {
  	parent::__construct();
    $this->load->model('data_model');
  }

	var $table         = '';
	var $view          = '';
	var $init          = '';
	var $heading       = '';
	var $paramname     = '';
	var $where         = '';
	var $limit         = 12;
	var $id            = 0;
	var $delete        = false;
	var $options       = array();
	var $required      = array();
	var $data          = array();
	var $input         = array();
	var $link          = array();
	var $label         = array();
	var $attribute     = array();
	var $field         = array();
	var $image         = array();
	var $type          = array();
	var $accept        = array();
	var $checkbox      = array();
	var $orderby       = array('index'=>'id','sort'=>'DESC');
	var $multiselect   = array();
	var $elementid     = array();
	var $value         = array();
	var $startCollapse = array();
	var $endCollapse   = array();
	var $param         = array();
	var $plaintext     = array();

	public function init($text = '')
	{
		if(!empty($text))
		{
			switch($text)
			{
				case 'roll':
					$this->init = $text;
				break;
				case 'edit':
					$this->init = $text;
				break;
				case 'param':
					$this->init = $text;
				break;
				default:
					$this->init = '';
				break;
			}
		}
	}

	public function setLimit($limit = 0)
	{
		$this->limit = @intval($limit);
	}

	public function setWhere($sql = '')
	{
		if(!empty($sql))
		{
			$this->where = $sql;
		}
	}

	public function setParamName($name = '')
	{
		if(!empty($name))
		{
			$this->paramname = $name;
		}
	}

	public function setParam($param = array())
	{
		if(!empty($param))
		{
			$this->param = $param;
		}
	}

	public function open_collapse($id = 'collapse1', $title = 'Collapsible Panel')
	{
		?>
		<br>
		<div class="panel-group">
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" href="#<?php echo $id; ?>"><?php echo $title ?></a>
		      </h4>
		    </div>
		    <div id="<?php echo $id ?>" class="panel-collapse collapse">
		      <div class="panel-body">

		<?php
	}

	public function close_collapse()
	{
		?>
					</div>
					<div class="panel-footer">Panel Footer</div>
				</div>
		  </div>
		</div>
		<?php
	}

	public function search()
	{
		?>
		<form method="get" action="<?php echo !empty($this->view) ? base_url($this->view) : ''; ?>" class="form-inline pull-right">
			<input type="text" name="keyword" class="form-control" placeholder="keyword">
			<button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-search"></span></button>
		</form>
		<hr>
		<div class="clearfix"></div>
		<?php
	}

	public function setImage($field = '', $module = '', $src = '')
	{
		if(!empty($field) && !empty($module))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->image[$field]['module'] = $module;
					$this->image[$field]['src']    = $src;
				}
			}
		}
	}

	public function setHeading($heading = '')
	{
		$this->heading = $heading;
	}

	public function setView($view = '')
	{
		$this->view = $view;
		$this->data_model->setView($view);
	}

	public function tableOptions($field = '', $table = '', $index= '', $label = '', $ex = '')
	{
		if(!empty($table) && !empty($index) && !empty($label))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$data = $this->data_model->get_all("SELECT `{$index}`,`{$label}` FROM `{$table}` {$ex}");
					if(!empty($data))
					{
						$options    = array();
						$options[0] = 'None';

						foreach ($data as $dkey => $dvalue)
						{
							$options[$dvalue[$index]] = $dvalue[$label];
						}
						$this->options[$field] = $options;
					}
				}
			}
		}
	}

	public function setOptions($field = '',$options = array())
	{
		if(!empty($field) && !empty($options))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->options[$field] = $options;
				}
			}
		}
	}

	public function setMultiSelect($field = '', $table = '', $col = '')
	{
		if(!empty($field) && !empty($table) && !empty($col))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->multiselect[$field]['data'] = $this->data_model->get_all("SELECT {$col} FROM `{$table}` WHERE 1");
				}
			}
		}
	}

	public function setType($field = '', $type = '') /*untuk input type text*/
	{
		if(!empty($field) && !empty($type))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->type[$field] = $type;
				}
			}
		}
	}

	public function setElementId($field = '', $id = '')
	{
		if(!empty($field) && !empty($id))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->elementid[$field] = $id;
				}
			}
		}
	}

	public function setValue($field = '', $value = '')
	{
		if(!empty($field) && !empty($value))
		{
			foreach ($this->input as $ikey => $ivalue)
			{
				if($ivalue['text'] == $field)
				{
					$this->value[$field] = $value;
				}
			}
		}
	}

	public function setField($fields = array())
	{
		$this->field = $fields;
	}

	public function setData()
	{
		if(!empty($this->input))
		{
			foreach ($this->input as $key => $value)
			{
				if($this->init == 'edit' || $this->init == 'param')
				{
					$this->data[$key] = '';
				}else if($this->init == 'roll')
				{
					$this->data[0][$key] = '';
					if(!in_array('id', $this->input))
					{
						$this->data[0]['id'] = 0;
					}
				}
			}
		}
	}

	public function setLink($field = '', $link = '', $get = '')
	{
		if(!empty($field) && !empty($link))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					if(!empty($get))
					{
						$this->link['link_get'][$field]	= $get;
					}
					$this->link[$field] = $link;
				}
			}
		}
	}

	public function addInput($text = '', $type = '')
	{
		$this->input[$text] = array('text'=>$text, 'type'=>$type);
	}

	public function setTable($table = '', $index = '', $sort = '')
	{
		if(!empty($table))
		{
			$this->table = $table;
		}

		if(!empty($index) && !empty($sort))
		{
			$this->orderby['index'] = $index;
			$this->orderby['sort'] = $sort;
		}
	}

	public function setRequired($input = array())
	{
		if(!empty($input))
		{
			foreach ($input as $key => $value)
			{
				foreach ($this->input as $ikey => $ivalue)
				{
					if($ivalue['text'] == $value)
					{
						$this->required[$value] = 'required';
					}
				}
			}
		}
	}

	public function startCollapse($field = '', $title = 'panel')
	{
		if(!empty($field))
		{
			foreach ($this->input as $ikey => $ivalue)
			{
				if($ivalue['text'] == $field)
				{
					$this->startCollapse[$field] = $field;
					if(!empty($title))
					{
						$this->startCollapse['title'][$field] = $title;
					}
				}
			}
		}
	}

	public function endCollapse($field = '')
	{
		if(!empty($field))
		{
			foreach ($this->input as $ikey => $ivalue)
			{
				if($ivalue['text'] == $field)
				{
					$this->endCollapse[$field] = $field;
				}
			}
		}
	}

	public function setId($id = 0)
	{
		$this->id = @intval($id);
	}

	public function setLabel($field = '', $text = '')
	{
		if(!empty($field) && !empty($text))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->label[$field] = $text;
				}
			}
		}
	}

	public function setPlaintext($field = '', $text = '')
	{
		if(!empty($field) && !empty($text))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->plaintext[$field] = $text;
				}
			}
		}
	}

	public function setAttribute($field = '', $text = '')
	{
		if(!empty($field) && !empty($text))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->attribute[$field] = $text;
				}
			}
		}
	}


	public function setCheckBox($field = '', $option = array())
	{
		if(!empty($field) && !empty($option))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->checkbox[$field] = $option;
				}
			}
		}
	}

	public function setDelete($delete = true)
	{
		if(is_bool($delete))
		{
			$this->delete = $delete;
		}
	}

	public function setAccept($field = '', $accept = '')
	{
		if(!empty($field) && !empty($accept))
		{
			foreach ($this->input as $key => $value)
			{
				if($value['text'] == $field)
				{
					$this->accept[$field] = $accept;
				}
			}
		}
	}

	private function getInput($is_array = true)
	{
		$input = array();
		foreach ($this->input as $key => $value)
		{
			$input[] = $value['text'];
		}
		if(!in_array('id', $input))
		{
			$input[] = 'id';
		}
		if(!$is_array)
		{
			$input = implode('`,`', $input);
			$input = '`'.$input.'`';
		}
		return $input;
	}

	private function getData()
	{
		$data = array();
		if($this->init == 'roll')
		{
			$this->data_model->orderBy($this->orderby['index'], $this->orderby['sort']);
			if(!empty($this->where))
			{
				$this->data_model->setWhere($this->where);
			}
			$data = $this->data_model->get_data_list($this->table, $this->field, $this->getInput(), $this->limit);
		}else if($this->init == 'edit')
		{
			$data = $this->data_model->get_one_data($this->table, 'WHERE id = '.$this->id);
		}
		return $data;
	}

	public function getParam()
	{
		if(!empty($this->paramname))
		{
			return $this->data_model->get_one_data('config', "WHERE `name` = '{$this->paramname}'");
		}
	}

	public function form()
	{
		if(!empty($this->input))
		{
			$data = $this->getData();
			$message = array();
			if(!empty($_POST))
			{
				$message    = $this->action();
				$data       = $this->getData();
			}
			if(!empty($message))
			{
				msg($message['msg'],$message['alert']);
			}
			if($this->init == 'edit' || $this->init == 'param')
			{
				if($this->init == 'param')
				{
					if(!empty($this->param))
					{
						$name = $this->paramname;
						$data = json_decode($this->param['value'], 1);
					}else{
						$this->param = $this->getParam();
						$name = $this->paramname;
						$data = json_decode($this->param['value'], 1);
					}
				}
				$action = !empty($this->view) ? base_url($this->view).'/'.$this->id : '';
				?>
				<form method="post" action="<?php echo $action ?>" enctype="multipart/form-data">
					<div class="panel panel-default">
						<div class="panel panel-heading">
							<h4 class="panel-title">
								<?php echo !empty($this->id) ? 'Edit ' : 'Add '; echo $this->heading;?>
							</h4>
						</div>
						<div class="panel panel-body">
							<?php
							foreach ($this->input as $key => $value)
							{
								if(empty($data))
								{
									$this->setData();
									$data = $this->data;
								}
								if(array_key_exists($value['text'], $data))
								{
									$field    = !empty($value['text']) ? $value['text'] : '';
									$label    = !empty($this->label[$field]) ? $this->label[$field] : $field;
									$required = !empty($this->required[$field]) ? $this->required[$field] : '';

									if(!empty($this->startCollapse))
									{
										if(@$this->startCollapse[$value['text']] == $value['text'])
										{
											$collapse_title = !empty($this->startCollapse['title'][$value['text']]) ? $this->startCollapse['title'][$value['text']] : '';
											$this->open_collapse($value['text'], @$collapse_title);
										}
									}
									switch($value['type'])
									{
										case 'text':
											include 'input/text.php';
											break;
										case 'password':
											include 'input/password.php';
											break;
										case 'textarea':
											include 'input/textarea.php';
											break;
										case 'checkbox':
											include 'input/checkbox.php';
											break;
										case 'dropdown':
											include 'input/dropdown.php';
											break;
										case 'upload':
											include 'input/upload.php';
											break;
										case 'multiselect':
											include 'input/multiselect.php';
											break;
										case 'hidden':
											include 'input/hidden.php';
											break;
									}
									if(!empty($this->endCollapse))
									{
										if(@$this->endCollapse[$value['text']] == $value['text'])
										{
											$this->close_collapse();
										}
									}
								}else{
									echo '<b>unknown Column '.$value['text'].' in table '.$this->table.'</b><br>';
								}
							}
							?>
						</div>
						<div class="panel panel-footer">
							<?php
							echo form_button(array(
					      'name'    => 'submit',
					      'id'      => 'submit',
					      'value'   => 'true',
					      'type'    => 'success',
					      'content' => 'submit',
					      'class'   => 'btn btn-success'));
							echo form_button(array(
					      'name'    => 'reset',
					      'id'      => 'reset',
					      'value'   => 'true',
					      'type'    => 'reset',
					      'content' => 'reset',
					      'class'   => 'btn btn-warning'));
							?>
						</div>
					</div>
				</form>
				<?php
			}else if($this->init == 'roll')
			{
				$pagination = $data['pagination'];
				$data = $data['data'];
				$pagination = !empty($data) ? $pagination : '';
				$message = array();
				?>
				<h4 class="panel-title">
					<?php echo $this->heading;?>
				</h4>
				<br>
				<form method="post" action="<?php echo !empty($this->view) ? base_url($this->view) : ''; ?>" enctype="multipart/form-data">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<?php
									foreach ($this->input as $key => $value)
									{
										if(empty($data))
										{
											$this->setData();
											$data = $this->data;
										}
										if(array_key_exists($value['text'], $data[0]))
										{
											$field    = !empty($value['text']) ? $value['text'] : '';
											$label    = !empty($this->label[$field]) ? $this->label[$field] : $field;
											echo '<th>'.ucwords($label).'</th>';
										}
									}
									if($this->delete == true)
									{
										?>
										<th>
											<div class="checkbox">
												<label>
													<input id="selectAllDel" type="checkbox">DELETE
												</label>
											</div>
										</th>
										<?php
									}

								 ?>
								</tr>
							</thead>
							<tbody>
								<?php
								if(!empty($data))
								{
									foreach ($data as $dkey => $dvalue)
									{
										if(!empty($dvalue['id']))
										{
											?>
											<tr data-id="<?php echo $dvalue['id'] ?>">
												<?php
												foreach ($this->input as $ikey => $ivalue)
												{
													$field    = !empty($ivalue['text']) ? $ivalue['text'] : '';
													$label    = !empty($this->label[$field]) ? $this->label[$field] : $field;
													$required = !empty($ivalue['required']) ? $ivalue['required'] : '';
													$image    = !empty($this->image[$field]) ? $this->image[$field] : '';

													if(isset($dvalue[$ikey]))
													{
														echo '<td>';
															switch ($ivalue['type'])
															{
																case 'text':
																	include 'input/text.php';
																	break;
																case 'plaintext':
																	include 'input/plaintext.php';
																	break;
																case 'thumbnail':
																	include 'input/thumbnail.php';
																	break;
																case 'link':
																	include 'input/link.php';
																	break;
																case 'textarea':
																	include 'input/textarea.php';
																	break;
																case 'checkbox':
																	include 'input/checkbox.php';
																	break;
																case 'dropdown':
																	include 'input/dropdown.php';
																	break;
																case 'upload':
																	include 'input/upload.php';
																	break;
																case 'multiselect':
																	include 'input/multiselect.php';
																	break;
																case 'hidden':
																	include 'input/hidden.php';
																	break;
															}
														echo '</td>'	;
													}
												}
												if($this->delete == true)
												{
													?>
													<td>
														<div class="checkbox">
															<label>
																<input type="checkbox" class="del_check" name="del_row[]" value="<?php echo $dvalue['id']; ?>"> <span class="glyphicon glyphicon-trash"></span>
															</label>
														</div>
													</td>
													<?php
												}
												?>
											</tr>
											<?php
										}
									}
									$tot_col = count($this->input);
									?>
									<tr>
										<td colspan="<?php echo $tot_col; ?>"><?php echo !empty($pagination) ? $pagination : ''; ?></td>
										<?php
										if($this->delete)
										{
											?>
											<td>
												<button type="submit" name="delete" value="1" class="btn btn-danger btn-sm">
													<span class="glyphicon glyphicon-trash"></span> DELETE
												</button>
											</td>
											<?php
										}
										?>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</form>
				<?php
			}
		}
	}

	public function action()
	{
		if(!empty($_POST))
		{
			if($this->init == 'edit' || $this->init == 'param')
			{
				$data = array();
				if(!empty($_POST))
				{
					foreach ($_POST as $key => $value)
					{
						if(is_array($value))
						{
							$_POST[$key] = ','.implode(',',$value).',';
						}
					}
					if(!empty($_POST['submit']))
					{
						unset($_POST['submit']);
						if(isset($_POST['password']))
						{
							$_POST['password'] = md5($_POST['password']);
						}
						if(!empty($this->table))
						{
							$data['msg']   = 'Data Failed to Save';
							$data['alert'] = 'danger';

							$upload = array();
							$title  = '';

							foreach ($this->input as $key => $value)
							{
								if($value['type'] == 'upload')
								{
									$upload[] = $value['text'];
								}
								$_POST[$value['text']] = @$_POST[$value['text']];
							}

							foreach ($this->input as $key => $value)
							{
								if($value['type'] == 'text')
								{
									$title = $value['text'];
									break;
								}
							}
							if($this->init == 'edit')
							{
								if($this->data_model->set_data($this->table, $this->id, $_POST))
								{
									$data['msg']   = 'Data Saved Successfully';
									$data['alert'] = 'success';
								}
							}else if($this->init == 'param')
							{
								$data_param = array();
								if(!empty($_POST))
								{
									$data_param['name'] = $this->paramname;
									$data_param['value'] = json_encode($_POST);
								}
								if($this->data_model->set_param($this->table, $this->paramname, $data_param))
								{
									$data['msg']   = 'Data Saved Successfully';
									$data['alert'] = 'success';
								}
							}
							if(!empty($upload))
							{
								$i = 0;
								$dir_image = '';
								if($this->init == 'edit')
								{
									$dir_image = !empty($this->id) ? $this->id : $this->data_model->LAST_INSERT_ID();
								}else if($this->init == 'param'){
									$dir_image = $this->paramname;
								}
								foreach ($upload as $u_key => $u_value)
								{
									$_POST[$u_value] = !empty($_POST[$title]) ? $u_value.'_'.$_POST[$title] : 'image';
									if(!empty($_FILES[$upload[$i]]['name']) && empty($_FILES[$upload[$i]]['error']))
									{
										$module = !empty($this->table) ? 'modules/'.$this->table : 'uploads';
										$dir = FCPATH.'images/'.$module.'/'.$dir_image.'/';
							      if(!is_dir($dir))
							      {
							        mkdir($dir, 0777,1);
							      }
						        $ext = pathinfo($_FILES[$upload[$i]]['name']);
						        $file_name = $_POST[$u_value].'_'.time().'.'.$ext['extension'];
						        copy($_FILES[$upload[$i]]['tmp_name'], $dir.$file_name);
						        if($this->init == 'edit')
						        {
						        	$update_file = array($u_value => $file_name);
						        	$this->data_model->set_data($this->table, $dir_image, $update_file);
						        }else if($this->init == 'param')
						        {
							        foreach ($_POST as $dp_key => $dp_value)
							        {
							        	if($dp_key=='image')
							        	{
							        		$_POST[$dp_key] = $file_name;
							        	}
							        }
							        $data_param['value'] = json_encode($_POST);
							        $data_param['name'] = $dir_image;
							        $this->data_model->set_param($this->table, $dir_image, $data_param);
						        }
									}
									$i++;
								}
							}
						}else{
							$data['msg'] = 'Table Undefined';
							$data['alert'] = 'error';
						}
					}
				}
				return $data;
				// $this->data_model->get_input_post();
			}else if($this->init == 'roll')
			{
				$data = array();
				if(!empty($this->table))
				{
					if(!empty($_POST['delete']))
					{
						$data['msg']   = 'No Data Selected to Delete';
						$data['alert'] = 'success';
						if(!empty($_POST['del_row']))
						{
							$data['msg']   = 'Data Deleted Successfully';
							$data['alert'] = 'success';
							$this->data_model->del_data($this->table, $_POST['del_row']);
						}
					}
				}else{
					$data['msg'] = 'Table Undefined';
					$data['alert'] = 'error';
				}
				return $data;
			}
		}
	}

	/*=====================================================
	 * $data[]	= array(
	 			'id'			=> $id
	 		, 'par_id'	=> $par_id
	 		, 'title'		=> $title);
	 *====================================================*/
	function array_path($data, $par_id = 0, $separate = ' / ', $prefix = '', $load_parent = '')
	{
		$output = array();
		foreach((array)$data AS $dt)
		{
			if($dt['par_id'] == $par_id)
			{
				if(empty($load_parent))
				{
					$text = ($par_id==0) ? $prefix.$dt['title'] : $prefix.$separate.$dt['title'];
					$output[$dt['id']] = $text;
				}else{
					$output[$dt['id']] = ($par_id==0) ? $prefix.$dt['title'] : $prefix.$separate.$dt['title'];
					$text	= ($par_id==0) ? $prefix.$load_parent : $prefix.$separate.$load_parent;
				}
				$r = $this->array_path($data, $dt['id'], $separate, $text, $load_parent);
				if(!empty($r)) {
					foreach($r AS $i => $j)
						$output[$i] = $j;
				}
			}
		}
		return $output;
	}
	function createOption($arr, $select='')
	{
		$output = '';
		$valueiskey	= $check_first = false;
		foreach((array)$arr AS $key => $dt){
			if(is_array($dt)){
				list($value, $caption) = array_values($dt);
				if(empty($caption)) $caption = $value;
			}else{
				if(!$check_first) {
					if((is_numeric($key) && $key != 0)
					|| (is_string($key) && !is_numeric($key))) {
						$valueiskey = true;
					}
					$check_first = true;
				}
				if(empty($dt) && !empty($key)) $dt = $key;
				$value = $valueiskey ? $key : $dt;
				$caption = $dt;
			}
			if(isset($select)){
				if(is_array($select)) $selected = (in_array($value, $select)) ? ' selected="selected"':'';
				else    $selected = ($value==$select) ? ' selected="selected"':'';
			}else{
				$selected = '';
			}
			$output .= "<option value=\"$value\"$selected>$caption</option>";
		}
		return $output;
	}
}