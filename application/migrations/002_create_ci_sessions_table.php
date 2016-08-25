<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ci_sessions_table extends CI_Migration {

	public function up()
	{
		$this->load->dbforge();
		$this->db->query(
			"CREATE TABLE IF NOT EXISTS `ci_sessions` (
				`id` varchar(40) NOT NULL,
				`ip_address` varchar(45) NOT NULL,
				`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
				`data` blob NOT NULL,
				KEY `ci_sessions_timestamp` (`timestamp`)
			);"
		);
	}

	public function down()
	{
		$this->dbforge->drop_table('ci_sessions');
	}
}
