<?php 

class raven{
	//private $legCount;
	protected $legCount;
	//public $legCount;
		
	//echo $this->legCount=10;	doesn't work 
	
	public function foo(){
			echo $this->legCount=10;
	}
}