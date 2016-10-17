<?php 

class Bird{
	//private $canfly;
	//protected $canfly;
	public $canfly;
	
	//private $legCount;//penguin can't access it: Notice: Undefined property: penguin::$legCount in C:\xampp\htdocs\test\oop\penguin.php on line 6
	//protected $legCount;//work on penguin
	public $legCount;
	
	public function __construct($canFly, $legCount){
		$this->canFly = $canFly;
		$this->legCount = $legCount;
	}
	
	public function canFly(){//case sensitive!!!
			return $this->canFly;//case sensitive!! wasted me 3 days
	}
	
	public function getlegCount(){
			return $this->legCount;
	}
}
// you don't even a close