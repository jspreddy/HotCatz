<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller{
	public $data = array(
		'login_title'=>APPLICATION_NAME,
		'msg'=>''
	);
	
	public function __construct()
	{
		parent::__construct();
		$this->output->nocache();
	}
	
	public function index($type="")
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('/home');
		}
		
		if($type==""){
			$type=$this->uri->segment(3);
		}
		$this->data['msg'] = $type;
		$this->load->view('components/header');
		$this->load->view('components/login_box',$this->data);
		$this->load->view('components/footer');
	}
	
	public function login()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('/home');
		}
		
		$this->load->model('user_model','user');
		//check if already logged in
		if($this->session->userdata('logged_in'))
		{
			redirect('/home');
		}
		
		$username = strtolower($this->security->xss_clean($this->input->post('username')));
		$password = $this->security->xss_clean($this->input->post('password'));
		
		$this->load->model('user_model','user');
		
		$row=$this->user->get_by('uname',$username);
		
		if(count($row)==0){
			$this->index("loginFail");
			return false;
		}
		if( $row->email_verified==false){
			$this->index("emailverify");
			return false;
		}
		
		$this->load->library('encrypt');
		$enc_pass = $this->encrypt->sha1($password);

		if($row->passwd == $enc_pass){
			$this->session->set_userdata('userid',intval($row->userId_pk));
			$this->session->set_userdata('uname',$row->uname);
			$this->session->set_userdata('logged_in',TRUE);
			redirect('/home');
			return false;
		}
		else{
			if($this->session->userdata('logged_in'))
			{
				$this->session->set_userdata('logged_in',FALSE);
			}
			$this->session->sess_destroy();
			$this->index("loginFail");
			return false;
		}
	}
	
	public function logout()
	{
		//delete session
		if($this->session->userdata('logged_in'))
		{
			if($this->session->userdata('logged_in'))
			{
				$this->session->set_userdata('logged_in',FALSE);
			}
			$this->session->sess_destroy();
		}
		$this->index("logoutSuccess");
		return false;
	}
	
}
/* End of file auth.php */
/* Location:  ./application/controllers/auth.php*/