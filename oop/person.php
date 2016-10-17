<?php 

class person{
	public $name;
	public $age; 
	
	public function __construct($name, $age){//magic method
		$this->name = $name;
		$this->age = $age;
	}
	//}; no good 
	
	
	public function sentence(){
		return $this->name. ' is ' . $this->age . ' years old';
	}
}

?>