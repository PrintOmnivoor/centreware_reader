<?php

$host = "localhost";
$user = "centreware";
$password = "password";
$database = "centreware";
$mysqli = new mysqli($host, $user, $password, $database);
//Check connection
if ($mysqli->connect_error) die($mysqli->connect_error);