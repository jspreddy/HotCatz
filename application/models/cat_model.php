<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cat_model extends MY_Model{
	public $_table='cat';
	public $primary_key='catId_pk';
	
	public function incrementVoteWeightOn($weight, $id)
	{
		$this->db->query('UPDATE `cat` SET `voteweight` = `voteweight` + ? WHERE `catId_pk`= ?', array($weight, $id));
	}
	
}

/* End of file cat_model.php */
/* Location:  ./application/models/cat_model.php*/
