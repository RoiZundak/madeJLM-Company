

<?php
	//session_start();
	$func = intval($_GET['func']);

//PDO connection :
define('_HOST_NAME_', 'localhost');
define('_USER_NAME_', 'jobmadeinjlm');
define('_DB_PASSWORD', 'q1w2e3r4');
define('_DATABASE_NAME_', 'jobmadei_db');
//PDO Database Connection
try {
	$databaseConnection = new PDO('mysql:host='._HOST_NAME_.';dbname='._DATABASE_NAME_, _USER_NAME_, _DB_PASSWORD);
	$databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}


//mysql connection
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
			$sql="SELECT * FROM student WHERE github<>'' ";
    		$result = mysql_query ($sql);
    		if (!$result) {
    			print_r("Error ");
				echo 'failed. SQL Err: '. mysql_error();
    			exit();
    		}
    		$img_src = "./img/profilepic.png";
    		while($row = mysql_fetch_assoc($result)) {
       		    $img_src ="";
                if(  $row['profile']=="" ){
                    $img_src = "./img/profilepic.png";
                }else{
                    $img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
                 }
                 echo "<div class='head' id='head_".$row['ID']."' > ";
                 echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
                 print_r($row['first_name']);
                 echo "</div>";
		    }
			
	}
	//filter has instatution
	if($func=="3"){
		$sql="SELECT * FROM student WHERE linkedin<>'' ";
		$result = mysql_query ($sql);
		if (!$result) {
			print_r("Error ");
			echo 'failed. SQL Err: '. mysql_error();
			exit();
		}
		$img_src = "./img/profilepic.png";
		while($row = mysql_fetch_assoc($result)) {
			echo "<script>console.log('CHECK')</script>";
			$img_src ="";
			if(  $row['profile']=="" ){
				$img_src = "./img/profilepic.png";
			}else{
				$img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
			}
			echo "<div class='head' id='head_".$row['ID']."' > ";
			echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
			print_r($row['first_name']);
			echo "</div>";
		}

	}
	//clear
	if($func=="4"){
		$sql="SELECT * FROM student ";
		$result = mysql_query ($sql);
		if (!$result) {
			print_r("Error ");
			echo 'failed. SQL Err: '. mysql_error();
			exit();
		}
		$img_src = "./img/profilepic.png";
		while($row = mysql_fetch_assoc($result)) {
			echo "<script>console.log('CHECK')</script>";
			$img_src ="";
			if(  $row['profile']=="" ){
				$img_src = "./img/profilepic.png";
			}else{
				$img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
			}
			echo "<div class='head' id='head_".$row['ID']."' > ";
			echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
			print_r($row['first_name']);
			echo "</div>";
		}
	}
	//ADD new company
	if($func=="5"){
		$name =$_POST["username"] ;
		$mail =$_POST['e_mail'];
		$p_ass = $_POST['password'];
		$p_ass = md5($p_ass);

		//PDO SYTLE : 
		$records = $databaseConnection->prepare('INSERT INTO company (username, email, password) VALUES (:user,:mail,:password)');
		$records->bindParam(':user', $name);
		$records->bindParam(':mail', $mail);
		$records->bindParam(':password', $p_ass);
		$records->execute();
		$newId = $databaseConnection->lastInsertId();


		/* 			THIS IS A MYSQL APPROACH
		$sql = "INSERT INTO company (username, email, password) VALUES ('$name','$mail','$p_ass')";

		if (mysql_query ($sql) === TRUE) {
			echo"New record created successfully ";
		} else {
			echo "Error: " . $sql . "<br>" . mysql_error();
		}

		*/
	}
	//DELETE company (by id)
	if($func=="6"){
		$row_number =$_POST["row_id"] ;
		$sql = "DELETE FROM company WHERE id=".$row_number;

		if (mysql_query ($sql) === TRUE) {
			echo "Company number ".$row_number." has been DELETED.";
		} else {
			echo "Error: " . $sql . "<br>" . mysql_error();
		}
	}
	//echo ALL companies
	if($func=="7"){
		echo"<table style=\"width:100%\">
			  <tr>
			  	<td>id</td>
			  	<td>Comp. Name</td>
			  	<td>e-Mail</td>
			  </tr>";
		$sql = "SELECT * FROM company";
		$result = mysql_query ($sql);
		while($row = mysql_fetch_assoc($result)) {
			echo "<tr> ";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['email']."</td>";
			echo "</tr>";
		}
		echo"</table>";
	}
?>
		