<?php

include_once('keyMapper.php');

class Snake {
	CONST NORTH = 1;
	CONST EAST = 2;
	CONST SOUTH = 3;
	CONST WEST = 4;
	private $body=[];
	private $size=0;
	private $direction;
	private $keyMapper;
	public $growing=false;
	public function __construct($x,$y,$dir=Snake::NORTH)
	{
		$this->createBodyPart($x,$y);
		switch ($dir) {
			case Snake::NORTH:
			$y++;
			break;
			case Snake::EAST:
			$x--;
			break;
			case Snake::SOUTH:
			$y--;
			break;
			case Snake::WEST:
			$x++;
			break;
		}
		$this->direction= $dir;
		$this->createBodyPart($x,$y);
		$this->keyMapper =new keyMapper();
	}
	private function createBodyPart($x,$y){
		$this->size++;
		$this->body[$this->size - 1] =[];
		$this->body[$this->size - 1]["x"] =$x;
		$this->body[$this->size - 1]["y"] =$y;
	}
	private function convert_direction($dir)
	{
		if($dir==""){
			return null;
		}
		echo "dir: $dir\n";
		return constant( get_class($this)."::$dir" );
	}
	public function move(){
		$this->keyMapper->update();
		$direction = $this->convert_direction($this->keyMapper->getDirection());
		if($direction!=null){
			$this->direction = $direction;
		}
		if($this->growing){
			$this->createBodyPart(0,0);
			$this->growing=false;
		} 
		for ($i=sizeof($this->body) - 1; $i > 0; $i--) { 
			$this->body[$i]["x"]=$this->body[$i - 1]["x"];
			$this->body[$i]["y"]=$this->body[$i - 1]["y"];
		}
		$x= $this->body[0]["x"];
		$y = $this->body[0]["y"];
		echo "direction: ".$this->direction."\n";
		switch ($this->direction) {
			case Snake::NORTH:
				$y--;
				break;
			case Snake::EAST:
				$x++;
				break;
			case Snake::SOUTH:
				$y++;
				break;
			case Snake::WEST:
				$x--;
				break;
		}
		$this->body[0]["x"]= $x;
		$this->body[0]["y"]= $y;

	}
	public function show($arr){
		$head =true;
		foreach ($this->body as $bodyPart) {
			$y_size =sizeof($arr);
			$x_size =sizeof($arr[0]);

			if($bodyPart["y"] >= $y_size || $bodyPart["y"] <0){
				break;
			}
			if($bodyPart["x"] >= $x_size || $bodyPart["x"] <0){
				break;
			}
			if($head){
				$arr[$bodyPart["y"]][$bodyPart["x"]] = "0";
				$head=false;

			}
			else{
				$arr[$bodyPart["y"]][$bodyPart["x"]] = "*";

			}
		}
		return $arr;
	}
	public function getHeadPos(){
		return $this->body[0];
	}
}