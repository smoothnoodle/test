<?php 

class User{//checked
	
	protected $db;
	
	public function __construct(Database $db){//dependency injection
		$this->db = $db;
	}


	public function create(array $data){
		$this->db->query('INSERT INTO `users`...');
	}
	
}