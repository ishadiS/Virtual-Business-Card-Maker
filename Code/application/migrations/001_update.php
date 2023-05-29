<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update extends CI_Migration {

	public function __construct() {
		parent::__construct();
		$this->load->dbforge();
	}

	public function up() {  

		$fields = array(
			'cards' => array(
				'type' => 'INT',
				'default' => 1
			)
		);
		$this->dbforge->add_column('plans', $fields);

		$fields = array(
			'saas_id' => array(
				'type' => 'INT'
			),
			'google_analytics' => array(
				'type' => 'TEXT'
			)
		);
		$this->dbforge->add_column('cards', $fields);
		$this->db->query("UPDATE cards SET saas_id=user_id");

		$this->db->query("ALTER TABLE products ADD saas_id INT(11) NOT NULL AFTER id");
		$this->db->query("UPDATE products SET saas_id=user_id");

		$this->db->query("CREATE TABLE portfolio
		(
		id INT AUTO_INCREMENT PRIMARY KEY,
		saas_id INT NOT NULL,
		user_id INT NOT NULL,
		card_id INT NOT NULL,
		title TEXT NOT NULL,
		description TEXT NOT NULL,
		image TEXT NOT NULL,
		url TEXT NOT NULL,
		created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)");
		$this->db->query("INSERT INTO portfolio (saas_id, user_id, card_id, title, description, image, url) SELECT saas_id, user_id, card_id, title, description, image, url FROM products WHERE type='portfolio'");

		$this->db->query("CREATE TABLE testimonials
		(
		   id INT AUTO_INCREMENT PRIMARY KEY,
		   saas_id INT NOT NULL,
		   user_id INT NOT NULL,
		   card_id INT NOT NULL,
		   title TEXT NOT NULL,
		   description TEXT NOT NULL,
		   image TEXT NOT NULL,
		   rating TEXT NOT NULL,
		   created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)");
		$this->db->query("INSERT INTO testimonials (saas_id, user_id, card_id, title, description, image, rating) SELECT saas_id, user_id, card_id, title, description, image, price FROM products WHERE type='testimonials'");

		
		$this->db->query("CREATE TABLE gallery
		(
		   id INT AUTO_INCREMENT PRIMARY KEY,
		   saas_id INT NOT NULL,
		   user_id INT NOT NULL,
		   card_id INT NOT NULL,
		   content_type TEXT NOT NULL,
		   title TEXT NOT NULL,
		   url TEXT NOT NULL,
		   created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)");
		$this->db->query("DELETE FROM products WHERE type != 'products'");
		$this->db->query("ALTER TABLE products DROP `type`");

		$this->db->set('value', '1.4');
        $this->db->where('type', 'system_version');
        $this->db->update('settings');

	}

	public function down() {
	}
}
