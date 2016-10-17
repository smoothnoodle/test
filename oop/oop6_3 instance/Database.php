<?php 

class Database{
	
	protected static $instance;
	
	public static function getInstance(){
		if(!static::$instance){
			static::$instance = new self;//new database?
		}
		return static::$instance;
	}

	public function query($sql){//checked 
		//this->pdo->prepare($sql)->execute();
		echo $sql;
	
	}

};