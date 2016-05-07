

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
		$sql="SELECT * FROM student WHERE ID = '".$q."'";
		$result = mysql_query ($sql);
		if (!$result) {
			print_r("Error ");
			exit();
		}
		$img_src = "./img/profilepic.png";
		while($row = mysql_fetch_assoc($result)) {

			echo "<script >console.log('david')</script>";
		    $img_src ="";
            if(  $row['profile']=="" ){
                $img_src = "./img/profilepic.png";
            }else{
                $img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
             }
            echo "<table>
            <tr >
                <td >
                    <img src=".$img_src." width='120px' height='110px'>
                </td>

                <td class ='line_td'>
                    <p>
                        <h2>" . $row['first_name'] ." ". $row['last_name'] . "</h2>"
                        ."<br>" .$row['Email'] . "
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
            echo "<table id='show_student_info'>
                    <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>basic education years</th>
                    <th>subject</th>
                    <th>semesters left</th>
                    </tr>";

            echo "<tr>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['basic_education_years'] . "</td>";
            echo "<td>" . $row['basic_education_subject'] . "</td>";
            echo "<td>" . $row['semesters_left'] . "</td>";
            echo "</tr>";
            echo "</table>";

		}
		mysql_close($con);
	}
	
	
	
	
	//filter Git
	if($func=="2"){
		$q = intval($_GET['q']);
		$sql="SELECT * FROM students WHERE github <> '' ORDER BY first_name DESC";
		$result = mysql_query ($sql);
		if (!$result) {
			print_r("Error);
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
		