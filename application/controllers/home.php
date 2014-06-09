<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index($val_errors = null)
	{
		$this->load->view('components/header');
		$this->load->view('components/navBar', $this->data);
		$this->load->view('home_page');
		$this->load->view('components/footer');
	}
}

/* End of file home.php */
/* Location:  ./application/controllers/home.php*/