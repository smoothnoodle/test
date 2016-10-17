<?php

class lock {
	
	protected $isLocked;
	
	
	public function lock(){//set value $isLocked to true
		$this->isLocked = true; 
	}
	
	public function unlock(){//set value $isLocked to false
		$this->isLocked = false; 
	}
	
	public function isLocked(){//show $isLocked 
		return $this->isLocked;
	}

}