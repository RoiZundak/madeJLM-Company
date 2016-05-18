    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <div id ="login_container">

        <div id="login_form">
            <br>
            <h3>Login</h3>
            <form class="login"  ng-submit="login()">
                <p>
                    <label for="login">Email: </label>
                    <input type="text" name="user_name" id="login" ng-model="data.login.Email"   value="Example@example.com" onfocus="if($(this).val()=='Example@example.com')$(this).val('')" onblur="if($(this).val()=='')$(this).val('Example@example.com')">
                </p>

                <p>
                    <label for="password">Password: </label>
                    <input type="password" name="user_password" id="password" ng-model="data.login.Password" value="688822292" onfocus="if($(this).val()=='688822292')$(this).val('')" onblur="if($(this).val()=='')$(this).val('688822292')">
                </p>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" ng-model="data.login.auto"> Remember me
                    </label>
                </div>

                <p class="login-submit">
                    <button type="submit" class="login-button">Login</button>
                </p>

                <p class="forgot-password"><a href="#/forgot">Forgot your password?</a></p>
            </form>
        </div>

    </div>
