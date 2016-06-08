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
		$update->execute();
		//PDO STYLE :
		$sql="SELECT * FROM student WHERE ID = '".$q."' LIMIT 1";
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row)
		{
			$img_src = "";
			if ($row['profile'] == "")
				$img_src = "./img/profilepic.png";
			else
				$img_src = "../../../MadeinJLM-students/mockup/" . $row['profile'];

			$maito_string = "\"<a href =  mailto:" . $row['Email'] . "  >" . $row['Email'] . "</a>\"";
			$link_string = "";
			if ($row['linkedin'] !== "") {
				$link_string = "
								<a href=\"" . $row['linkedin'] . "\">
								<img title=\"LinkedIn\" alt=\"LinkedIn\" src=\"https://socialmediawidgets.files.wordpress.com/2014/03/07_linkedin.png\" width=\"35\" height=\"35\" />
								</a>
 								";
			}

			$git_string = "";
			if ($row['github'] !== "") {
				$git_string = "
								<a href=\"" . $row['github'] . "\">
								<img title=\"Github\" alt=\"Github\" src=\"http://image000.flaticon.com/icons/svg/25/25231.svg\" width=\"35\" height=\"35\" />
								</a>
 							";
			}
			$cv_file = "";
			if ($row['cv'] !== "")
				$cv_file = "<a href='" . $row['cv'] . "' download='" . $row['first_name'] . $row['last_name'] . "'> <img title=\"Cv\" alt=\"Cv\" src=\"http://rambase.com/wp-content/uploads/2014/08/file-manager-logo.png\" width=\"35\" height=\"35\" /> </a>";

			$sentence = "";
			$sql_degree = "SELECT name FROM degree WHERE id =" . $row['degree_id'];
			$sql_college = "SELECT name FROM college WHERE id =" . $row['college_id'];;
			$sql_skills = "SELECT * FROM student_skills WHERE student_id = " . $row['ID'];
			$all_skills = "";
			$list_skills = array();       //skills ids
			$list_skills_bck = array();   //backup skills id for further use
			$list_skills_years = array(); //keep years of knowledge


			foreach ($databaseConnection->query($sql_skills) as $skill) {
				array_push($list_skills, $skill['skill_id']);
				array_push($list_skills_years, $skill['years']);
			}
			$list_skills_bck = $list_skills;
			$skills_name = "SELECT * FROM skills WHERE id IN (" . implode(',', $list_skills) . ")";
			$show_all_skills="";
			$all_skills="";
			if (count($list_skills) > 0)
			{
				$show_all_skills ="Skills list: ";
				$len = count($list_skills_bck);
				foreach ($databaseConnection->query($skills_name) as $skill) {
					for ($i = 0; $i < $len; $i++) {
						if ($skill['id'] === $list_skills_bck[$i]) {
							$all_skills .= "<span class='skill_item'> " . $skill['name'] . " for " .$list_skills_years[$i]. " years.</span>";
						}
					}

				}
			}
			//$show_all_skills.=" ".$all_skills;
			$college_name = "";
			foreach ($databaseConnection->query($sql_college) as $college) {
				$college_name = $college['name'];
			}
			$degree_name = "";
			foreach ($databaseConnection->query($sql_degree) as $degree) {
				$degree_name = $degree['name'];
			}

			$phone_number = "";
			if ($row['phone_number'] !== "0")
				$phone_number = $row['phone_number'];

			$sentence = "Studies for a " . $degree_name . " in " . $row['basic_education_subject'] . " at " . $college_name . " with GPA of " . $row['grade_average'] . " and has " . $row['semesters_left'] . " semesters left.";
			$job_per = $row['first_name'] . " is avaliable for ";
			switch ($row['job_percent']) {
				case 1:
					$job_per .= "a half time job.";
					break;
				case 2:
					$job_per .= "a full time job.";
					break;
				case 3:
					$job_per .= "working in shifts.";
					break;
				case 4:
					$job_per .= "a freelancer job.";
					break;
				default:
					$job_per = $row['first_name'] . " hasn't entered a preference for job percent ";
			}

			$curr_job = "";
			if ($row['current_work'] !== "")
				$curr_job = $row['first_name'] . " is currently working at " . $row['current_work'] . ".";

			$summary_ = "";
			if ($row['summary'] !== "") {
				$sum = "Summary: ";
				$summary = $row['summary'];
			}

			$exprience = "";
			if ($row['experience'] !== "") {
				$exp = "Experience: ";
				$exprience = $row['experience'];
			}

			$phone_number="";
			if($row['phone_number'] !=="0")
			{
				$phone_number="<i class=\'fa fa-phone\'></i> <abbr title=\'Phone\'></abbr>: 0" . $row['phone_number'];
			}

			echo "
			<table>
				<!--First Line: Picture+ Bubbles -->
			    <tr>
			    
			        <td  width=\"100%\">
			        
			            <img class='head_image' src =" . $img_src . " width ='120px' height='110px'>
			            
     			        	<h2 >" . $row['first_name'] . " " . $row['last_name'] . "</h2>
						<div id='bubble'>
				            " . $git_string . "  " . $link_string . "   " . $cv_file . "
						</div>
                    </td>
                      
				</tr>
				
				<!--Second Line: Phone + Mail--><hr>
				<tr>
						<td id='phoneDiv'>
						    <button id = 'std_phone_" . $row['ID'] . "' class='filters' onclick='$(\"#phoneDiv\").html(\"" . $phone_number . "\");' >
								Show Phone
							</button>
						</td>
						
						<td id='mailDiv'>
							<button id = 'std_mail_" . $row['ID'] . "' class='filters' onclick='$(\"#mailDiv\").html(" . $maito_string . ");' >
								Show Mail
							</button>			
						</td>	
                </tr>
                
                	<!--Third Line: Sentence--><hr>
                	
                 <tr >
                	<td>
                		" . $sentence . "
					</td>
                </tr>
                
                <!--Four Line: JobPer + CurrJob--><hr>
                 <tr>
                	<td>
                		" . $job_per . "
					</td>

                	<td>
                		" . $curr_job . "
					</td>
                </tr>
                
                <!--Fifth Line: All Skills + ShowAll--><hr>
                <tr>
                	<td>
                		<h4><b>".$show_all_skills."</b></h4> ".$all_skills."
					</td>
                </tr>
                <!--Six Line: Sum + Experince-->
                <tr>
                <hr>
                	<td>
							<h4><b>" . $sum . "</h4></b>" . $summary . "
					</td>
					
					<td>
							<h4><b>" . $exp . "</h4></b>" . $exprience . " 
                	</td>
                </tr>
                
			</table>
			";
		}
	}

	//filter Git
	if($func=="2")
	{
		//PDO STYLE :
		$sql = "SELECT * FROM student WHERE github<>''";
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row)
		{
			$img_src ="";
			if(  $row['profile']=="" )
				$img_src = "./img/profilepic.png";
			else
				$img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
			echo "<div class='head' id='head_".$row['ID']."' > ";
			echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
			print_r($row['first_name']);
			echo "</div>";
		}
	}

	//filter has instatution
	if($func=="3")
	{
		//PDO STYLE :
		$sql = "SELECT * FROM student WHERE linkedin<>''";
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row)
		{
			$img_src ="";
			if(  $row['profile']=="" )
				$img_src = "./img/profilepic.png";
			else
				$img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
			echo "<div class='head' id='head_".$row['ID']."' > ";
			echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
			print_r($row['first_name']);
			echo "</div>";
		}
	}

	//clear
	if($func=="4")
	{
		//PDO STYLE :
		$sql = 'SELECT * FROM student WHERE Activated=1';
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row)
		{
			$img_src = "";
			if ($row['profile'] == "")
				$img_src = "./img/profilepic.png";
			else
				$img_src = "../../../MadeinJLM-students/mockup/" . $row['profile'];
			echo "<div class='head' id='head" . $row['ID'] . "' > ";
			echo "<img class='head_image' id='headimage_" . $row['ID'] . "' src='" . $img_src . "' width='120px' height='110px'>";
			print_r($row['first_name']);
			echo "</div>";
		}
	}

	//ADD new company
	if($func=="5")
	{
		$name =$_POST["username"] ;
		$mail =$_POST['e_mail'];
		$p_ass = $_POST['password'];
		$p_ass = md5($p_ass);

		//PDO SYTLE :
		$records = $databaseConnection->prepare('INSERT INTO company (username, email, password,created) VALUES (:user,:mail,:password,NOW() )');
		$records->bindParam(':user', $name);
		$records->bindParam(':mail', $mail);
		$records->bindParam(':password', $p_ass);
		if ( $records->execute()==true)
		{
			$newId = $databaseConnection->lastInsertId();
			echo "Great! ".$name." was added to the db with ID = ".$newId;
		}
		else
			echo "Failed to add a new company, please try again.";
	}

	//DELETE company (by id)
	if($func=="6")
	{
		$row_number =$_POST["row_id"] ;

		//PDO STYLE :
		$records = $databaseConnection->prepare('DELETE FROM company WHERE id= :row_id');
		$records->bindParam(':row_id', $row_number);
		if ( $records->execute()==true)
			echo "Great! Company #".$row_number." was DELETED from the db ";
		else
			echo "Failed to DELETE company, please make sure you have the correct ID.";
	}

	//echo ALL companies
	if($func=="7")
	{
		echo"<table style=\"width:100%\">
			<tr>
			  	<td>id</td>
			  	<td>Comp. Name</td>
			  	<td>e-Mail</td>
			</tr>";
		$sql = "SELECT * FROM company";
		//PDO STYLE :
		foreach ($databaseConnection->query($sql) as $row)
		{
			echo "<tr> ";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['email']."</td>";
			echo "</tr>";
		}
		echo"</table>";
	}

    //Update password
    if($func=="8")
	{
        $pass1 =$_POST['new_pass'] ;
        $pass2 =$_POST['new_pass_conf'] ;
        $mail = $_POST['e_mail'];
        if(strcmp($pass1,$pass2)!=0 )
		{
            echo "<script>
			window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
            setTimeout(function(){alert('Passwords does not match.Redirecting to login page..');},100);</script>";
            exit;
        }
        //PDO STYLE :
        $records = $databaseConnection->prepare("UPDATE company SET password ='".md5($pass1)."'".
            ",f_pass='',f_exp=0 WHERE email = '$mail'");
        if ( $records->execute()==true)
            echo "Updated !";
        else
            echo "Failed.";
    }


	if($func=="9")
	{
		$sql = 'SELECT * FROM skills';
		echo "<script>
			//adds a label and input text containing skill value
			function addSkillToList(skill_to_add,years)
			{
				var skill_years=skill_to_add;
				if (years!='')
					skill_years+=', '+ years;
				
				$('#add_skill').after(function() 
				{
				  return'<br><label class=\'skillsLabel\' for=\'skill_'+skill_to_add+'\'>'+skill_years +'</label><input name=\'skill_'+skill_to_add+'\' type=\'text\' class=\'skills\' style=\'display:none;\' value=\''+ skill_years + '\' id=\'skill_'+skill_to_add+'\'>  ' 
				});
			}
			
			$( \"#form_skills\" ).submit(function( event ) 
			{
				event.preventDefault();
				var str = $(\"#form_skills\").serialize();
				xmlhttp.onreadystatechange = function() 
				{
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					    if(xmlhttp.responseText!=''){
                                document.getElementById(\"show_all\").innerHTML = xmlhttp.responseText;
                        }
					}
						
				};
				xmlhttp.open(\"GET\",\"comp_sql_querys.php?func=10&\"+str,true);
				xmlhttp.send();
			});
			</script>";

		echo "
			<form method='post' id= 'form_skills' class='skills' action='./comp_sql_querys.php?func=10'>	
			
			
			<input type=\"text\" list=\"skills_list\" id='skill_input' class='skills'>
			<select id='years_input' class='skills'>
				<option value='0' selected='selected'>All years of experience</option>
				<option value='-1'>less then 1 year</option>
				<option value='1'>1 year</option>
				<option value='2'>2 years</option>
				<option value='3'>3 years</option>
				<option value='3+'>more then 3 years</option>
			</select>
			<input type=\"button\" id = 'add_skill' value = \"+\" class='skills' onclick='addSkillToList(document.getElementById(\"skill_input\").value,$(\"#years_input option:selected\").text());$(\"#skill_input\").val(\"\");'>

			
			
			<datalist id=\"skills_list\">";
			foreach ($databaseConnection->query($sql) as $row)
				echo '<option value='.$row['name'].'>';

			echo "</datalist>
			
			<br>
		
	
			<input type=\"submit\" value=\"Filter\" id=\"submit_skills\">
			
			
			</form>";
	}

	if($func=="10")
	{
        $skills_arr=array();
        $time_arr=array();
		foreach($_GET as $key => $value)
		{
			if (strstr($key, 'skill_')){
                if(strstr($value,',')) {
                    $skill = substr($value, 0, strpos($value, ','));//eg. 'javascript'
                    array_push($skills_arr,'\''.$skill.'\'');//eg. 'javascript'
                }
               /* if(strstr($value,',')){

                    $skill = substr($value,0,strpos($value,','));//eg. 'javascript'
                    $time = substr($value,strpos($value,',')+2); //eg. '3 years'
                    $time = substr($time ,0 , strpos($time,' '));//eg. '3'
                    //more , less , All ,1 ,2, 3
                    switch ($time){
                        case 'All':
                            $time='0';
                            break;
                        case 'less':
                            $time = '-1';
                            break;
                        case 'more':
                            $time='+3';
                            break;
                        default:

                    }
                    array_push($skills_arr,'\''.$skill.'\'');//eg. 'javascript'
                    array_push($time_arr,'\''.$time.'\'');
                }else{
                    array_push($skills_arr,'\''.$value.'\'');//eg. 'javascript'
                    array_push($time_arr,'0');
                }*/

            }

		}
		if(count($skills_arr)==0) //no skills were selected
        {
            exit;
        }

		$skills_id=array();
		$sql = "SELECT id FROM skills WHERE name IN (".implode(',',$skills_arr).") AND status = 1";
		foreach ($databaseConnection->query($sql) as $row)
			array_push($skills_id,'\''.$row[0].'\'');

		if(count($skills_id)==0) //could not get skills id
			exit;

		$sql = "SELECT student_id FROM student_skills WHERE skill_id  IN (".implode(',',$skills_id).")" ;
		$students_id =array();
		foreach ($databaseConnection->query($sql) as $row)
			array_push($students_id,'\''.$row[0].'\'');

		if(count($students_id)==0) //noBody has that skill !
        {
            echo 'No results were found, please try again with different filters';
            exit;
        }

		$sql = "SELECT * FROM student WHERE ID IN(".implode(',',$students_id).")" ;
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row)
		{
			$img_src ="";
			if(  $row['profile']=="" )
				$img_src = "./img/profilepic.png";
			else
				$img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
			
			echo "<div class='head' id='head_".$row['ID']."' > ";
			echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
			print_r($row['first_name']);
			echo "</div>";
		}
	}
    //increment student contact stats
	if($func=="11")
	{
		$q = intval($_GET['q']); //student id
		$sql_update="UPDATE student SET counter_contact = counter_contact + 1 WHERE ID = '".$q."'";
		$update = $databaseConnection ->prepare($sql_update);
		$update->execute();
	}
    //reset company password
    if($func=="12")
    {
        $row_id =$_POST['row_id_reset'] ;
        $newPassword =$_POST['new_pass'] ;
        $sql_update_pass = "UPDATE company SET password ='".md5($newPassword)."' WHERE id='".$row_id."'";
        $update = $databaseConnection ->prepare($sql_update);
        $update->execute();
    }

?>

