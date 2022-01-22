<?php
	session_start();
	
	// Провека существования сессии
	if(!isset($_SESSION["user_id"]))
		return header("Location:../index.php?message=Вы не авторизованы");