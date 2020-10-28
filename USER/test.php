<?php


//connecting to the database
function connect_func()
{
	$dbserver="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="iap_app";
	$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

	if ($conn->connect_error) {	
		die("Connection Failed: ". $conn->connect_error);
	}
	return $conn;
}



//Function used to login 
function login_func($username, $pasword) 
{
	
	if(empty($username) || empty($pasword))
	{
		header("Location: login.php?error=emptyfields");
		exit();
	}
	else
	{
        $conn = connect_func();
        if($conn)
        {

        
		$sql = "SELECT * FROM user WHERE username=?;";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) 
		{
			header("Location: login.php?error=sqlerror");
			exit();
		}
		else
		{
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if ($row = mysqli_fetch_assoc($result)) 
			{
				$hashedpass = $row['password'];
				if (password_verify($pasword,$hashedpass))
				{
                    session_start();
					$_SESSION['username'] = $row['username'];
					$_SESSION['userid'] = $row['userid'];
					$logged_in == true;

					$utype = $row['user_type'];
					if($utype == "admin")
					{
						if(isset($_SESSION['username'])){
							header("Location: manageorders.php");
						}
						
					exit();
					}
					elseif($utype == "user")
					{	
						if(isset($_SESSION['username'])){
							header("Location: profile.php");
						}
						exit();
					}else{
						header("Location: index.php?invalid_p");
					}
					$time = time();
				}
				else
				{
			
                    header("Location: login.php?error=wrongpassword");
					exit();
					
				}
			}
			else
			{
				header("Location: login.php?error=no_usermatch");
				exit();
			}
		}
        }
    }
    
}



//Registration function
function register_func($username,  $email, $password,$confirmpass)
 {
    //error handlers

    //if any field is empty
	if(empty($username) || empty($email) || empty($password))
	{
	header("Location: registration.php?error=emptyfield&uname=".$username."&email".$email);
	exit();

    }
    //check for invalid fileds
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)&& !preg_match('/^[a-z\d_]{5,20}$/i',$username))
		{
			header("Location: registration.php?error=invalidemailandusername");
			exit();
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			header("Location: registration.php?error=invalidemail&uname=".$username);
			exit();
		}
		else if(!preg_match('/^[a-z\d_]{5,20}$/i',$username))
		{
			header("Location: registration.php?error=invalidusername&email=".$email);
			exit();
        }
        //check if passwords does not match
		else if ($password !== $confirmpass)
		{
			header("Location: registration.php?error=checkpassword&uname=".$username."&email".$email);
			exit();
		}
    else
    
	{
        //enter registration functio here if all else fails
       $conn=connect_func();
        if ( $conn)
        {
        //check if username exists 
		$sql1="SELECT username FROM user WHERE username =? ";
		
		$stmt = mysqli_stmt_init($conn);
        
		if(!mysqli_stmt_prepare($stmt,$sql1))
		{
			header("Location: registration.php?error=sqlerror");
			exit();
		}	

		else
		{
			mysqli_stmt_bind_param($stmt,"s",$username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultcheck = mysqli_stmt_num_rows($stmt);

			if ($resultcheck)
			{
			header("Location: registration.php?error=usernametaken&email=".$email);
			exit();
			}    
        }
     }  
}
	mysqli_stmt_close($stmt);
		mysqli_stmt_close($conn);
    $conn = connect_func();
	$sql_insert="INSERT INTO user (username,email,password)VALUES(?,?,?)";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt,$sql_insert))
	{
	header("Location: registration.php?error=sqlerror");
	exit();
	}	
	else
	{
		$hashedpass = password_hash($password, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt,"sss", $username, $email, $hashedpass);
		mysqli_stmt_execute($stmt);	
		header("Location:../LOGIN/login.php?registration=success");
		exit();
	}
}


//function to update user or admin account details
function update_func($username, $email, $usertype,$id) 
{
    $admin= "admin";
    $user = "user";
    $conn = connect_func();

 //error handlers

    //if any field is empty
	if(empty($username) || empty($email) || empty($usertype))
	{
	header("Location: viewusers.php?error=emptyfield&uname=");
	exit();

    }
    //check for invalid fileds
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)&& !preg_match('/^[a-z\d_]{5,20}$/i',$username))
		{
			header("Location: viewusers.php?error=invalidemailandusername");
			exit();
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			header("Location: viewusers.php?error=invalidemail&uname=".$username);
			exit();
		}
		else if(!preg_match('/^[a-z\d_]{5,20}$/i',$username))
		{
			header("Location: viewusers.php?error=invalidusername&email=".$email);
			exit();
        }
        //check if passwords does not match
       

		/*else if ($usertype !== $admin || $usertype !== $user)
		{
			header("Location: viewusers.php?error=checkusertype&uname=".$username."&email".$email);
			exit();
		}*/
    else
    
	{
        //enter registration function here if all else fails
       $conn=connect_func();
        if ( $conn)
        {
        //check if username exists 
		$sql1="SELECT username FROM user WHERE username =? ";
		
		$stmt = mysqli_stmt_init($conn);
        
		if(!mysqli_stmt_prepare($stmt,$sql1))
		{
			header("Location: viewusers.php?error=sqlerror");
			exit();
		}	

		else
		{
			mysqli_stmt_bind_param($stmt,"s",$username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultcheck = mysqli_stmt_num_rows($stmt);

			if ($resultcheck > 1)
			{
			header("Location: viewusers.php?error=usernametaken&email=".$email);
			exit();
            }else
            {
            $conn->query("UPDATE user SET username = '$username', email= '$email', user_type= '$usertype' WHERE userid =$id");
            }
        }

        }  

         
	
	}
	mysqli_stmt_close($stmt);
	

	}
	
/*

	function update_func2($foodname,$quantity,$price,$img_url,$id)
	{
	
		$conn = connect_func();
	

			if ( $conn)
			{
			//check if username exists 
			$sql1="SELECT foodname FROM food WHERE foodname =? ";
			
			$stmt = mysqli_stmt_init($conn);
			
			if(!mysqli_stmt_prepare($stmt,$sql1))
			{
				header("Location: managemenu.php?error=sqlerror");
				exit();
			}	
	
			else
			{
				mysqli_stmt_bind_param($stmt,"s",$foodname);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultcheck = mysqli_stmt_num_rows($stmt);
	
				if ($resultcheck > 1)
				{
				header("Location: managemenu.php?error=foodname_taken");
				exit();
				}else
				{
				$conn->query("UPDATE food SET foodname = '$foodname',foodprice= '$price', foodquantity= '$quantity',foodimage= '$img_url' WHERE foodid =$id");
				}
			}
	
			 
	
			 
		
		
		mysqli_stmt_close($stmt);
		
	
			}
	

/*
		function update_func3($foodname,$quantity,$price,$id)
		{
		
			$conn = connect_func();
		
		 //error handlers
		
			//if any field is empty
			if(empty($foodname) || empty($price) || empty($quantity) )
			{
			header("Location: order.php?error=emptyfield&uname=");
			exit();
		
			}
			
			else
			
			{
				//enter registration function here if all else fails
			   $conn=connect_func();
				if ( $conn)
				{
				//check if username exists 
				$sql1="SELECT foodname FROM food WHERE foodname =? ";
				
				$stmt = mysqli_stmt_init($conn);
				
				if(!mysqli_stmt_prepare($stmt,$sql1))
				{
					header("Location: order.php?error=sqlerror");
					exit();
				}	
		
				else
				{
					mysqli_stmt_bind_param($stmt,"s",$foodname);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					$resultcheck = mysqli_stmt_num_rows($stmt);
		
					if ($resultcheck < 1)
					{
					header("Location: order.php?error=foodname_doesn't_exist");
					exit();
					}else
					{
					$conn->query("UPDATE order_tbl SET  quantity= '$quantity' WHERE orderid =$id");
					}
				}
		
				}  
		
				 
			
			}
			mysqli_stmt_close($stmt);
			
		}
			}*/
			function change_password($username){
				
			}
			function update_func4($username,$email, $userbio,$id,$image) 
			{
				
				$conn = connect_func();
			
			 //error handlers
			
				//if any field is empty
				if(empty($username) || empty($email) || empty($userbio))
				{
				header("Location:profile.php?error=emptyfield&uname=");
				exit();
			
				}
				//check for invalid fileds
					else if (!filter_var($email, FILTER_VALIDATE_EMAIL)&& !preg_match('/^[a-z\d_]{5,20}$/i',$username))
					{
						header("Location: profile.php?error=invalidemailandusername");
						exit();
					}
					else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
					{
						header("Location: profile.php?error=invalidemail&uname=".$username);
						exit();
					}
					else if(!preg_match('/^[a-z\d_]{5,20}$/i',$username))
					{
						header("Location: profile.php?error=invalidusername&email=".$email);
						exit();
					}
					//check if passwords does not match
				   
			
					/*else if ($usertype !== $admin || $usertype !== $user)
					{
						header("Location: viewusers.php?error=checkusertype&uname=".$username."&email".$email);
						exit();
					}*/
				else
				
				{
					//enter registration function here if all else fails
				   $conn=connect_func();
					if ( $conn)
					{
					//check if username exists 
					$sql1="SELECT username FROM user WHERE username =? ";
					
					$stmt = mysqli_stmt_init($conn);
					
					if(!mysqli_stmt_prepare($stmt,$sql1))
					{
						header("Location:profile.php?error=sqlerror");
						exit();
					}	
			
					else
					{
						mysqli_stmt_bind_param($stmt,"s",$username);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_store_result($stmt);
						$resultcheck = mysqli_stmt_num_rows($stmt);
			
						if ($resultcheck > 1)
						{
						header("Location: profile.php?error=usernametaken&email=".$email);
						exit();
						}else
						{
						
								$conn->query("UPDATE user SET username = '$username', email= '$email', bio= '$userbio', userpic = '../images/$image' WHERE userid =$id");
							
						}
					}
			
					}  
			
					 
				
				}
				mysqli_stmt_close($stmt);
				
			
				}



?>