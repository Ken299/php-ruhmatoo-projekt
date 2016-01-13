<?php
	$page_title = "Ained";
	$file_name = "lectures.php";
?>
<?php
	//kopeerime header.php sisu
	// ../ -tähistab, et fail asub ühe võrra kõrgemal kaustas
	require_once("header.php")

?>
<?php
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	$tasks = lectures();
?>
<html>
<body>
<table border=1 >
	<tr>
		<th>Aine kood</th>
		<th>Aine nimetus</th>
		<th>Õppejõud</th>
	</tr>
	
	<?php
	
		//iga massiivis oleva elemendi kohta
		//count($tasks) - massiivi pikkus
		for($i = 0; $i < count($tasks); $i++)
		{
			echo "<tr>";
			
			//echo "<td>".$tasks[$i]->id."</td>";
			echo "<td align=center>".$tasks[$i]->lectureid."</td>";
			echo "<td align=center>".$tasks[$i]->title."</td>";
			echo "<td align=center>".$tasks[$i]->teacher."</td>";
			echo "</tr>";
		}
	
	?>
</table	>
<br>
</body>
</html><br>
<?php require_once("footer.php") ?>