<?php 
	
	// Loon AB'i ühenduse
	require_once("../config.php");
	$database = "if15_kenaon";
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	function loginUser($email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);		
		
		$stmt = $mysqli->prepare("SELECT userid, email FROM user_accounts WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch())
		{
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			header("Location: home.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	function addLecture($subject){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO lecture_ids (lectureid, userid) VALUES (?, ?)");
		$stmt->bind_param("si", $subject, $_SESSION["logged_in_user_id"]);
		
		$message ="";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab õnnestus
			$message = "Edukalt sisestatud andmebaasi";
		}else{
			//execute on false, miski on katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		
		return $message;
	}
	function lectures(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT access FROM user_accounts WHERE userid =?");
		$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($access);
		$stmt->execute();
		if($access ==1)
		{
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT lectureid, lectures.title FROM lecture_ids JOIN lectures ON lectures.code=lecture_ids.lectureid WHERE userid =?");
			$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
			$stmt->bind_result($lectureid, $title);
			$stmt->execute();
			//tühi massiiv kus hoiame objekte( 1 rida andmeid)
			$array = array();
			
			//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
			while($stmt->fetch())
			{
			
				//loon objekti
				$tasks = new stdClass();
				$tasks->lectureid = $lectureid;
				$tasks->title= $title;
				//lisame selle massiivi
				array_push($array, $tasks);
				//echo "<pre>";
				//var_dump($array);
				//echo "</pre>";
				
			}
			$stmt->close();
			$mysqli->close();
			
			return $array;
		}
		else
		{
			echo $access;
			echo "Kakakaka";
			/*$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT lectureid, lectures.title, lectures.teacher FROM lecture_ids JOIN lectures ON lectures.code=lecture_ids.lectureid WHERE userid =?");
			$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
			$stmt->bind_result($lectureid, $title, $teacher);
			$stmt->execute();
			//tühi massiiv kus hoiame objekte( 1 rida andmeid)
			$array = array();
			
			//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
			while($stmt->fetch())
			{
			
				//loon objekti
				$tasks = new stdClass();
				$tasks->lectureid = $lectureid;
				$tasks->title= $title;
				$tasks->teacher= $teacher;
				//lisame selle massiivi
				array_push($array, $tasks);
				//echo "<pre>";
				//var_dump($array);
				//echo "</pre>";
				
			}
			$stmt->close();
			$mysqli->close();
			
			return $array;*/
		}
	}
?>