<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cat extends CI_Migration {

	public function up()
	{
		$this->load->dbforge();
		$this->dbforge->add_field(array(
			'catId_pk' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'constraint' => 11,
				'auto_increment' => TRUE,
				'null'=>FALSE
			),
			'userId_fk' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'constraint' => 11,
				'null'=>FALSE
			),
			'cname' => array(
				'type' => 'VARCHAR',
				'constraint' => 256,
				'unique' =>TRUE
			),
			'cimage' => array(
				'type' => 'VARCHAR',
				'constraint' => 256
			),
			'voteweight' => array(
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'constraint' => 20,
				'null'=>FALSE
			),
		));
		$this->dbforge->add_key('catId_pk', TRUE);
		$this->dbforge->add_key('userId_fk');
		$this->dbforge->create_table('cat',TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('cat');
	}
}
