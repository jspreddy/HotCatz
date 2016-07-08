<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ci_sessions_table extends CI_Migration {

	public function up()
	{
		$this->load->dbforge();
		$this->db->query(
			"CREATE TABLE IF NOT EXISTS `ci_sessions` (
			  `session_id` varchar(40) NOT NULL DEFAULT '0',
			  `ip_address` varchar(45) NOT NULL DEFAULT '0',
			  `user_agent` varchar(120) NOT NULL,
			  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
			  `user_data` text NOT NULL,
			  PRIMARY KEY (`session_id`),
			  KEY `last_activity_idx` (`last_activity`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1"
		);
	}

	public function down()
	{
		$this->dbforge->drop_table('ci_sessions');
	}
}