<?php

class Collection implements Countable, JsonSerializable {
	protected $item = [];
	
	public function add($value){
		$this->items[] =$value;
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

}