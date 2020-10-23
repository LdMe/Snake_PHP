<?php

include_once("snake.php");



class Map{
	private $rows=[];
	private $width;
	private $height;
	private $snake = null;
	private $round =0;
	private $prizePosition=[];
	public function __construct($width,$height)
	{
		for ($i=0; $i <$height ; $i++) { 
			$this->rows[] = [];
			for ($j=0; $j < $width; $j++) { 
				$this->rows[$i][]='·';
			}
		}
		$this->height= $height;
		$this->width = $width;
		$this->start();
	}
	public function setPrize(){
		$x= random_int(0, $this->width-1);
		$y= random_int(0, $this->height-1);
		$this->prizePosition["x"]=$x;
		$this->prizePosition["y"]=$y;
	}
	public function checkPrize(){
		if($this->snake){
			$position = $this->snake->getHeadPos();
			if($position['x']==$this->prizePosition['x'] && $position['y']==$this->prizePosition['y'])
			{
				return true;
			}
		}
		return false;
	}
	public function play(){
		if($this->snake)
		{
			$this->snake->move();
		}
		$this->show();
		$this->round++;
	}
	public function show(){
		system('clear');
		echo "round: $this->round\n";
		$rows =$this->rows;
		if(!empty($this->prizePosition)){
			$x=$this->prizePosition['x'];
			$y=$this->prizePosition['y'];
			$rows[$y][$x] = 'X';
		}
		if($this->snake){
			$rows = $this->snake->show($rows);
		}
		else{
			$rows = $this->rows;
		}
		foreach ($rows as $row) {
			$result ="";
			foreach ($row as $column) {
				$result .=$column;
			}
			echo $result ."\n";
		}
		if($this->checkPrize())
		{
			$this->snake->growing=true;
			$this->setPrize();
		}
	}
	public function start(){
		$this->snake= new Snake($this->width / 2,$this->height/2);
	}
	public function stop(){
		unset($this->snake);
	}

}
$map=new Map(20,10);
$map->setPrize();
$map->show();
for ($i=0; $i <50 ; $i++) { 
	$map->play();
	usleep(500000);
}
