<?php

// session_start();
echo "
            <script> 
            var name = sessionStorage.getItem('username');
            if ( name === null || name === 'Not_Valid_User_Name' ) {
                //document.getElementById(\"re_route_login\").click();
                document.write('<a href=\'./#/login\' id =\'link_back\' > go back</a>');
                //window.stop();
                <!--
            }
            </script>";
/*No session currently working
if(empty($_SESSION['username'])){
    echo ("
    You are not logged in. <br> <br>
    <a id='re_route' href ='./#/login\'>
        Go Back
    </a>
");
    exit;
}
*/
?>

<div id="main_wrap">
    <div id = "filter_main">
    Filter<br>
        <div class="filters" id="all">
            All Players
        </div>
        <div class="filters" id="has_git">
            Has Github
        </div>
        <div class="filters" id="has_linkedin">
            Has Linkedin
        </div>
        <div class="filters" id="area">
            Area
        </div>
        <div >
            <input type="text" class="skill" id="skills" value="Skills">
        </div>
        <div class="filters" id="nearby">
            Nearby
        </div>
        <div class="filters" id='clr_filter'>
            Clear All
        </div>


    </div>
    <div id = "show_std">

    </div>
    <div id = "std_info"  >
	<?php
    //db connect
        require_once "../php/db_connect.php";
        $databaseConnection =connect_to_db();
        //get all students
        $sql = 'SELECT * FROM student';
        $img_src = "../img/profilepic.png";
        foreach ($databaseConnection->query($sql) as $row) {
            if(  $row['profile']=="" ){
                $img_src = "../V0.1/img/profilepic.png";
            }else{
                $img_src="../../../MadeinJLM-students/mockup/".$row['profile'];
            }
            echo "<div class='head' id='head_".$row['ID']."' > ";
            echo "<img class='head_image' id='headimage_".$row['ID']. "' src='".$img_src."' width='120px' height='110px'>";
            print_r($row['first_name']);
            echo "</div>";
        }
	?>
	<script>
	var id="-1";
	document.addEventListener('click', function(e) {
		e = e || window.event;
		var target = e.target || e.srcElement;
		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        
        if(target.className =="head" || target.className =="head_image"){
                console.log("this is the id : "+target.id);
                //noinspection JSUnresolvedFunction
                $("#show_std").hide();
                id =target.id.substring(target.id.indexOf("_")+1,target.id.length);
                console.log("this is the id : "+id);
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("show_std").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","comp_sql_querys.php?q="+id+"&func="+"1",true);
                xmlhttp.send();

                $("#show_std").show("slow", function() {
                    // Animation complete.
                });
        } 
        else {

            if(target.id =="std_info"){
                $("#show_std").hide("slow", function() {
                    // Animation complete.
                });
            }

            }
            if(target.id == "has_git" ){
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("std_info").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","comp_sql_querys.php?q="+id+"&func="+"2",true);
                xmlhttp.send();
            }
            if(target.id == "has_linkedin" ){
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("std_info").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","comp_sql_querys.php?q="+id+"&func="+"3",true);
                xmlhttp.send();
            }
            if(target.id == "clr_filter" ){
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("std_info").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","comp_sql_querys.php?q="+id+"&func="+"4",true);
                xmlhttp.send();
            }
            if(target.id == "skills" ){
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("std_info").innerHTML = xmlhttp.responseText;
                    }
                    
                };
                xmlhttp.open("GET","comp_sql_querys.php?q="+id+"&func="+"9",true);
                xmlhttp.send();
            }


        }
        , false);
	</script>
	
	
	
    </div>
</div>