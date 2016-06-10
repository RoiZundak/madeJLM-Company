<?php
	require_once "php/db_connect.php";
	$databaseConnection =connect_to_db();
	/*Hebrew*/
	$sql="SET character_set_client=utf8";
	$databaseConnection->query($sql);
	$sql="SET character_set_connection=utf8";
	$databaseConnection->query($sql);
	$sql="SET character_set_database=utf8";
	$databaseConnection->query($sql);
	$sql="SET character_set_results=utf8";
	$databaseConnection->query($sql);


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


		$link_string = "";
		if ($row['linkedin'] !== "")
		{
			$link_string = "<a href=\"" . $row['linkedin'] . "\">
								<img class=\"bubbels\" title=\"LinkedIn\" alt=\"LinkedIn\" src=\"./img/LinkedinIcon.png\"  />
								</a>
 								";
		}
		$git_string = "";
		if ($row['github'] !== "")
		{
			$git_string = "<a href=\"" . $row['github'] . "\">
								<img class=\"bubbels\" title=\"Github\" alt=\"Github\" src=\"./img/GithubIcon.png\"  />
								</a>
 							";
		}

		$cv_file = "";
		if ($row['cv'] !== "")
			$cv_file = "<a href='".$row['cv']."' download='" .$row['first_name']. $row['last_name'] . "'> <img class=\"bubbels\" title=\"Cv\" alt=\"Cv\" src=\"./img/CVIcon.png\" /> </a>";

		$sentence = "";
		$sql_degree = "SELECT name FROM degree WHERE id =" . $row['degree_id'];
		$sql_college = "SELECT name FROM college WHERE id =" . $row['college_id'];;
		$sql_skills = "SELECT * FROM student_skills WHERE student_id = " . $row['ID'];
		$all_skills = "";
		$list_skills = array();       //skills ids
		$list_skills_bck = array();   //backup skills id for further use
		$list_skills_years = array(); //keep years of knowledge

		foreach ($databaseConnection->query($sql_skills) as $skill)
		{
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
			foreach ($databaseConnection->query($skills_name) as $skill)
			{
				for ($i = 0; $i < $len; $i++)
				{
					if ($skill['id'] === $list_skills_bck[$i]) {
						$all_skills .= "<span class='skill_item'> &#10003 " . $skill['name'] . " for " .$list_skills_years[$i]. " years</span><br>";
					}
				}
			}
		}
		else
		{
			$show_all_skills ="Skills list: ";
			$all_skills=$row['first_name']." hasn't entred any skills yet.";
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

		if ($degree_name=="" || $row['basic_education_subject']=="" || $college_name=="" || $row['grade_average']=="" || $row['semesters_left']=="")
			$sentence = $row['first_name']. " hasn't fulfilled all the basic information fields. for more Information, contact with ".$row['first_name'].".";
		else
			$sentence = "Studies for a " . $degree_name . " in " . $row['basic_education_subject'] . " at " . $college_name . " with GPA of " . $row['grade_average'] . " and has " . $row['semesters_left'] . " semesters left.";

		$job_per = $row['first_name'] . " is avaliable for ";
		switch ($row['job_percent'])
		{
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
				$job_per = $row['first_name'] . " hasn't entered a preference for job percent.";
		}
		$curr_job = "";
		if ($row['current_work'] !== "")
			$curr_job = $row['first_name'] . " is currently working at " . $row['current_work'] . ".";
		$summary_ = "";
		if ($row['summary'] !== "")
		{
			$sum = "Summary: ";
			$summary = $row['summary'];
		}
		$exprience = "";
		if ($row['experience'] !== "")
		{
			$exp = "Experience: ";
			$exprience = $row['experience'];
		}
		$phone_number="";
		$phone_pic="";
        if($row['phone_number']!=="")
        {
            $phone_number="\"<a href =  callto:" . $row['phone_number'] . "  >" .$row['phone_number']. "</a>\"";
            $phone_pic = "<img id = 'std_phone_" .
				$row['ID'] . "' class='bubbels' src=\"./img/telephoneIcon.jpg\"
				 width='35' height='35' onclick='$(\"#phoneDiv\").html(".$phone_number.");'/>&#8209";
        }

		$mail_pic="";

		if($row['Email']!=="")
		{
            $maito_string = "\"<a href =  mailto:" . $row['Email'] . "  >" .$row['Email']. "</a>\"";
			$mail_pic = "<img id='std_mail_" . $row['ID'] .
				"' class='bubbels'  src=\"./img/mailIcon.png\" width='35' height='35' onclick='$(\"#mailDiv\").html(" .
				$maito_string . ");'/>&#8209";
		}

		echo "
			<table id ='myTable' border=1 frame=void rules=rows>
				<!--First Line: Picture+ Bubbles -->
			    <tr width=\"100%\">
			    
			        <td  width=\"100%\">
			            <img class='head_image' src =" . $img_src . " width ='120px' height='110px'>
			            
     			        	<h2 >" . $row['first_name'] . " " . $row['last_name'] . "</h2>
						
				            " . $git_string . "  " . $link_string . "  " . $cv_file . "
				            
				            <div id='phoneDiv'>"
								.$phone_pic."
							</div>
							 
				           <div id='mailDiv'>
				             ".$mail_pic."
				            </div>
				    
				         		
                    </td>

                	<!--Third Line: Sentence-->
                	
                 <tr class=\"border_bottom\">
                	<td>
                		" . $sentence . "
					</td>
                </tr>
                
                <!--Four Line: JobPer + CurrJob-->
                 <tr class=\"border_bottom\">
                	<td>
                		" . $job_per . "
					</td>
                	<td>
                		" . $curr_job . "
					</td>
                </tr>
                
                <!--Fifth Line: All Skills + ShowAll-->
                <tr id ='skill_tr' >
                	<td>
                		<h4><b>".$show_all_skills."</b></h4> ".$all_skills."
             
					</td>
                </tr>
                <!--Six Line: Sum + Experince-->
                <tr class=\"border_bottom\">
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
	/*if($func=="2")
	{
		//PDO STYLE :
		$sql = "SELECT * FROM student WHERE github<>'' ORDER BY profile_strength DESC";
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
	}*/

	//filter Linkedin
	if($func=="3")
	{
		//PDO STYLE :
		$sql = "SELECT * FROM student WHERE linkedin<>'' ORDER BY profile_strength DESC";
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
		$sql = 'SELECT * FROM student WHERE Activated=1 ORDER BY profile_strength DESC';
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
				function addSkillToList(skill_to_add,years_text,years_value)
				{
					var skill_years = skill_to_add +', '+ years_text;
					$('#add_skill').after(function() 
					{
					  return'<br><label class=\'skillsLabel\' for=\'skill_'+skill_to_add+'\'>'+skill_years +'</label><input name=\'skill_'+skill_to_add+'\' type=\'text\' class=\'skills\' style=\'display:none;\' value=\''+ years_value + '\' id=\'skill_'+skill_to_add+'\'>  ' 
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
                                alert(xmlhttp.responseText);
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
					<option value='1'>less then 1 year</option>
					<option value='2'>1 year</option>
					<option value='3'>2 years</option>
					<option value='4'>3 years</option>
					<option value='5'>more then 3 years</option>
				</select>
	
				<input type=\"button\" id = 'add_skill' value = \"+\" class='skills' onclick='addSkillToList(document.getElementById(\"skill_input\").value,$(\"#years_input option:selected\").text(),document.getElementById(\"years_input\").value);$(\"#skill_input\").val(\"\");'>
	
				<!--<input type=\"button\" id = 'add_skill' value = \"+\" class='skills' onclick='addSkillToList(document.getElementById(\"skill_input\").value,document.getElementById(\"years_input\").value);$(\"#skill_input\").val(\"\");'>-->
	
				
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
        echo " function #10 ";
        $skills_arr=array(array());
        $i=0;
		foreach($_GET as $key => $value)
		{
			if (strstr($key, 'skill_')){
                $skill = substr($key, strpos($key, '_')+1,strlen($key) );//eg. 'javascript'
                $skills_arr[$i][0]=$skill;
                $skills_arr[$i][1]=$value;
                $i++;
            }

		}
        $length = count($skills_arr);
		if($length==0) //no skills were selected
        {
            echo "<script>alert('no skills slected bloack in form ! as required')</script>";
            exit;
        }

		$skills_id=array();

        for($i=0;$i<$length ; $i++){
            $id_query = "SELECT id FROM skills WHERE name=:skill AND status = 1 LIMIT 1";
            $complete_query= $databaseConnection->prepare($id_query);
            $complete_query->bindParam(':skill',$skills_arr[$i][0]);
            $complete_query->execute();
            $id=$complete_query->fetch();
            $skills_id[$i] = $id[0];
        }
		$len=count($skills_arr);
		for($i=0;$i<$len;$i++)
		{
			$skills_arr[$i][0]=$skills_id[$i];
		}

		if(count($skills_id)==0) //could not get skills id
			exit;
		$std_id=array();
        for($i=0;$i<$len;$i++)
		{
			$student_id_query = "SELECT student_id FROM student_skills WHERE skill_id=:skill AND years=:time";
			$complete_query= $databaseConnection->prepare($student_id_query);
			$complete_query->bindParam(':skill',$skills_arr[$i][0]);
			$complete_query->bindParam(':time',$skills_arr[$i][1]);
			$complete_query->execute();
			$id=$complete_query->fetchAll();

            if($i ===0 ){
                echo "first : ";
                $len = count($id);
                for ($j=0;$j<$len;$j++){
                    $std_id[$j]=$id[$j][0];
                    echo $std_id[$j].", ";
                }
                echo "<br>";
                continue;

            }


            $temp_arr=array();
            foreach ($id as $recived_line){
                foreach ($std_id as $already_in){
                    echo "<br>".$recived_line[0]." == ? == ".$already_in;
                    if($recived_line[0] === $already_in){
                        echo "insert : ".$already_in; 
                        array_push($temp_arr, $already_in);
                        break;
                    }
                }
            }
            $std_id=array();
            $temp_len = count($temp_arr);
            for($i=0;$i<$temp_len-1 ;$i++) {
                array_push($std_id, array_push($temp_arr));
            }
            //$std_id=$temp_arr;

		}
        echo "<br>printing std_id at the end : ";
        $temp_len = count($std_id);
        for($i=0;$i<$temp_len ;$i++) {
           echo $std_id[$i]." , ";
        }
        echo "<br>";

		if(count($std_id)==0) //noBody has that skill !
        {
            echo 'No results were found, please try again with different filters';
            exit;
        }

		$sql = "SELECT * FROM student WHERE ID IN(".implode(',',$std_id).") ORDER BY profile_strength DESC" ;
        print_r($sql);
		$img_src = "../img/profilepic.png";
		foreach ($databaseConnection->query($sql) as $row)
		{
            
            echo "<br> ok <br>";
			/*$img_src ="";
			if(  $row['profile']=="" )
				$img_src = "./img/profilepic.png";
			else
				$img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
			
			echo "<div class='head' id='head_".$row['ID']."' > ";
			echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
			print_r($row['first_name']);
			echo "</div>";*/
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

