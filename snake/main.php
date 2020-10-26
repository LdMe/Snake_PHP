<?php

include_once("map.php");

$map=new Map(20,20);
$map->setPrize();
$map->show();
$map->play();