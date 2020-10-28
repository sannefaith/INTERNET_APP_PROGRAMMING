<?php
require_once '../USER/test.php';


//if register button is clicked

if(isset($_POST['register']))
{
    $email=$_POST['email'];
    $username=$_POST['uname'];
    $password=$_POST['password'];
    $confirmpass=$_POST['cpassword'];


    register_func($username,$email,$password,$confirmpass); 

}

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>New Account</title>
    <link rel="stylesheet" type="text/css" href="../css/regstylesheet.css">

  </head>
<body>
<header>
       
<div class="main">

<ul>
<li><img src="../images/LOGOO.jpg" class="img-rounded" width="70px" height="70px" /></li>
    <li><a href="#"><strong>Home</strong></a></li>
    <li><a href="#"><strong>Menu</strong></a></li>
    <li ><a href="#"><strong>Login</strong></a></li>
    <li class="active"><a href='#'> <strong>Register</strong></a></li>
    <li><a href='#'> <strong>contact</strong></a></li>
  
</div>
</header>

    <form class="form" action=" registration.php" method="POST">
      
        <fieldset>
            <div class="box_">
                
                <h1>Sign Up</h1>

                <div class=" text_box">
                <?php
                // full name text box
                //checking for errors in the name field
                if(isset($_GET['error']))
                {
                    if($_GET['error']=="emptfield")
                    
                    {
                        echo '<p class = "registererror"><strong>Please fill in this field</strong></p>';
                    }
                    else if($_GET['error']=="invalidname")
                    {
                        echo '<p class = "registererror"><strong>Username is too short </strong></p>';
                    }
                    
        
                }
                ?>
                   
                     <input type="text" name="fullname" placeholder="enter fullname e.g FAITH ODHIAMBO" id="fullname">

                </div>
                <div class=" text_box">


                <?php
                // Username textbox
                //checking for errors in the username field
                if(isset($_GET['error']))
                {
                    if($_GET['error']=="emptyfield")
                    
                    {
                        echo '<p class = "registererror"><strong>Please fill in this field</strong></p>';
                    }
                    else if($_GET['error']=="invalidusername")
                    {
                        echo '<p class = "registererror"><strong>Username is too short </strong></p>';
                    }
                    else if($_GET['error']=="usernametaken")
                    {
                        echo '<p class = "registererror"><strong>This username is already taken</strong></p>';  
                        
                    }
        
                }
                ?>
                   
                     <input type="text" name="uname" placeholder="create a Username" id="uname">

                </div>

                
                <div class=" text_box">


                <?php
                //Email field
                //check errors in the email field
                if(isset($_GET['error']))
                {
                    if($_GET['error']=="emptyfield")
                    
                    {
                        echo '<p class = "registererror"><strong>Please fill this field</strong></p>';
                    }
                    else if($_GET['error']=="invalidemail")
                    {
                        echo '<p class = "registererror"><strong>Please enter a valid email/strong></p>';
                    }
                 
                }
                ?>
                    
                    <input type="email" name="email" placeholder="Email address" id="email">


                </div>


                <div class=" text_box">
                <?php
                //Address field
                //check errors in the addressfield
                if(isset($_GET['error']))
                {
                    if($_GET['error']=="emptfield")
                    
                    {
                        echo '<p class = "registererror"><strong>Please fill this field</strong></p>';
                    }
                    else if($_GET['error']=="invalidaddress")
                    {
                        echo '<p class = "registererror"><strong>Please enter a valid address/strong></p>';
                    }
                
                }
                ?>
                    
                    <input type="text" name="address" placeholder="physical address" id="address">


                </div>


                <div class=" text_box">
                <?php
                //Password fields 
                if(isset($_GET['error']))
                {
                    if($_GET['error']=="emptyfield")
                    
                    {
                        echo '<p class = "registererror"><strong>Please fill this field</strong></p>';
                    }
                  
                    elseif($_GET['error']=="checkpassword")
                    {
                        echo '<p class = "registererror"><strong>Passwords did not much.Try again</strong></p>';
                    }
                }
                ?>
                     <input type="password" name="password" placeholder="Password" id="password">

                </div>
                <div class=" text_box">

                     
                     <input type="password" name="cpassword" placeholder="Confirm Password" id="c_password">

                </div>
            
                     <div class=" button">
                     <input type="submit" name="register" value="Register">

                </div>
                <div>
					<p> Alreay have an account?<a href= "./LOGIN/login.php">Login</a></p>
				</div>


            </div>
        </fieldset>

    </form>

</body>
</html> 