<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_user_table extends CI_Migration {

	public function up()
	{
		$this->load->dbforge();
		$this->db->query(
			"CREATE TABLE IF NOT EXISTS `vote` (
			  `voteId_pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `userId_fk` int(11) unsigned NOT NULL,
			  `cat1_fk` int(11) unsigned NOT NULL,
			  `cat2_fk` int(11) unsigned NOT NULL,
			  `votedFor_fk` int(11) unsigned NOT NULL,
			  `dateTime` datetime NOT NULL,
			  PRIMARY KEY (`voteId_pk`),
			  KEY `userId_fk` (`userId_fk`,`cat1_fk`,`cat2_fk`,`votedFor_fk`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 "
		);
	}

	public function down()
	{
		$this->dbforge->drop_table('vote');
	}
}