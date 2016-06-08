<?php
    echo
    "<script> 
            var name = sessionStorage.getItem('username');
            if ( name === 'null' || name === 'Not_Valid_User_Name' ) 
            {
                window.location='http://job.madeinjlm.org/madeJLM-Company/ActiveC/V0.1/#/login';
                setTimeout(function(){alert('You Must login first');},100);
            }
    </script>";
?>

<div id="main_wrap">

    <div id= "filter_main">
        <div class="filters" id="skills"> Skills </div>
        <div class="filters" id="has_linkedin"> Has Linkedin </div>
        <div class='filters' id="clr_filter"> Clear Filter's</div>
        <div id = "skill_std" class='speech' class='skills'> </div>

    </div>

    <div id = "show_stud"> </div>
    <div id = "show_all">


        <?php
            //db connect
            require_once "../php/db_connect.php";
            $databaseConnection =connect_to_db();
            //get all students
            $sql = 'SELECT * FROM student WHERE Activated=1 ORDER BY profile_strength DESC';
            $img_src = "../img/profilepic.png";
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
            }
        ?>
        <script>
            var id="-1";
            $("#skill_std").hide();
            document.addEventListener('click', function(e)
            {
                    e = e || window.event;
                    var target = e.target || e.srcElement;
                    if (window.XMLHttpRequest) // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                     else // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

                    console.log("the id is"+ target.id);

                    if (target.className !== "skills")
                        $("#skill_std").hide();

                    if (target.id == "skills")
                    {
                        $("#skill_std").show();
                        xmlhttp.onreadystatechange = function ()
                        {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                $("#skill_std").html(xmlhttp.responseText);
                        };
                        xmlhttp.open("GET", "comp_sql_querys.php?q=" + id + "&func=" + "9", true);
                        xmlhttp.send();
                    }

                    if(target.className =="head" || target.className =="head_image")
                    {
                        console.log("this is the id : "+target.id);
                        //noinspection JSUnresolvedFunction

                        id =target.id.substring(target.id.indexOf("_")+1,target.id.length); //student id
                        console.log("this is the id : "+id);
                        xmlhttp.onreadystatechange = function()
                        {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                document.getElementById("show_stud").innerHTML = xmlhttp.responseText;
                        };
                        xmlhttp.open("GET","comp_sql_querys.php?q="+id+"&func="+"1",true);
                        xmlhttp.send();

                        $("#show_stud").show("slow", function() {
                            // Animation complete.
                        });
                    }
                    else
                    {
                        if(target.id =="std_info")
                        {
                            $("#show_stud").hide("slow", function() {
                                // Animation complete.
                            });
                        }

                    }

                    if(target.id == "has_linkedin" )
                    {
                        xmlhttp.onreadystatechange = function()
                        {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                document.getElementById("show_all").innerHTML = xmlhttp.responseText;
                        };
                        xmlhttp.open("GET","comp_sql_querys.php?q="+id+"&func="+"3",true);
                        xmlhttp.send();
                    }
                    if(target.id == "clr_filter" ) 
                    {
                        xmlhttp.onreadystatechange = function ()
                        {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                document.getElementById("show_all").innerHTML = xmlhttp.responseText;
                        };
                        xmlhttp.open("GET", "comp_sql_querys.php?q=" + id + "&func=" + "4", true);
                        xmlhttp.send();
                    }
                    if(target.id.indexOf("std_mail_") != -1 )
                    {
                        id =target.id.substring(target.id.lastIndexOf("_")+1,target.id.length); //student id
                        xmlhttp.open("GET", "comp_sql_querys.php?q=" + id + "&func=" + "11", true);
                        xmlhttp.send();
                    }
                }
                , false);
        </script>
    </div>
</div>