<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	private $uname="";
	private $userId="";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->output->nocache();
		
		if(!$this->session->userdata('logged_in')){
			$this->session->sess_destroy();
			if($this->input->is_ajax_request()) {
				redirect('/auth/index/unauth','location',401);
			}
			else{
				redirect('/auth/index/unauth');
			}
		}
		
		$this->uname = $this->session->userdata('uname');
		$this->userId = intval( $this->session->userdata('userid') );
		
		$this->data=array(
			'appName'=>APPLICATION_NAME,
			'fullUserName'=> $this->session->userdata('username')
		);
	}
	
	private function _get_uname(){
		return $this->uname;
	}
	
	private function _get_userId(){
		return $this->userId;
	}
}

/* End of file MY_Controller.php */
/* Location: /application/core/MY_Controller.php */
