<?php
	require_once "php/db_connect.php";
	$databaseConnection =connect_to_db();

	$func = intval($_GET['func']);


	//show single student
	if($func=="1")
	{
		$q = intval($_GET['q']);
		
		$sql_update="UPDATE student SET counter_view = counter_view + 1 WHERE ID = '".$q."'";
		$update = $databaseConnection ->prepare($sql_update);

		//UPDATE student SET counter_contact = counter_contact + 1;

		//PDO STYLE :
		$sql="SELECT * FROM student WHERE ID = '".$q."'";
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row) {
			$img_src ="";
			if(  $row['profile']=="" ){
				$img_src = "./img/profilepic.png";
			}else{
				$img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
			}
			echo "<script>
								     function myFunc(email)
								    	{
											$('#mailDiv').html(email);
											xmlhttp.open('GET', 'comp_sql_querys.php?q=\" ".$q." \"&func=\"11\", true);
											xmlhttp.send();
								    	}
								
								</script>";
			echo "<table>
					<tr >
						<td >
							<img src=".$img_src." width='120px' height='110px'>
						</td>
		
						<td class ='line_td'>
							<p>
								<h2>" . $row['first_name'] ." ". $row['last_name'] . "</h2><br >
							<div id='mailDiv'>
								
								
								<button type=\"button\" id = \"but\" onclick=\"myFunc('hhhhh');\"> ShowMail </button>
					
								
							</div>
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


	}
	//filter Git


	if($func=="2"){

			//PDO STYLE :
			$sql = "SELECT * FROM student WHERE github<>''";
			$img_src = "../img/profilepic.png";
			foreach ($databaseConnection->query($sql) as $row) {
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
		
		//PDO STYLE :
		$sql = "SELECT * FROM student WHERE linkedin<>''";
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row) {
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
	if($func=="4") {


		//PDO STYLE :
		$sql = 'SELECT * FROM student WHERE Activated=1';
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row) {
			$img_src = "";
			if ($row['profile'] == "") {
				$img_src = "./img/profilepic.png";
			} else {
				$img_src = "../../../MadeinJLM-students/mockup/" . $row['profile'];
			}
			echo "<div class='head' id='head" . $row['ID'] . "' > ";
			echo "<img class='head_image' id='headimage_" . $row['ID'] . "' src='" . $img_src . "' width='120px' height='110px'>";
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
		$records = $databaseConnection->prepare('INSERT INTO company (username, email, password,created) VALUES (:user,:mail,:password,NOW())');
		$records->bindParam(':user', $name);
		$records->bindParam(':mail', $mail);
		$records->bindParam(':password', $p_ass);
		if ( $records->execute()==true){
			$newId = $databaseConnection->lastInsertId();
			echo "Great! ".$name." was added to the db with ID = ".$newId;
		}else{
			echo "Failed to add a new company, please try again.";
		}

	}
	//DELETE company (by id)
	if($func=="6"){
		$row_number =$_POST["row_id"] ;

		//PDO STYLE :
		$records = $databaseConnection->prepare('DELETE FROM company WHERE id= :row_id');
		$records->bindParam(':row_id', $row_number);
		if ( $records->execute()==true){
			echo "Great! Company #".$row_number." was DELETED from the db ";
		}else{
			echo "Failed to DELETE company, please make sure you have the correct ID.";
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
		//PDO STYLE :
		foreach ($databaseConnection->query($sql) as $row) {
			echo "<tr> ";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['email']."</td>";
			echo "</tr>";
		}
		echo"</table>";


	}
    //Update password
    if($func=="8"){
        $pass1 =$_POST['new_pass'] ;
        $pass2 =$_POST['new_pass_conf'] ;
        $mail = $_POST['e_mail'];
        if(strcmp($pass1,$pass2)!=0 ){
            echo "passwords does not match , ";
            // TODO redirect to index.html
            exit;
        }
        //PDO STYLE :
        $records = $databaseConnection->prepare("UPDATE company SET password ='".md5($pass1)."'".
            ",f_pass='',f_exp=0 WHERE email = '$mail'");
        if ( $records->execute()==true){
            echo "Updated !";
        }else{
            echo "Failed.";
        }
    }


if($func=="9")
{
    $sql = 'SELECT * FROM skills';
    echo "<script>
        //adds a label and input text containing skill value
        function addSkillToList(skill_to_add){
            $('#add_skill').after(function() {
              return'<label class=\'skills\' for=\'skill_'+skill_to_add+'\'>'+skill_to_add+'</label> <br> <input name=\'skill_'+skill_to_add+'\' type=\'text\' class=\'skills\' style=\'display:none;\' value=\''+ skill_to_add + '\' id=\'skill_'+skill_to_add+'\'>  ' 
            });
        }
        
        
        $( \"#form_skills\" ).submit(function( event ) {
                event.preventDefault();
              var str = $(\"#form_skills\").serialize();
              xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById(\"std_info\").innerHTML = xmlhttp.responseText;
                    }
                };
            xmlhttp.open(\"GET\",\"comp_sql_querys.php?func=10&\"+str,true);
            xmlhttp.send();
        });



        
        
        </script>";

    echo "
			<form method='post' id= 'form_skills' action='./comp_sql_querys.php?func=10'>	
			<input type=\"text\" list=\"skills_list\" id='skill_input' class='skills'>
			<input type=\"button\" id = 'add_skill' value = \"+\" class='skills' onclick='addSkillToList(document.getElementById(\"skill_input\").value);$(\"#skill_input\").val(\"\");'>

			<datalist id=\"skills_list\">";
    foreach ($databaseConnection->query($sql) as $row)
    {
        echo '<option value='.$row['name'].'>';
    }
    echo "</datalist>
<br>
                <input type=\"submit\" value=\"Filter\" id=\"submit_skills\">
                </form>";
}




if($func=="10"){
    $skills_arr=array();
    foreach($_GET as $key => $value){
        if (strstr($key, 'skill_')) {
            array_push($skills_arr,'\''.$value.'\'');//eg. 'javascript'
        }
    }


    //  TODO : create an sql query, add all skills to it, and then print results(students)
    /*
     * "SELECT id FROM skills WHERE name IN (".implode(',',$skills_arr).") AND status = 1"
    *
     *SELECT * FROM student WHERE ID IN [ SELECT student_id FROM student_skills WHERE skill_id  IN [SELECT id FROM skills WHERE name IN [ pop from array ] AND status = 1] ]
     */
    $skills_id=array();
    $sql = "SELECT id FROM skills WHERE name IN (".implode(',',$skills_arr).") AND status = 1";
    foreach ($databaseConnection->query($sql) as $row) {
        array_push($skills_id,'\''.$row[0].'\'');
    }
    $sql = "SELECT student_id FROM student_skills WHERE skill_id  IN (".implode(',',$skills_id).")" ;
    $students_id =array();
    foreach ($databaseConnection->query($sql) as $row) {
        array_push($students_id,'\''.$row[0].'\'');
    }
    $sql = "SELECT * FROM student WHERE ID IN(".implode(',',$students_id).")" ;
    $img_src = "../img/profilepic.png";
    foreach ($databaseConnection->query($sql) as $row) {
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

if($func=="11")
{
	$q = intval($_GET['q']);
	$sql_update="UPDATE student SET counter_contact = counter_contact + 1 WHERE ID = '".$q."'";
	$update = $databaseConnection ->prepare($sql_update);
}


?>

