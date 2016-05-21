<?php
//Connects to your Database
$conect = mysqli_connect("localhost","jobmadeinjlm","q1w2e3r4", "forks") or die(mysql_error());
//Checks if there is a login cookie
if(isset($_COOKIE['ID_your_site'])){ //if there is, it logs you in and directes you to the members page
    $username = $_COOKIE['ID_your_site'];
    $pass = $_COOKIE['Key_your_site'];
    $check = mysqli_query($conect, "SELECT * FROM company WHERE username = '$username'")or die(mysql_error());
    while($info = mysqli_fetch_array( $check )){
        if ($pass != $info['password']){}
        else{
            header("Location: login.php");
        }
    }
}
//if the login form is submitted
if (isset($_POST['submit'])) {
    // makes sure they filled it in
    if(!$_POST['username']){
        die('You did not fill in a username.');
    }
    if(!$_POST['pass']){
        die('You did not fill in a password.');
    }
    // checks it against the database
    if (!get_magic_quotes_gpc()){
        $_POST['email'] = addslashes($_POST['email']);
    }
    $check = mysqli_query($conect, "SELECT * FROM company WHERE username = '".$_POST['username']."'")or die(mysql_error());
    //Gives error if user dosen't exist
    $check2 = mysqli_num_rows($check);
    if ($check2 == 0){
        die('That user does not exist in our database.<br /><br />If you think this is wrong <a href="login.php">try again</a>.');
    }
    while($info = mysqli_fetch_array( $check )){
        $_POST['pass'] = stripslashes($_POST['pass']);
        $info['password'] = stripslashes($info['password']);
        $_POST['pass'] = md5($_POST['pass']);
        //gives error if the password is wrong
        if ($_POST['pass'] != $info['password']){
            die('Incorrect password, please <a href="login.php">try again</a>.');
        }

        else{ // if login is ok then we add a cookie
            $_POST['username'] = stripslashes($_POST['username']);
            $hour = time() + 3600;
            setcookie(ID_your_site, $_POST['username'], $hour);
            setcookie(Key_your_site, $_POST['pass'], $hour);

            //then redirect them to the members area
            header("Location: main.php");
        }
    }
}
else{
// if they are not logged in
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

        <table border="0">

            <tr><td colspan=2><h1>Login</h1></td></tr>

            <tr><td>Username:</td><td>

                    <input type="text" name="username" maxlength="40">

                </td></tr>

            <tr><td>Password:</td><td>

                    <input type="password" name="pass" maxlength="50">

                </td></tr>

            <tr><td colspan="2" align="right">

                    <input type="submit" name="submit" value="Login">

                </td></tr>

        </table>

    </form>

    <?php
}
?>
<!--
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<div id ="login_container">

    <div id="login_form">
        <br>
        <h3>Login</h3>
        <?php
        if(isset($msg)){
            echo "<script>console.log({$msg[0]} {$msg[1]})</script>";
        }
        ?>
        <form class="login"  action="login.php" method="POST">
            <p>
                <label for="login">Email: </label>
                <input type="text" name="user_name" id="login"   value="Example@example.com" onfocus="if($(this).val()=='Example@example.com')$(this).val('')" onblur="if($(this).val()=='')$(this).val('Example@example.com')">
            </p>

            <p>
                <label for="password">Password: </label>
                <input type="password" name="user_password" id="password" value="688822292" onfocus="if($(this).val()=='688822292')$(this).val('')" onblur="if($(this).val()=='')$(this).val('688822292')">
            </p>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember_me"> Remember me
                </label>
            </div>

            <p class="login-submit">
                <button type='submit' class="login-button" name="action_login">Log In</button>
            </p>

            <p class="forgot-password"><a href="#/forgot">Forgot your password?</a></p>
        </form>
    </div>

</div>