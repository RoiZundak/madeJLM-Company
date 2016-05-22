<?php
    session_start();
    if(empty($_SESSION['username']))
    {
        $url =  "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; //the current page
        $loginPage = "http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login";
        if ((strcmp($url,$loginPage))!== 0) //the current page isn't the login page
        {
            echo ("<a id='re_route' href ='#/login'>
            <script>
                document.getElementById(\"re_route\").click();
                alert('you MUST login first. redirecting...');
            </script>
            </a>");
        }
        else
            echo ("<script> alert('you MUST login first.');</script>");
        exit;
    }
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
        <div class="filters" id="skills">
            Skills
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
    	$link = mysql_connect("5.100.253.198", "jobmadeinjlm","q1w2e3r4");
		if (!$link) {
			die("Could not connect: " . mysql_error());
		}
		$db_selected = mysql_select_db("jobmadei_db", $link);
		if (!$db_selected) {
			die ("Can't use internet_database : " . mysql_error());
		}
		$result = mysql_query ('SELECT * FROM student');
		$img_src = "../img/profilepic.png";
		while ($row = mysql_fetch_assoc($result)) {
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
        } else {

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


        }
        , false);
	</script>
	
	
	
    </div>
</div>