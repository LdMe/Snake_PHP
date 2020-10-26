<?php

include_once("snake.php");



class Map{
	private $rows=[];
	private $width;
	private $height;
	private $snake = null;
	private $round =0;
	private $prizePosition=[];
	private $level;
	private $sleeptime;
	private $points;
	private $lastRound;
	private $averageRounds;
	private $ended;
	public function __construct($width,$height,$sleeptime=500000)
	{
		for ($i=0; $i <$height ; $i++) { 
			$this->rows[] = [];
			for ($j=0; $j < $width; $j++) { 
				$this->rows[$i][]='·';
			}
		}
		$this->height= $height;
		$this->width = $width;
		$this->averageRounds = max($height,$width);
		$this->level= 1;
		$this->points=0;
		$this->lastRound=0;
		$this->start();
		$this->sleeptime=$sleeptime;
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
		$this->ended=false;
		while(!$this->ended){
			if($this->snake)
			{
				$this->snake->move();
			}
			$this->show();
			if($this->snake){
				if($this->snake->isDead()){

					$this->end();
				}
			}
			if($this->checkPrize())
			{
				$this->snake->growing=true;
				$this->level++;
				$this->sleeptime *=0.9;
				$rounds = $this->round - $this->lastRound;
				$this->points += round(($this->averageRounds / $rounds)* (5 * $this->level));
				$this->lastRound=$this->round;
				$this->setPrize();
				
			}
			$this->round++;
			usleep($this->sleeptime);
		}
		
	}
	public function end(){
		system('clear');
		echo "GAME OVER!\n";
		echo "level: $this->level\n";
		echo "rounds: $this->round\n";
		echo "points: $this->points\n";
		$rows =$this->rows;
		foreach ($rows as $row) {
			$result ="";
			foreach ($row as $column) {
				$result .=$column;
			}
			echo $result ."\n";
		}
		$this->ended=true;
		
	}
	public function show(){
		system('clear');
		echo "level: $this->level\n";
		echo "rounds: $this->round\n";
		echo "points: $this->points\n";
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
		
	}
	public function start(){
		$this->snake= new Snake($this->width / 2,$this->height/2);
	}
	public function stop(){
		unset($this->snake);
	}

}

