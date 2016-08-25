<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register extends Public_Controller{
	private $email_verifications;
	
	public function __construct()
	{
		parent::__construct();
		if ( ! $this->migration->latest())
		{
			show_error($this->migration->error_string());
			exit;
		}
		$this->output->nocache();
		$this->load->library('form_validation');
		if($this->session->userdata('logged_in'))
		{
			redirect('/home');
		}
		$this->email_verifications = $this->config->item('email_verifications');
	}
	
	public function index($val_errors = null)
	{
		$this->data['val_errors'] = $val_errors;
		$this->load->view('components/header');
		$this->load->view('components/registration_box',$this->data);
		$this->load->view('components/footer');
	}
	
	public function submit()
	{
		$this->load->model('user_model','user');
		$this->load->library('encrypt');
		
		$validation_rules = array(
			array(
				  'field'   => 'username',
				  'label'   => 'Email Id',
				  'rules'   => 'trim|required|matches[retype_username]|is_unique[user.uname]'
			   ),
			array(
				  'field'   => 'retype_username',
				  'label'   => 'Email confirmation',
				  'rules'   => 'trim|required'
			   ),
			array(
				  'field'   => 'password',
				  'label'   => 'Password',
				  'rules'   => 'trim|required|matches[password_conf]|min_length[5]|max_length[15]|alpha_numeric'
			   ),
			array(
				  'field'   => 'password_conf',
				  'label'   => 'Password confirmation',
				  'rules'   => 'trim|required'
			   )
		 );
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules($validation_rules);
		if ($this->form_validation->run() == FALSE)
		{
			$this->index(validation_errors());
			return false;
		}
		else
		{
			if($this->email_verifications){
				// if we are doing email verifications, then store the email verified as false else make it true.
				$email_verified = false;
			}
			else{
				$email_verified = true;
			}
			// save data and email verification.
			$save_data["uname"] = $this->input->post("username");
			$save_data["email_verified"] = $email_verified;
			$save_data["passwd"] = $this->encrypt->hash($this->input->post("password"));
			$save_data["veri_code"] = random_string('alnum',TOKEN_SIZE);
			
			$result = $this->user->insert($save_data);
			
			if($result === false){
				$this->index("Unknown error while saving data.");
				return false;
			}
			if($this->email_verifications){
				$this->load->library('email');

				$this->email->from('jspreddy@yahoo.com', 'HotCatz-jspreddy');
				$this->email->to($save_data["uname"]);

				$this->email->subject('Email verification for HotCatz-jspreddy application');
				$message = 'Please verify your email by clicking the following link.\n\r <br/> ';
				$message .= site_url('/register/verify')."/".$result."_".$save_data["veri_code"];
				$this->email->message($message);

				$this->email->send();

				$this->_display_alert_page("alert-success", "An email has been sent to <b>".$save_data["uname"]."</b>. Please go verify.");
			}
			else{
				$this->_display_alert_page("alert-success", "Your registration is a success, you can now login. Click on the logo above to go to login page.");
			}
		}
	}
	
	public function verify()
	{
		$this->load->model('user_model','user');
		$linkCode=$this->uri->segment(3);
		if($linkCode == false){
			$this->_display_alert_page("alert-danger", "Corrupted link, contact helpdesk.");
			return false;
		}
		$temp = explode('_',$linkCode);
		if(count($temp)!=2){
			$this->_display_alert_page("alert-danger", "Corrupted link, contact helpdesk.");
			return false;
		}
		$userId = intval($temp[0]);
		$veri_code = $temp[1];
		
		$row = $this->user->get($userId);
		if(intval($row->email_verified) == 0){
			$this->_display_alert_page("alert-success", "You can now login. Click on logo to go to login page.");
		}
		if($row->veri_code == $veri_code ){
			$this->user->update($userId, array('email_verified'=>true));
			$this->_display_alert_page("alert-success", "Your email has been verified. You can now go login. Click on the logo on top to go to login page.");
		}
		
	}
	
	private function _display_alert_page( $alertType="alert-danger", $message="")
	{
		$this->load->view('components/header');
		$this->load->view('components/alertBox',array("alertType"=>$alertType, "message"=>$message) );
		$this->load->view('components/footer');
	}
}
/* End of file register.php */
/* Location:  ./application/controllers/register.php*/
