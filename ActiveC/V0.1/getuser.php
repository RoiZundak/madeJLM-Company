

<?php
	//session_start();
	$func = intval($_GET['func']);

	$con = mysql_connect("5.100.253.198", "jobmadeinjlm","q1w2e3r4");
	if (!$con) {
		die('Could not connect');
	}
	mysql_select_db("jobmadei_db", $con);

	if($func=="1"){
		$q = intval($_GET['q']);
		$sql="SELECT * FROM students WHERE student_id = '".$q."'";
		$result = mysql_query ($sql);
		if (!$result) {
			printf("Error ");
			exit();
		}
		while($row = mysql_fetch_assoc($result)) {
		echo "<table>
		<tr >
			<td >
					<img src='./img/profilepic.png' width='120px' height='110px'>
			</td>
			
			<td class ='line_td'>
				<p>
					<h2>" . $row['student_name'] . "</h2>
					Studies at " . $row['student_acInc'] . "<br>
					Roizundak@Gmail.com <br>
					+9720577224    
			
				</p>
			</td>
		</tr>    
		
		<th >
		
			<td class ='line_td'><p>
			<p>
				<h4>Professional Experince:</h4>
				2015- Peresnt : NOC operator, Deltathree ,INC.</br>
				2009-2015:Intel Corp.</br>
			</td></p>
		</th>
		";
		
		}
		/*
		echo "<table>
		<tr>
		<th>Firstname</th>
		<th>Lastname</th>
		<th>Age</th>
		<th>GPA</th>
		<th>instatution</th>
		</tr>";
		while($row = mysql_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row['student_name'] . "</td>";
			echo "<td>" . $row['student_age'] . "</td>";
			echo "<td>" . $row['student_sex'] . "</td>";
			echo "<td>" . $row['student_gpa'] . "</td>";
			echo "<td>" . $row['student_acInc'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		*/
		mysqli_close($con);
	}
	
	
	
	
	//filter gpa 80
	if($func=="2"){
		$q = intval($_GET['q']);
		$sql="SELECT * FROM students WHERE student_gpa > '80' ORDER BY student_gpa DESC";
		$result = mysql_query ($con,$sql);
		if (!$result) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
		while ($row = mysql_fetch_assoc($result)) {
			echo "<div class='head' id='head_".$row['student_id']."' > ";
			echo "<div class='head_image' id='headimage_".$row['student_id']."' > </div>";
			print_r($row['student_name']);
			echo "</div>";
		}

	}
	
	
	
	//filter has instatution
	if($func=="3"){
		$q = intval($_GET['q']);
		$sql="SELECT * FROM students WHERE student_acInc = 'OXFORD'";
		$result = mysql_query ($con,$sql);
		if (!$result) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
		while ($row = mysql_fetch_assoc($result)) {
			echo "<div class='head' id='head_".$row['student_id']."' > ";
			echo "<div class='head_image' id='headimage_".$row['student_id']."' > </div>";
			print_r($row['student_name']);
			echo "</div>";
		}

	}
	if($func=="4"){
		$result = mysql_query( $con,'SELECT * FROM students');
		while ($row = mysql_fetch_assoc($result)) {
			echo "<div class='head' id='head_".$row['student_id']."' > ";
			echo "<div class='head_image' id='headimage_".$row['student_id']."' > </div>";
			print_r($row['student_name']);
			echo "</div>";
		}
	}
?>
		