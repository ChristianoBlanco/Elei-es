<?php
	ini_set("display_errors", "on");
	session_start();
	if(empty($_SESSION["id"])){
		header("location:index.php");
	}