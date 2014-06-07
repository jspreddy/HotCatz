<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Output extends CI_Output{
	
	function nocache(){
		$this->set_header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
		$this->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
		$this->set_header("Pragma: no-cache");
	}
}

/* End of file MY_output.php */
/* Location:  ./application/core/MY_Output.php*/