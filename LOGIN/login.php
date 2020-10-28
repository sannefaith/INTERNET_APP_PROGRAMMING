<?php
require_once '../USER/test.php';

if (isset($_POST['LOGIN'])) 
{
	//replace with login-func function
	//require_once("connect.php");

	$username = $_POST['uname'];
	$pasword = $_POST['password'];

	login_func($username, $pasword); 

}


?>
 <!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="../css/regstylesheet.css">
</head>
<body>
<header>
<div class="main">

<ul>
<li><img src="../images/LOGOO.jpg" class="img-rounded" width="70px" height="70px" /></li>
    <li><a href="#"><strong>Home</strong></a></li>
    <li><a href="#"><strong>Menu</strong></a></li>
    <li class="active"><a href='#'><strong>Login</strong></a></li>
    <li ><a href="../REGISTER/registration.php"> <strong>Register</strong></a></li>
	<li><a href='#'><strong>Contact</strong></a></li>
	
</ul>
</div>
</header>
    <form class="form" action="login.php" method="POST">
        <fieldset>
            <div class="box_">
                
                <h1>Login</h1>
                <div class=" text_box">
                   
                     <input type="text" name="uname" placeholder="Username" id="username">

                </div>

                <div class=" text_box">
                     
                     <input type="password" name="password" placeholder="Password" id="password">

                </div>
                
            
                     <div class="button">
                     <input type="submit" name="LOGIN" value="LOGIN">

				</div>
				<div>
					<p> Don't have an account yet?<a href= "../REGISTER/registration.php">New Account</a></p>
				</div>

            </div>
        </fieldset>

    </form>

</body>
</html>