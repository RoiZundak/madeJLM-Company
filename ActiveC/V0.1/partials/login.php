<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<div class="content">
    <h2>Log In</h2>
    <?php
    if(isset($msg)){
        echo "<h2>{$msg[0]}</h2><p>{$msg[1]}</p>";
    }
    ?>
    <form action="login.php" method="POST" style="margin:0px auto;display:table;">
        <label>
            <p>Username / E-Mail</p>
            <input name="login" type="text"/>
        </label><br/>
        <label>
            <p>Password</p>
            <input name="password" type="password"/>
        </label><br/>
        <label>
            <p>
                <input type="checkbox" name="remember_me"/> Remember Me
            </p>
        </label>
        <div clear></div>
        <button style="width:150px;" name="action_login">Log In</button>
    </form>
    <style>
        input[type=text], input[type=password]{
            width: 230px;
        }
    </style>
    <p>
    <p>Don't have an account ?</p>
    <a class="button" href="register.php">Register</a>
    </p>
    <p>
    <p>Forgot Your Password ?</p>
    <a class="button" href="reset.php">Reset Password</a>
    </p>
</div>