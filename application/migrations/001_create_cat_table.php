<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cat_table extends CI_Migration {

	public function up()
	{
		$this->load->dbforge();
		$this->db->query(
			"CREATE TABLE IF NOT EXISTS `cat` (
			  `catId_pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `userId_fk` int(11) unsigned NOT NULL,
			  `cname` varchar(256) NOT NULL,
			  `cimage` varchar(256) NOT NULL,
			  `voteweight` bigint(20) unsigned NOT NULL,
			  PRIMARY KEY (`catId_pk`),
			  UNIQUE KEY `cname` (`cname`),
			  KEY `userId_fk` (`userId_fk`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 "
		);
	}

	public function down()
	{
		$this->dbforge->drop_table('cat');
	}
}
