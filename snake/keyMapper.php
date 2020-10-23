<?php

class KeyMapper {
	CONST NORTH ='w';
	CONST WEST = 'a';
	CONST SOUTH = 's';
	CONST EAST = 'd';
	private $stdin; 
	private $direction=null;
	public $alive;
	public function __construct(){
		system('stty cbreak');

		$this->alive=true;
		
		
	}
	
	public function getDirection(){
		return $this->direction;
	}
	public function loop(){
		while($this->alive){
			$this->update();
		}
	}
	public function update(){
		$key="";
			if($this->non_block_read(STDIN,$key)){
				$this->setDirection($key);
			}
	}
	private function non_block_read($fd, &$data) {
		$read = array($fd);
		$write = array();
		$except = array();
		$result = stream_select($read, $write, $except, 0);
		if($result === false) throw new Exception('stream_select failed');
		if($result === 0) return false;
		$data = stream_get_line($fd, 1);
		return true;
	}
	public function setDirection($key){
		try {
			switch ($key) {
				case $key == self::NORTH:
					$this->direction= 'NORTH';
					break;
				case $key == self::EAST:
					$this->direction = 'EAST';
					break;
				case $key == self::SOUTH:
					$this->direction = 'SOUTH';
					break;
				case $key == self::WEST:
					$this->direction= 'WEST';
					break;
			}
		} catch (Exception $e) {
		}
		
	}

}