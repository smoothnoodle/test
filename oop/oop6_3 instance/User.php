<?php 

class User{
		
	public function create(array $data){
		$db = Database::getInstance();
		
		$db->query('INSERT INTO `users`...');
	}
	

	
}