<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MY_Controller{
	
	private $result=array();
	
	public function __construct()
	{
		parent::__construct();
		
		$this->result["error"]="";
		$this->result["data"]="";
		$this->load->library('form_validation');
		$this->load->model("cat_model","cat");
	}
	
	public function index()
	{
		
	}
	
	public function add()
	{
		$upload_config['upload_path'] = './imagestore/';
		$upload_config['allowed_types'] = 'gif|jpg|png';
		$upload_config['encrypt_name'] = true;
		$upload_config['remove_spaces'] = true;
		
		$this->form_validation->set_rules("catname", "Cat's name", "trim|required|min_length[2]|max_length[50]|is_unique[cat.cname]|xss_clean" );
		
		if ($this->form_validation->run() == TRUE) {
			$catname = $this->input->post('catname');
			$userId = $this->_get_userId();
			$this->load->library('upload', $upload_config);
			
			if (!$this->upload->do_upload('catpic')) {
				$this->result["error"] = $this->upload->display_errors();
				$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
				return false;
			} else {
				$catpic_upload_data = $this->upload->data();
				$temp = $this->_resize_and_crop($catpic_upload_data);
				if($temp !== true){
					$this->result["error"] = $temp;
					$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
					return false;
				}
				
				$insertResult = $this->cat->insert(array(
					'cname' => $catname,
					'userId_fk' => $userId,
					'cimage' => $catpic_upload_data['file_name'],
					'voteweight' => 0
				));
				
				if($insertResult === false){
					$this->result["error"] = "Database Error. Please try again or contact helpdesk.";
					$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
					return false;
				}
				
				//$this->result["data"]=;
				
			}
		} else {
			$this->result["error"] = validation_errors();
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		
		$this->result["data"]["newUpload"]["imageLink"] = base_url("/imagestore/".$catpic_upload_data["file_name"]);
		$this->result["data"]["newUpload"]["catName"] = $catname;
		$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
	}
	
	public function getNewMatchup()
	{
		
	}
	
	public function leaderBoard()
	{
		
	}
	
	public function vote()
	{
		
	}
	
	
	
	private function _resize_and_crop($data)
	{
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = $data['full_path'];
		$config['create_thumb'] = false;
		$config['width'] = 268;
		$config['height'] = 295;
		//resize config
		$config['maintain_ratio'] = TRUE;
		
		if($data["image_height"] > $data["image_width"]){
			$config['master_dim'] = "width";
		}
		else{
			$config['master_dim'] = "height";
		}
		
		$this->image_lib->initialize($config);
		if(  !$this->image_lib->resize() ){
			return $this->image_lib->display_errors();
		}
		
		//crop config
		$config['x_axis'] = '0';
		$config['y_axis'] = '0';
		$config['master_dim'] ='auto';
		$config['maintain_ratio'] = FALSE;
		$this->image_lib->initialize($config);
		
		if(!$this->image_lib->crop()){
			return $this->image_lib->display_errors();
		}
		
		return true;
	}
}

/* End of file home.php */
/* Location:  ./application/controllers/home.php*/