<?php
	// kõik funktsioonid, kus tegeleme AB'iga
	require_once("functions.php");
	
	//kui kasutaja on sisseloginud,
	//siis suuunan data.php lehele
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: home.php");
	}

	// ühenduse loomiseks kasuta
	//require_once("../../config.php");
	//$database = "if15_kenaon";
	//$mysqli = new mysqli($servername, $username, $password, $database);
	
	// funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
	function cleanInput($data) { 
  	$data = trim($data); //eemaldab tühikud, tabid ja enterid
  	$data = stripslashes($data); // eemaldab tagurpidi kaldkriipsud "\"
  	$data = htmlspecialchars($data);
  	return $data;
  }
	//echo $_POST["email"];
	
	//Defineerime muutujad
	$email_error = "";
	$password_error = "";
	//$name_error = "";
	
	//kontrollin kas keegi vajutas nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		
		// kontrollin mis nuppu vajutati
		if(isset($_POST["login"])){
			
			// ********************
			// *** LOGIN NUPP *****
			// ********************
			
			// kas e-post on tühi
			if( empty($_POST["email"]) ) {
				
				// jah oli tühi
				$email_error = "See väli on kohustuslik";	
			}
			else
			{
		// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			
			// kas parool on tühi
			if( empty($_POST["password"]) ) {
				
				// jah oli tühi
				$password_error = "See väli on kohustuslik";	
			}
			else
			{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$password_hash = hash("sha512", $password);
				// kasutaja sisselogimise fn, failist functions.php
				loginUser($email, $password_hash);
				}
				
			}
		}
		
?>
<?php
	$page_title = "Login leht";
	$file_name = "login.php";
?>
<?php require_once("header.php"); ?>
	<h2>Login</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input name="email" type="email" placeholder="E-post" > <?php echo $email_error; ?><br><br>
		<input name="password" type="password" placeholder="Parool" > <?php echo $password_error; ?> <br><br>
		<input name="login" type="submit" value="Logi sisse" > <br><br>
	</form>
	
	<a href="register.php"> <button>Registreeri  </button> </a>
	
<?php require_once("footer.php") ?>