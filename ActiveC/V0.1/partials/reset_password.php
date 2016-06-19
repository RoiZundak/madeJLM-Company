<!--****************************************************************************
********************************************************************************
********************************************************************************
*************************Reset Password Page-PHP********************************
********************************************************************************
********************************************************************************
*****************************************************************************-->
<?php
    //connect to db
    require_once "../php/db_connect.php";
    $databaseConnection =connect_to_db();
    if($_GET['t']=="company"){
        $table = "company";
    }else{
        $table = "admin";
    }
    if($table === "company"){
        $sql = "SELECT * FROM company WHERE email = :email";
    }else{
        $sql = "SELECT * FROM admin WHERE Email = :email";
    }
    $stmt = $databaseConnection->prepare($sql);
    $stmt->bindParam(":email",$_GET['mail']);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach($result as $row){
        $exp = $row['f_exp'];
        $code = $row ['f_pass'];
    }

    if($exp !=$_GET['e'] || $exp <= time() || strcmp ($code , $_GET['p'])!=0 )
    {
        //first condition : someone is trying something fishy.
        //second : expiration date has already passed
        //third : code is not the same in db and link
        echo "<script>
			window.location='#/login';
            setTimeout(function(){alert('This link has expired.Redirecting to login page..');},100);</script>";
        exit;
    }
?>


<!-- Page Content -->

<div class="container">

    <div class="row">

        <div class="col-sm-8">
            <h3>Reset Password</h3>

            <div class="col-sm-4">
                <form method="post" action="../comp_sql_querys.php?func=8" style="width:40%;background-color:lightgrey;border-width: thin;border-style: solid " >
                    <p>
                        <label for="new_pass">new Password : </label>
                        <input type="password" name="new_pass" id="new_pass">
                    </p>

                    <p>
                        <label for="new_pass_conf">confirm Password : </label>
                        <input type="password" name="new_pass_conf" id="new_pass_conf">
                    </p>
                    <?php
                        echo "<input type ='hidden' name='e_mail' value='".$_GET['mail']."'>";
                        echo "<input type ='hidden' name='type_b' value='".$table."'>";
                    ?>

                    <button type="submit" name = "submit" class="login-button">Login</button>
                </form>
            </div>
        </div>
    </div>