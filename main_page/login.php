<?php
    session_start();
    include_once ("csrf.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

    <body>
        <strong>Login Page</strong>
        <fieldset>
            <legend> Login</legend>
            <form id="login" method="POST" action="auth-process.php?action=<?php echo ($action = 'login'); ?>"
            enctype="multipart/form-data">

            <label for="email"> Email: </label>
                <div> <input id="email" type="email" name="email" required="required" pattern="^[\w\/-][\w'\/\.-]*@[\w-]+(\.[\w-]+)*(\.[\w]{2,6})$"/></div>
                

            <label for="userid"> Password: </label>
                <div> <input id="password" type="password" name="pw" required="required" pattern="^[\w@#$^&*-]+$"/></div>
                <input type="submit" value="Login"/>
                <input type="hidden" name = "nonce" value="<?php echo csrf_getNonce($action);?>" />
            </form>
        </fieldset>
        <br>
        <fieldset>
        <legend> Change password</legend>
        <form id="change" method="POST" action="auth-process.php?action=<?php echo ($action = 'change'); ?>"
        enctype="multipart/form-data">
            <label for="change_email"> Email </label>
            <div> <input id="change_email" type="email" name="change_email" required="required" pattern="^[\w\/-][\w'\/\.-]*@[\w-]+(\.[\w-]+)*(\.[\w]{2,6})$"/></div>
            <label for="change_old_password"> Current Password </label>
            <div> <input id="change_old_password" type="password" name="old_pw" required="required" pattern="^[\w@#$^&*-]+$"/> </div>
            <label for="change_new_password"> New Password </label>
            <div> <input id="change_new_password" type="password" name="new_pw" required="required" pattern="^[\w@#$^&*-]+$"/> </div>
            <input type="submit" value="Change Password"/>
            <input type="hidden" name = "nonce" value="<?php echo csrf_getNonce($action);?>" />
        </form>
        </fieldset>
        <br>
        <form id="logout" method="POST" action="auth-process.php?action=logout"
        enctype="multipart/form-data">
            <input type="submit" value="Logout" />
        </form>
        <a href="main.php">Back to Main Page</a>
    </body>
</html>


