<?php
	require_once("functions.php");
?>
<h3>Menüü</h3>
<?php
	if(isset($_SESSION["logged_in_user_id"]))
	{?>
		<input type=button onClick="location.href='?logout=1'" value='Logi välja'>
		<?php
	}
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
		
?>

<ul>



	<?php if ($file_name == "home.php") { ?>
	
		<li>Avaleht</li>
		
	<?php } else { ?>
	
		<li> <a href="home.php">Avaleht</a> </li>
	
	<?php } ?>
	
	<?php 
	if(!isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "login.php"){ 
		
			echo "<li>Logi sisse</li>";
		
		}else{
			
			echo '<li><a href="login.php">Logi Sisse</a></li>';
		}
	}	
	?>

	<?php 
	if(!isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "register.php"){ 
		
			echo "<li>Registreeri</li>";
		
		}else{
			
			echo '<li><a href="register.php">Registreeri</a></li>';
		}
	}	
	?>
	
	<?php 
	if(isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "select.php"){ 
		
			echo "<li>Vali ained</li>";
		
		}else{
			
			echo '<li><a href="select.php">Vali ained</a></li>';
		}
	}
	else
	{
		echo "";
	}
	?>
	<?php /*
	if(isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "data.php"){ 
		
			echo "<li>Numbrimärgid</li>";
		
		}else{
			
			echo '<li><a href="data.php">Numbrimärgid</a></li>';
		}
	}
	else
	{
		echo "";
	}*/
	?>
	

	
</ul>