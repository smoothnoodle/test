<?php

class Collection implements Countable, JsonSerializable {
	
	protected $item = [];
	
	// __set()
	// __get()
	// __call()
	// __toString()
	
	public function __set($key, $value){
			$this->set($key, $value);
	}
	
	public function __get($value){//this cost problem 2:48-3:22
			return $this->get($value);
	}
	
	public function add($value){//good
		$this->items[] =$value;
	}
	
	public function get($key){
		return array_key_exists($key, $this->items) ? $this->items[$key]:null;
	}

	public function set($key, $value){//similar to add
		$this->items[$key] = $value;
	}

	public function JsonSerialize(){
		return json_encode($this->items);
	}
	
	public function count(){
		return count($this->items);
	}
	
	public function all(){
		return $this->items;
	}

}