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
			$val_errors = validation_errors();
			if($val_errors == ""){
				$val_errors = "Bad request. Refresh and try again.";
			}
			$this->result["error"] = $val_errors;
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		
		$this->result["data"]["newUpload"]["imageLink"] = base_url("/imagestore/".$catpic_upload_data["file_name"]);
		$this->result["data"]["newUpload"]["catName"] = $catname;
		$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
	}
	
	public function getNewMatchup()
	{
		$this->load->model("user_model","user");
		
		$this->cat->order_by("catId_pk","RANDOM");
		$this->cat->limit(2);
		$cats = $this->cat->get_all();
		
		if(count($cats)< 2){
			$this->result["error"]="Not enough Catz to vote on. Get more Catz to sign up!";
			$this->result["data"]="";
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		
		$voteToken = random_string('alnum',TOKEN_SIZE);
		$currentVoteForUser = array(
			"voteToken"=>$voteToken,
			"cat1_fk"=>$cats[0]->catId_pk,
			"cat2_fk"=>$cats[1]->catId_pk
			);
		$this->user->update($this->_get_userId(), $currentVoteForUser);
		
		$this->result["data"]["matchup"]["voteToken"]=$voteToken;
		
		for($i=0;$i<2;$i++){
			$this->result["data"]["matchup"][$i]["id"]=$cats[$i]->catId_pk;
			$this->result["data"]["matchup"][$i]["name"]=$cats[$i]->cname;
			$this->result["data"]["matchup"][$i]["cimage"]=base_url("/imagestore/".$cats[$i]->cimage);
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
	}
	
	public function leaderBoard()
	{
		
	}
	
	public function vote()
	{
		$id = $this->security->xss_clean($this->input->post('id'));
		$voteToken = $this->security->xss_clean($this->input->post('voteToken'));
		
		if( !is_int(intval($id)) ){
			$this->result["error"]="Vote ImageId Error. Refresh and try again.";
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		if(strlen($voteToken) !== TOKEN_SIZE){
			$this->result["error"]="TokenSizeError. Refresh and try again.";
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		$catId = intval($id);
		$this->load->model("user_model","user");
		
		$userObj = $this->user->get($this->_get_userId());
		if(!in_array($catId,array($userObj->cat1_fk, $userObj->cat2_fk))){
			$this->result["error"]="Bad Request. Refresh and try again.";
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		
		if($userObj->voteToken !== $voteToken){
			$this->result["error"]="VotingTokenError. Refresh and try again.";
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		
		$this->load->model("vote_model","vote");
		
		$voteStatus = $this->vote->insert(array(
			"userId_fk"=>$this->_get_userId(),
			"cat1_fk"=>$userObj->cat1_fk,
			"cat2_fk"=>$userObj->cat2_fk,
			"votedFor_fk"=>$catId,
			"dateTime"=>date('Y-m-d H:i:s')
		));
		
		$this->cat->incrementVoteWeightOn(1, $catId);
		
		if($voteStatus == false){
			$this->result["error"]="Error Saving Vote. Refresh and try again.";
			$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
			return false;
		}
		
		$this->user->update($this->_get_userId(),array("VoteToken"=>null, "cat1_fk"=>null, "cat2_fk"=>null));
		
		$this->output->set_content_type('application/json')->set_output(json_encode($this->result));
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