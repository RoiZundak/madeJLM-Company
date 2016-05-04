<?php
session_start();
>

<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<div id ="login_container">

    <div id="login_form">
        <br>
        <h3>Login</h3>
		<?php

			if (isset ($_SESSION["what_is_wrong"]) ) {
				echo("incorrect ".$_SESSION["what_is_wrong"]);
			}
		
		?>
        <form method="post"  action="partials/login.php" class="login"  >
            <p>
                <label for="login">Email: </label>
                <input type="text" name="user_name" id="login" value="Example@example.com" onfocus="if($(this).val()=='Example@example.com')$(this).val('')" onblur="if($(this).val()=='')$(this).val('Example@example.com')">
            </p>

            <p>
                <label for="password">Password: </label>
                <input type="password" name="user_password" id="password" value="688822292" onfocus="if($(this).val()=='688822292')$(this).val('')" onblur="if($(this).val()=='')$(this).val('688822292')">
            </p>

            <p class="login-submit">
                <button type="submit" class="login-button">Login</button>
            </p>

            <p class="forgot-password"><a href="#/forgot">Forgot your password?</a></p>
        </form>
    </div>

</div>
<?php
// define variables and set to empty values
$name = $email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["user_name"]);
  $pass = test_input($_POST["user_password"]);
  if($name=="jobmadeinjlm" && $pass=="q1w2e3r4"){
	  unset($_SESSION["what_is_wrong"]);
	  $_SESSION["user_name"]= $name;
	  $_SESSION["user_pass"]= $pass;
	  header( 'Location: http://localhost/madeinJLM/#/main' );
  }else{
	  if($name=="jobmadeinjlm"){
		  $_SESSION["what_is_wrong"]= "Password";
	  }else{
		  $_SESSION["what_is_wrong"]= "User Name";
	  }
	  header( 'Location: http://localhost/madeinJLM/#/login' );
  }
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>