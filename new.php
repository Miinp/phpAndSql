<?php

session_start();

$servername = "127.0.0.1:51188";
$username = "azure";
$password = "6#vWHD_$";
$dbname = "localdb";
$id = $_POST['id'];
$name = $_POST['name'];
$_SESSION['id'] = $id;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql = "INSERT INTO laskuri (ID,Name)
VALUES ($id, '$name')";
  
$idCheck = "SELECT * FROM laskuri WHERE ID = $id"; 

$rs = mysqli_query($conn,$idCheck);

// Check if the person has already made this exam or if new user should be added to database.
if ($data = mysqli_fetch_array($rs, MYSQLI_NUM)) {
    echo "You have already done this exam!";
	mysqli_close($conn);
	header("Location: https://2001277.azurewebsites.net/mathtest/result.php"); 
	exit();
}
else
{
    if (mysqli_query($conn,$sql))
    {
        echo "New record created.<br/>";
    }
    else
    {
        echo "Error adding user in database<br/>";
    }


  
echo "<br>";
echo "<br>";

mysqli_close($conn);
}
/*
if(!isset($_SESSION['active_count'])){
    $_SESSION['active_count'] = 3600;
    $_SESSION['time_started'] = time();
}

$now = time();

$final_remain_time = $now - $_SESSION['time_started'];

$remainingSeconds = abs($_SESSION['active_count'] - $final_remain_time);
$remainingMinutes = round($remainingSeconds/60);
if($remainingMinutes > 1) {
echo "There are $remainingMinutes minutes remaining.";
} else {
	echo "There are $remainingSeconds seconds remaining.";
}

if($remainingSeconds < 1){
   //Finished! Do something.
   echo "Your time is up!";
}
*/

?>
		
	<html>	
		<head>
		        <link rel="stylesheet" href="./styles.css">
		</head>
		<body>
		<form id="form2" action="result.php" method="post">
		
			<h4> Welcome <?php echo $_POST["name"]; ?>, <?php echo $_POST["id"]; ?>! Your exam has started.</h4>
					
			<?php
			$endTime = time() + (60 * 60);
			echo 'Starting time:  '.date('H:i:s', time());
			echo "<br>";
			echo 'Your time will finish:  '.date('H:i:s', $endTime);
			?>
			
			<br><br>
			
			<!-- Progress bar, shows how exam progresses. For every answer given progress +1, if answer is set as empty, progress -1.  Total of tasks 57.-->
			<label for="progression">Your progress:</label>
			<progress id="progression" value="0" max="57"></progress>
			
			<br><br>
			Notice that you need to use point(.) as decimal separator.
		
			<h2>Basic Calculations 10 Points</h2>
			<ol>
				<li> 98 - 56 + 45 = <input type="text" name="BC1" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 376 - 678 + 236 = <input type="text" name="BC2" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 6 x 7 - 9 x 5 = <input type="text" name="BC3" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 56 x 5 + 23 x 9 - 567 = <input type="text" name="BC4" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 5.6 x 34 + 21 / 7 = <input type="text" name="BC5" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 123.45 x 5.5 = <input type="text" name="BC6" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 3276.45 / 8 = <input type="text" name="BC7" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 748.5 / 1.5 = <input type="text" name="BC8" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 45600 / 100 = <input type="text" name="BC9" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
				<li> 8763 x 100 = <input type="text" name="BC10" onclick="hasText(this.value)" onchange="makeProgress(this.value)"></li>
			</ol>
			
					
			<!-- Kirjoitettu valmiiksi, mutta kommentoitu vielä ulos.
			<br><br>
   			<h2>Units 20 Points</h2><br>
			Change to milligrams<br>
			<ol>
  		 		<li>  925 micrograms = <input type="text" name="units1"> mg</li>
				<li> 200 micrograms = <input type="text" name="units2"> mg</li>
				<li> 1386 micrograms = <input type="text" name="units3"> mg</li>
				<li> 500 micrograms = <input type="text" name="units4"> mg</li>
			</ol>
			<br>
			Change to grams<br>
			<ol>
				<li> 7260 mg = <input type="text" name="units5"> g</li>
				<li> 80 mg = <input type="text" name="units6"> g</li>
				<li> 135 mg = <input type="text" name="units7"> g</li>
				<li> 1250 mg = <input type="text" name="units8"> g</li>
			</ol>
			<br>
			Change to milliliters<br>
			<ol>
				<li> 4.5 l = <input type="text" name="units9"> ml</li>
				<li> 0.9 l = <input type="text" name="units10"> ml</li>
				<li> 8.5 l = <input type="text" name="units11"> ml</li>
				<li> 2.2 l = <input type="text" name="units12"> ml</li>
			</ol>
			<br>
			Change to liters<br>
			<ol>
				<li> 70 ml = <input type="text" name="units13"> l</li>
				<li> 725 ml = <input type="text" name="units14"> l</li>
				<li> 1575 ml = <input type="text" name="units15"> l</li>
				<li> 3300 ml = <input type="text" name="units16"> l</li>
			</ol>
			<br>
			Change to micrometer<br>
			<ol>
				<li> 128 mm = <input type="text" name="units17"> micrometers</li>
				<li> 32 mm = <input type="text" name="units18"> micrometers</li>
				<li> 3.55 mm = <input type="text" name="units19"> micrometers</li>
				<li> 22.45 mm = <input type="text" name="units20"> micrometers</li>
			</ol>
			<br><br>
			
			<h2> Percentage 10 Points</h2><br>
			What is
			<ol>
				<li> 10 % of 2500 = <input type="text" name="per1"></li>
				<li> 30 % of 4700 = <input type="text" name="per2"></li>
				<li> 50 % of 7500 = <input type="text" name="per3"></li>
				<li> 80 % of 9200 = <input type="text" name="per4"></li>
				<li> 15 % of 1100 = <input type="text" name="per5"></li>
				<li> 35 % of 2200 = <input type="text" name="per6"></li>
				<li> 42 % of 4800 = <input type="text" name="per7"></li>
			</ol>
			<br>
			Find the percentage<br>
			<ol>
				<li> 1500 ml out of 2500 ml = <input type="text" name="per8"> %</li> 
				<li> 1200 ml out of 4000 ml = <input type="text" name="per9"> %</li> 
				<li> 650 ml out of 1000 ml = <input type="text" name="per10"> %</li> 
			</ol>
			<br><br>
			
			<h2>Expressions / Simplify / Division & Multiplication (by 10, 100, 1000) 10 Points</h2><br>
			<ol>
				<li> x + 45 = 35 What is x? x = <input type="text" name="esdn1"></li> 
				<li> x - 526 = 445 What is x? x = <input type="text" name="esdn2"></li> 
				<li> If x = 5 then 2x + 3 - x = <input type="text" name="esdn3"></li> 
			</ol>
			<br>
			Simplify<br>
			<ol>
				<li> 275/400 = <input type="text" name="esdn4"></li> 
				<li> 60/375 = <input type="text" name="esdn5"></li> 
				<li> 125/300 = <input type="text" name="esdn6"></li> 
			</ol>
			<br>
			Division & Multiplication<br>
			<ol>
				<li> 8.25 / 1000 = <input type="text" name="esdn7"></li> 
				<li> 6.26 x 100 = <input type="text" name="esdn8"></li> 
				<li> 3.87 / 10 = <input type="text" name="esdn9"></li> 
				<li> 2.29 / 100 = <input type="text" name="esdn10"></li> 
			</ol>
			<br><br>
			
			<h2>Roman Numbers 10 Points</h2><br>
			<ol>
				<li> IX = <input type="text" name="roman1"></li> 
				<li> XXXIX = <input type="text" name="roman2"></li> 
				<li> XXII = <input type="text" name="roman3"></li> 
				<li> XVI = <input type="text" name="roman4"></li> 
				<li> XLIV = <input type="text" name="roman5"></li> 
				<li> 48 = <input type="text" name="roman6"></li> 
				<li> 32 = <input type="text" name="roman7"></li> 
				<li> 20 = <input type="text" name="roman8"></li> 
				<li> 14 = <input type="text" name="roman9"></li> 
				<li> 45 = <input type="text" name="roman10"></li> 
			</ol>
			-->    
			<input type="submit" value="Finish exam!" name="submit" onclick="checkResults()">
		</form>
		</body>
		
		<script>
		// function to find out if input box has any data inside it 
		let hasValue = false;
		function hasText(value) {
			if (value === "" ) {
				hasValue = false;
			} else if (value !== "") {
				hasValue = true;
			}
		}

		// function to change progress in progress bar
		function makeProgress(value) {
			if (hasValue == false) {
				if (value !== "") {
				document.getElementById("progression").value += 1; 
				}
			} else if (hasValue == true) {
				if (value === "") {
				document.getElementById("progression").value -= 1;
				}
			} 
		}
		

		</script>
		</html>
		