<?php

class chest{//bad example.. 
	
	protected $lock;
	protected $isClosed;
	
	public function __construct(Lock $lock){//what is this lock $lock, type cast? what is type cast? Why and how to use it?
		$this->lock = $lock; 
	}
	
	public function close($lock = true){// what is point to do this?
		if($lock === true){
			$this->lock->lock();//yes, pass $lock(class) in chest class on html.php
		}
		$this->isClosed = true;
		
		echo 'Closed';
	}
	
	public function open(){
		if($this->lock->isLocked()){//yes, pass $lock(class) in chest class on html.php
			$this->lock->unlock();	
		}
		$this->isClosed = false; 
		
		echo 'opened';
	}
	
	public function isClosed(){//show isClosed
			return $this->isClosed;
	}


}