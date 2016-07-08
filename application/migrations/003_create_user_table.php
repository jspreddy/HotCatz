<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_user_table extends CI_Migration {

	public function up()
	{
		$this->load->dbforge();
		$this->db->query(
			"CREATE TABLE IF NOT EXISTS `user` (
			  `userId_pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `uname` varchar(256) NOT NULL,
			  `email_verified` tinyint(1) NOT NULL,
			  `passwd` varchar(256) NOT NULL,
			  `veri_code` varchar(6) NOT NULL,
			  `voteToken` varchar(6) DEFAULT NULL,
			  `cat1_fk` int(11) unsigned DEFAULT NULL,
			  `cat2_fk` int(11) unsigned DEFAULT NULL,
			  PRIMARY KEY (`userId_pk`),
			  KEY `cat1_fk` (`cat1_fk`,`cat2_fk`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1"
		);
	}

	public function down()
	{
		$this->dbforge->drop_table('user');
	}
}