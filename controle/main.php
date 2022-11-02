<?php
    require_once('config.php');
	$db=new PDO(dbdriver.':host='.dbhost.';dbname='.database,dbuser,dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    require_once(__DIR__."/../src/script/user.php");
	$user=new User($db);
    $logger=new User($db);
	
	session_start();

    require_once('traitement.php');
    if(isset($_SESSION["uname"]) && !empty($_SESSION["uname"]))
	{
		if (isset($_SESSION["temp_de_connexion"])&&!empty($_SESSION["temp_de_connexion"])) 
		{
			
		}
		else
		{
			echo"<script>alert('not  remmember')</script>";

			header('Location:'.__DIR__.'/logout.php');
		}
	} 

	if (empty($_SESSION)) 
	{
		$logger->empty_session();
	}
?>