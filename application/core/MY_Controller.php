<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_DB $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Cart $cart                        Shopping Cart Class
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property MY_Controller $controller            This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      //dead
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property MY_Model $model                      CodeIgniter Model Class
 * @property MY_Output $output                    Responsible for sending final output to browser
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Jquery $jquery                    Jquery Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 * @property CI_Driver_Library $driver            CodeIgniter Driver Library Class
 * @property CI_Cache $cache                      CodeIgniter Caching Class
 * @property CI_Migration $migration              Migrations class.
 */
class MY_Controller extends CI_Controller{

}


class Public_Controller extends MY_Controller{

}


class Private_Controller extends MY_Controller{

	private $uname="";
	private $userId="";


	public function __construct()
	{
		parent::__construct();
		$this->output->nocache();
		if ( ! $this->migration->latest())
		{
			show_error($this->migration->error_string());
			exit;
		}

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
			'data_appName'=>APPLICATION_NAME,
			'data_username'=> $this->session->userdata('uname')
		);
	}

	protected function _get_uname(){
		return $this->uname;
	}

	protected function _get_userId(){
		return $this->userId;
	}
}
