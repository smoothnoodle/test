<?php

class Collection implements Countable, JsonSerializable{
	
	protected $items =[];
	
	// __set()
	// __get()
	// __call()
	// __toString()
	
	public function __set($key, $value){
			$this->set($key, $value);
	}
	
	public function __set($value){
			$this->items[] = $value;
	}
	
}