

<?php
	$func = intval($_GET['func']);

	$con = mysqli_connect('localhost','David','248613579','students');
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"students");

	if($func=="1"){
		$q = intval($_GET['q']);
		$sql="SELECT * FROM students WHERE student_id = '".$q."'";
		$result = mysqli_query($con,$sql);
		if (!$result) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
		while($row = mysqli_fetch_array($result)) {
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
		while($row = mysqli_fetch_array($result)) {
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
		$result = mysqli_query($con,$sql);
		if (!$result) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
		while ($row = mysqli_fetch_array($result)) {
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
		$result = mysqli_query($con,$sql);
		if (!$result) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
		while ($row = mysqli_fetch_array($result)) {
			echo "<div class='head' id='head_".$row['student_id']."' > ";
			echo "<div class='head_image' id='headimage_".$row['student_id']."' > </div>";
			print_r($row['student_name']);
			echo "</div>";
		}

	}
	if($func=="4"){
		$result = mysqli_query($con,'SELECT * FROM students');
		while ($row = mysqli_fetch_array($result)) {
			echo "<div class='head' id='head_".$row['student_id']."' > ";
			echo "<div class='head_image' id='headimage_".$row['student_id']."' > </div>";
			print_r($row['student_name']);
			echo "</div>";
		}
	}
?>
		