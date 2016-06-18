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
    $bulk_size=200;
    $temp=0;
    //show single student
    if($func=="1")
    {
        $q = intval($_GET['q']);
        $sql_update="UPDATE student SET counter_view = counter_view + 1 WHERE ID = :id";
        $update = $databaseConnection ->prepare($sql_update);
        $update->bindParam(":id",$q);
        $update->execute();
        //PDO STYLE :
        $sql="SELECT * FROM student WHERE ID = :id LIMIT 1";
        $update = $databaseConnection ->prepare($sql);
        $update->bindParam(":id",$q);
        $update->execute();
        $result = $update->fetchAll();
        $img_src = "../img/profilepic.png";
        foreach ($result as $row)
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
                $cv_file = "<a href='../../../MadeinJLM-students/mockup/API/Student/getCV?id=".$row['ID']."' download='" .$row['first_name']. $row['last_name'] . "'> <img class=\"bubbels\" title=\"Cv\" alt=\"Cv\" src=\"./img/CVIcon.png\"/> </a>";


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
            //Build data sentence :
            $college_name = "";
            foreach ($databaseConnection->query($sql_college) as $college) {
                $college_name = $college['name'];
            }
            $degree_name = "";
            foreach ($databaseConnection->query($sql_degree) as $degree) {
                $degree_name = $degree['name'];
            }
            $sentence = "Studies ";
            if($degree_name!==""){
                $sentence.="for a ". $degree_name." ";
                if($row['basic_education_subject']!==""){
                    $sentence.="in ". $row['basic_education_subject']." ";
                }
            }else{
                //no degree
                if($row['basic_education_subject']!==""){
                    $sentence.= $row['basic_education_subject']." ";
                }
            }
            if($college_name!==""){
                $sentence.="at ". $college_name." ";
            }
            if($row['grade_average']!=="" && intval($row['grade_average'])!==0){
                if($sentence === "Studies "){
                    $sentence="Has a GPA of ". $row['grade_average']." ";
                }else{
                    $sentence.="with a GPA of ". $row['grade_average']." ";
                }
            }
            if($row['semesters_left']!=="" && intval($row['semesters_left'])!==0){
                if($sentence === "Studies "){
                    $sentence="Has " . $row['semesters_left'] . " semesters left";
                }else{
                    $sentence.=" and has " . $row['semesters_left'] . " semesters left";
                }

            }
            if($sentence === "Studies "){
                $sentence = $row['first_name']. " hasn't fulfilled all the basic information fields. for more Information, contact with ".$row['first_name'].".";
            }else{
                $sentence.=".";
            }
    /*
            if ($degree_name=="" || $row['basic_education_subject']=="" || $college_name=="" || $row['grade_average']=="" || $row['semesters_left']=="")
                $sentence = $row['first_name']. " hasn't fulfilled all the basic information fields. for more Information, contact with ".$row['first_name'].".";
            else
                $sentence = "Studies for a " . $degree_name . " in " . $row['basic_education_subject'] . " at " . $college_name . " with GPA of " . $row['grade_average'] . " and has " . $row['semesters_left'] . " semesters left.";
    */

            //build 2nd sentence:
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
                     width='35' height='35' onclick='$(\"#phoneDiv\").html(".$phone_number.");'/>";
            }

            $mail_pic="";

            if($row['Email']!=="")
            {
                $maito_string = "\"<a href =  mailto:" . $row['Email'] . "  >" .$row['Email']. "</a>\"";
                $mail_pic = "<img id='std_mail_" . $row['ID'] .
                    "' class='bubbels'  src=\"./img/mailIcon.png\" width='35' height='35' onclick='$(\"#mailDiv\").html(" .
                    $maito_string . ");'/>";
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
                    
                    <!--Four Line: JobPer-->
                     <tr class=\"border_bottom\">
                        <td>
                            " . $job_per . "
                        </td>
                        
                    </tr>
                     <!--Four point five Line:  CurrJob-->
                    <tr class=\"border_bottom\">
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
                    <!--Six Line: Summary-->
                    <tr class=\"border_bottom\">
                        <td>
                                <h4><b>" . $sum . "</h4></b>" . $summary . "
                        </td>

                    </tr>
                    <!--Seven'th Line:  Experince-->
                    <tr class=\"border_bottom\">

                        <td>
                                <h4><b>" . $exp . "</h4></b>" . $exprience . " 
                            
                        </td>
                    </tr>
                    
                </table>
                ";
        }
    }


    //filter Linkedin
    if($func=="3") {
            //PDO STYLE :
        $temp=0;
        $img_src = "../img/profilepic.png";
        while(true){
                $sql = "SELECT * FROM student WHERE linkedin<>'' ORDER BY profile_strength DESC LIMIT ".$bulk_size." OFFSET ".($temp*$bulk_size);
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
                    $count_recived++;
                }
                if($count_recived != $bulk_size){
                    break;
                }
                $temp++;
            }
        }
	//clear
	if($func=="4")
	{
        while(true){
            $sql = 'SELECT * FROM student WHERE Activated=1 ORDER BY profile_strength DESC LIMIT '.$bulk_size.' OFFSET '.($temp*$bulk_size);

            $img_src = "../img/profilepic.png";
            $count_recived=0;
            foreach ($databaseConnection->query($sql) as $row)
            {
                if(  $row['profile']=="" )
                    $img_src = "../V0.1/img/profilepic.png";
                else
                    $img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
                echo "<div class='head' id='head_".$row['ID']."' > ";
                echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
                print_r($row['first_name']);
                echo "</div>";
                $count_recived++;
            }
            if($count_recived != $bulk_size){
                break;
            }
            $temp++;
        }



	}

	//ADD new company
	if($func=="5")
	{
		$name =strtolower($_POST["username"]);
		$mail = strtolower($_POST['e_mail']);
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
            echo "
            <script>
            window.location='#/login';
            setTimeout(function(){alert('Great! ".$name." was added to the db with ID = ".$newId."');},100);
            </script>
            ";
		}
		else
            echo "
            <script>
            window.location='#/login';
                setTimeout(function(){alert('Sorry , we could not add this company');},100);
            </script>
            ";
	}

	//DELETE company (by id)
	if($func=="6")
	{
		$row_number =$_POST["row_id"] ;

		//PDO STYLE :
		$records = $databaseConnection->prepare('DELETE FROM company WHERE id= :row_id');
		$records->bindParam(':row_id', $row_number);
		if ( $records->execute()==true)
            echo "
            <script>
            window.location='#/login';
            setTimeout(function(){alert('Great! Company #".$row_number." was DELETED from the db ');},100);
            </script>
            ";
		else
            echo "
            <script>
            window.location='#/login';
            setTimeout(function(){alert('Sorry , we could not delete this company');},100);
            </script>
            ";
	}

	//echo ALL companies
	if($func=="7")
	{
		echo"<table style=\"width:100%\">
			<tr>
			  	<td>id</td>
			  	<td>Comp. Name</td>
			  	<td>e-Mail</td>
			  	<td>Counter Enters</td>
			</tr>";
		$sql = "SELECT * FROM company ORDER BY counter_enters DESC";
		//PDO STYLE :
		foreach ($databaseConnection->query($sql) as $row)
		{
			echo "<tr> ";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['username']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['counter_enters']."</td>";
			echo "</tr>";
		}
		echo"</table>";
	}

    //Update Company password
    if($func=="8")
	{
        $pass1 =$_POST['new_pass'] ;
        $pass2 =$_POST['new_pass_conf'] ;
        $mail = $_POST['e_mail'];
        if(strcmp($pass1,$pass2)!=0 )
		{
            echo "<script>
			window.location='#/login';
            setTimeout(function(){alert('Passwords does not match.Redirecting to login page..');},100);</script>";
            exit;
        }
        //PDO STYLE :
        $sql = "UPDATE company SET password = :pass, 
            f_pass = '', 
            f_exp = 0,  
            WHERE email = :email";
        $stmt = $databaseConnection->prepare($sql);
        $stmt->bindParam(':pass', md5($pass1), PDO::PARAM_STR);
        $stmt->bindParam(':email',$mail, PDO::PARAM_STR);
        if ( $stmt->execute()==true)
            echo "
            <script>
            window.location='#/login';
            setTimeout(function(){alert('Password was updated.');},100);
            </script>
            ";
        else
            echo "
            <script>
            window.location='#/login';
            setTimeout(function(){alert('Failed to update');},100);
            </script>
            ";
    }

	if($func=="9")
	{
		$sql = 'SELECT * FROM skills';
		echo "<script>
				//adds a label and input text containing skill value
				function addSkillToList(skill_to_add,years_text,years_value)
				{
				    var obj  =$('#skills_list').find('option[value=\"'+skill_to_add+'\"]');
				    if(skill_to_add=='' || obj==null ||obj.length==0){
				        return;
				    }
					var skill_years = skill_to_add +', '+ years_text;
					var str = $(\"#form_skills\").serialize();
					if(str.indexOf(skill_to_add)>0){
					    $('label[for=skill_'+skill_to_add+']').remove();
                        $('#skill_'+skill_to_add).remove();
					}
					$('#input_div').after(function() 
                    {
                      return'<br><label class=\'skillsLabel\' for=\'skill_'+skill_to_add+'\'>'+skill_years +'</label><input name=\'skill_'+skill_to_add+'\' type=\'text\' class=\'skills\' style=\'display:none;\' value=\''+ years_value + '\' id=\'skill_'+skill_to_add+'\'>  ' 
                    });
				}
				$( \"#form_skills\" ).submit(function( event ) 
				{
					event.preventDefault();
					var str = $(\"#form_skills\").serialize();
					if (str.includes(\"skill_\")==false) {
					    return;
					}
					xmlhttp.onreadystatechange = function() 
					{
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							if(xmlhttp.responseText!=''){
                                document.getElementById(\"show_all\").innerHTML = xmlhttp.responseText;
							}else{
							    document.getElementById(\"show_all\").innerHTML = 'nothing to show , please try again';
							}
						}
							
					};
					//xmlhttp.open(\"GET\",\"comp_sql_querys.php?func=10&\",true);
					xmlhttp.open(\"GET\",\"comp_sql_querys.php?func=10&\"+str,true);
					xmlhttp.send();
				});
				</script>";

		echo "
				<form method='post' id= 'form_skills' class='skills' action='./comp_sql_querys.php?func=10'>	
				<div id='input_div' class='skills'>
				<input type=\"text\" list=\"skills_list\" id='skill_input' class='skills'>
				<input type=\"button\" id = 'add_skill' value = \"+\" class='skills' onclick='addSkillToList(document.getElementById(\"skill_input\").value,$(\"#years_input option:selected\").text(),document.getElementById(\"years_input\").value);$(\"#skill_input\").val(\"\");'>
				<select id='years_input' class='skills'>
					<option value='0' selected='selected'>All years of experience</option>
					<option value='1'>less then 1 year</option>
					<option value='2'>1 year</option>
					<option value='3'>2 years</option>
					<option value='4'>3 years</option>
					<option value='5'>more then 3 years</option>
				</select>
				<datalist id=\"skills_list\">";
                foreach ($databaseConnection->query($sql) as $row)
                    echo '<option value='.$row['name'].'>';
                //close datalist , input_div and form , add submit input
                echo "</datalist><br>
                    </div>
				<input type=\"submit\" value=\"Filter\" id=\"submit_skills\">
				</form>";
	}

	if($func=="10")
	{
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
            echo "<script>alert('no skills slected block in form ! as required');</script>";
            exit;
        }
        //GET SKILLS ID
		$skills_id=array();
        for($i=0;$i<$length ; $i++){
            $id_query = "SELECT id FROM skills WHERE name=:skill AND status = 1 LIMIT 1";
            $complete_query= $databaseConnection->prepare($id_query);
            $complete_query->bindParam(':skill',$skills_arr[$i][0]);
            $complete_query->execute();
            $id=$complete_query->fetch();
            $skills_id[$i] = $id[0];
        }
		$len=count($skills_id);
        if($len===0){
            echo" stop here.";
            exit;
        }
        //OVERRIDE SKILL_NAME WITH SKILL_ID
		for($i=0;$i<$len;$i++)
		{
			$skills_arr[$i][0]=$skills_id[$i];
		}
        //GET STUDENTS ID FOR EACH SKILL, USE "AND"
		$std_id=array();
        for($i=0;$i<$length;$i++)
		{
            if ($skills_arr[$i][1]==='0' ){
                $student_id_query = "SELECT student_id FROM student_skills WHERE skill_id=:skill";
                $complete_query= $databaseConnection->prepare($student_id_query);
                $complete_query->bindParam(':skill',$skills_arr[$i][0]);
            }else {
                $student_id_query = "SELECT student_id FROM student_skills WHERE skill_id=:skill AND years=:time";
                $complete_query = $databaseConnection->prepare($student_id_query);
                $complete_query->bindParam(':skill', $skills_arr[$i][0]);
                $complete_query->bindParam(':time', $skills_arr[$i][1]);
            }
			$complete_query->execute();
			$id=$complete_query->fetchAll();
            if(count($id)==0){
                echo 'No results were found, please try again with different filters';
                exit;
            }
            if($i === 0 ){
                $len = count($id);
                for ($j=0;$j<$len;$j++){
                    $std_id[$j]=$id[$j][0];
                }
                continue;
            }
            $temp_arr=array();
            foreach ($id as $recived_line){
                foreach ($std_id as $already_in){
                    if($recived_line[0] === $already_in){
                        array_push($temp_arr, $already_in);
                        break;
                    }
                }
            }
            $std_id=array();
            $temp_len = count($temp_arr);
            for($i=0;$i<$temp_len ;$i++) {
                array_push($std_id, array_pop($temp_arr));
            }
		}
		if(count($std_id)==0) //noBody has that skill !
        {
            echo 'No results were found, please try again with different filters';
            exit;
        }
        $temp=0;
        //$sql = 'SELECT * FROM student WHERE Activated=1 ORDER BY profile_strength DESC '; WORKING QUERY


        while(true){
            $sql = 'SELECT * FROM student WHERE Activated=1 AND ID IN ('.implode(",",$std_id).') ORDER BY  profile_strength DESC LIMIT '.$bulk_size.' OFFSET '.($temp*$bulk_size);
            $stmt = $databaseConnection->prepare($sql);
            $stmt->bindParam(':id_arr', $imp_str);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $img_src = "../img/profilepic.png";
            $count_recived=0;
            foreach ($result as $row)
            {
                if(  $row['profile']=="" )
                    $img_src = "../V0.1/img/profilepic.png";
                else
                    $img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
                echo "<div class='head' id='head_".$row['ID']."' > ";
                echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
                print_r($row['first_name']);
                echo "</div>";
                $count_recived++;
            }
            if($count_recived != $bulk_size){
                break;
            }
            $temp++;
        }



	}

    //increment student contact stats
	if($func=="11")
	{
		$id = intval($_GET['q']); //student id
		$sql_update="UPDATE student SET counter_contact = counter_contact + 1 WHERE ID = :id";

		$update = $databaseConnection ->prepare($sql_update);
        $update->bindParam(':id',$id);
		$update->execute() ;

	}

    //reset company password -ADMIN
    if($func=="12")
    {
        $row_id =$_POST['row_id_reset'] ;
        $newPassword =$_POST['new_pass'] ;
        $sql_update_pass = "UPDATE company SET password = :pass WHERE id=:id";
        $update = $databaseConnection ->prepare($sql_update);
        $update->bindParam(':id',$row_id);
        $update->bindParam(':pass',md5($newPassword));
        if( $update->execute()==true){
            echo "
            <script>
            window.location='#/adminPage';
            setTimeout(function(){alert('Password has changed');},100);
            </script>
            ";
        }else{
            echo "
            <script>
            window.location='#/adminPage';
            setTimeout(function(){alert('Something went wrong, please try again.');},100);
            </script>
            ";
        }
    }

    //list all students
    if($func == "13")
	{
        echo"<table id='std_table' style=\"width:100%\">
			<tr>
			  	<td>id</td>
			  	<td>First Name</td>
			  	<td>Last Name</td>
			  	<td>e-Mail</td>
			  	<td>Phone</td>
			  	<td>Activated</td>
			  	<td>RegDate</td>
			  	<td>LastLogin</td>
			  	<td>basic_education_subject</td>
			  	<td>degree_id</td>
			  	<td>semesters_left</td>
			  	<td>college_id</td>
			  	<td>job_percent</td>
			  	<td>current_work</td>
			  	<td>summary</td>
			  	<td>experience</td>
			  	<td>linkedin</td>
			  	<td>github</td>
			  	<td>cv</td>
			  	<td>counter_view</td>
			  	<td>counter_contact</td>
			  	<td>grade_average</td>
			  	<td>profile_strength</td>
			  	
			</tr>";
        $sql = "SELECT * FROM student";
        //PDO STYLE :
        foreach ($databaseConnection->query($sql) as $row)
        {
            echo "<tr> ";
            echo "<td>".$row['ID']."</td>";
            echo "<td>".$row['first_name']."</td>";
            echo "<td>".$row['last_name']."</td>";
			echo "<td>".$row['Email']."</td>";
            echo "<td>".$row['phone_number']."</td>";
            echo "<td>".$row['Activated']."</td>";
            echo "<td>".$row['RegDate']."</td>";
			echo "<td>".$row['LastLogin']."</td>";
			echo "<td>".$row['basic_education_subject']."</td>";
			echo "<td>".$row['degree_id']."</td>";
			echo "<td>".$row['semesters_left']."</td>";
			echo "<td>".$row['college_id']."</td>";
			echo "<td>".$row['job_percent']."</td>";
			echo "<td>".$row['current_work']."</td>";
			echo "<td>".$row['summary']."</td>";
			echo "<td>".$row['experience']."</td>";
			echo "<td>".$row['linkedin']."</td>";
			echo "<td>".$row['github']."</td>";
			echo "<td>".$row['cv']."</td>";
			echo "<td>".$row['counter_view']."</td>";
			echo "<td>".$row['counter_contact']."</td>";
			echo "<td>".$row['grade_average']."</td>";
			echo "<td>".$row['profile_strength']."</td>";
            echo "</tr>";
        }
        echo"</table>";
    }

    //Remove student
    if($func == "14"){
        $row_number =$_POST["student_id"] ;
        //PDO STYLE :
        $records = $databaseConnection->prepare('DELETE FROM student WHERE ID= :row_id');
        $records->bindParam(':row_id', $row_number);
        if ( $records->execute()==true && count($records->fetchAll()))
            echo "
                <script>
                window.location='#/adminPage';
                setTimeout(function(){alert('Great! student #".$row_number." was DELETED from the db ');},100);
                </script>
                ";
        else
            echo "
                <script>
                window.location='#/adminPage';
                setTimeout(function(){alert('Failed to DELETE student, please make sure you have the correct ID.');},100);
                </script>
                ";
    }

    //Change student status
    if($func == "15"){
        $id =$_POST['std_id'] ;
        $op =$_POST['state_op'] ;
        //PDO STYLE :
        $records = $databaseConnection->prepare("UPDATE student SET Activated =:active WHERE ID = :id");
        $update->bindParam(':id',$id);
        $update->bindParam(':active',$op);
        if ( $records->execute()==true)
            echo "
                <script>
                window.location='#/adminPage';
                setTimeout(function(){alert('Updated');},100);
                </script>
                ";
        else
            echo "
                <script>
                window.location='#/adminPage';
                setTimeout(function(){alert('Failed');},100);
                </script>
                ";
    }

    //Add new skill
    if($func == "16"){
        $name =$_POST["skill_name"];
        //PDO SYTLE :
        $records = $databaseConnection->prepare('INSERT INTO skills (name, status) VALUES (:name,1)');
        $records->bindParam(':name', $name);
        if ( $records->execute()==true)
        {
            $newId = $databaseConnection->lastInsertId();
            echo "
                <script>
                window.location='#/adminPage';
                setTimeout(function(){alert('Great! ".$name." was added to the db with ID = ".$newId."');},100);
                </script>
                ";
        }
        else
            echo "
                <script>
                window.location='#/adminPage';
                setTimeout(function(){alert('Failed');},100);
                </script>
                ";
    }
    //Top 10 Companies
    if($func=="17"){
    echo"<table style=\"width:100%\">
			<tr>
			  	<td>Id</td>
			  	<td>Company Name</td>
			  	<td>Entrnces</td>
			</tr>";
     $sql = "SELECT id,username,counter_enters FROM company ORDER BY counter_enters DESC LIMIT 10";


        //PDO STYLE :
    foreach ($databaseConnection->query($sql) as $row)
    {
        echo "<tr> ";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['counter_enters']."</td>";
        echo "</tr>";
    }
    echo"</table>";
    }

    //Top 10 Students
    if($func=="18") {
    echo"<table style=\"width:100%\">
			<tr>
			  	<td>id</td>
			  	<td>first_name</td>
			  	<td>last_name</td>
			  	<td>counter_view</td>
			  	<td>counter_contact</td>
			</tr>";
     $sql = "SELECT id,first_name,last_name,counter_view,counter_contact FROM student ORDER BY counter_contact DESC LIMIT 10";

        //PDO STYLE :
    foreach ($databaseConnection->query($sql) as $row)
    {
        echo "<tr> ";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['counter_view']."</td>";
        echo "<td>".$row['counter_contact']."</td>";
        echo "</tr>";
    }
    echo"</table>";
}
    //Deactivate students
    if($func == "19") {
    echo"<table id='std_table' style=\"width:100%\">
			<tr>
			  	<td>id</td>
			  	<td>First Name</td>
			  	<td>Last Name</td>
			  	<td>Num.Reason<td>
			  	<td>Description<td>
			  	<td>e-Mail</td>
			  	<td>Phone</td>
			  	<td>time</td>

			</tr>";
    $sql = "SELECT Distinct student.ID,first_name,last_name,reason,description,Email,phone_number,time FROM student,student_turn_off 
              WHERE student_turn_off.student_id=student.ID  ORDER BY time DESC";
    //PDO STYLE :
    foreach ($databaseConnection->query($sql) as $row)
    {
        echo "<tr> ";
        echo "<td>".$row['ID']."</td>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['reason']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$row['Email']."</td>";
        echo "<td>".$row['phone_number']."</td>";
        echo "<td>".$row['time']."</td>";

        echo "</tr>";
    }
    echo"</table>";
}
    //Top 10 Last Deactivate students
    if($func == "20") {
        echo"<table id='std_table' style=\"width:100%\">
			<tr>
			  	<td>id</td>
			  	<td>First Name</td>
			  	<td>Last Name</td>
			  	<td>Num.Reason<td>
			  	<td>Description<td>
			  	<td>e-Mail</td>
			  	<td>Phone</td>
			  	<td>Time</td>

			</tr>";
    $sql = "SELECT Distinct student.ID,first_name,last_name,reason,description,Email,phone_number,time FROM student,student_turn_off 
              WHERE student_turn_off.student_id=student.ID  ORDER BY time DESC LIMIT 10 ";
    //PDO STYLE :
    foreach ($databaseConnection->query($sql) as $row)
    {
        echo "<tr> ";
        echo "<td>".$row['ID']."</td>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['Email']."</td>";
        echo "<td>".$row['phone_number']."</td>";
        echo "<td>".$row['time']."</td>";
        echo "<td>".$row['reason']."</td>";
        echo "<td>".$row['description']."</td>";

        echo "</tr>";
    }
    echo"</table>";
}
?>

