<?php
session_start();
require_once("../USER/test.php");


$id= $_SESSION['userid'];
$username = '';
$email = '';
$usertype = '';
$userbio='';
$image ='';
$conn = connect_func();

 
$result =$conn->query("SELECT * FROM user WHERE userid = $id");

    if($result)
    {
        $row = $result->fetch_array();
        $username =$row['username']; 
        $email =$row['email']; 
        $userbio =$row['bio'];
        $image =$row['userpic'];  
	
    }

 
    if(isset($_GET['edit']))
    {
        $update = true;
    }else 
    {
        $update = false;
    }

if(isset($_POST['update']))
{
    $id= $_SESSION['userid'];
    $username=$_POST['uname'];
    $email=$_POST['email'];
    $userbio=$_POST['userbio'];
    
    if(isset($_GET['changepic']))
    {
    $image= $_POST['image'];
    }
    $image = NULL;

  
    update_func4($username,$email,$userbio,$id,$image);
    
   
    $_SESSION['message']= "Record has been updated";
    $_SESSION['msg_type']= "success";
    header("loctaion: profile.php");
}



$userid = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html>
<head>
        <title>MY PROFILE</title>
             <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
             <link rel="stylesheet" type="text/css" href="../css/regstylesheet.css">
             <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
             <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="main">

    <ul>
    <li><img src="../images/LOGOO.jpg" class="img-rounded" width="70px" height="70px" /></li>
    <li  class="active"><a href="profile.php"><strong>My profile</strong></a></li>
    <li ><a href="#"><strong>Order</strong></a></li>

    <li><a href="#"> <strong>Log out</strong></a></li>
    
     
    <li class="text-dark">Hello <?php echo $_SESSION['username'];?></li>
</ul>

</div>

	
<div class="container">  
<h1 class = "text text-dark"><?php echo $_SESSION['username']?>'s PROFILE</h1>  
<div class="row">  
<div class = "col-md-4">
<form action="profile.php" method ="POST" enctype="mulitipart/form-data">
                        <h4 class="text-dark">MY DETAILS</h4>

                        <input type="hidden" name ="uid" value ="<?php echo  $id;?>"> 

                        <div class= "form-group">
                        <label class="text-dark" >MY USERNAME</label>
                        <input type="text" name ="uname" class ="form-control" value ="<?php echo  $username;?>" >
                        </div>
                    
                        <div class= "form-group">
                        <label class="text-dark" >MY NAME</label>
                        <input type="text" name ="fullname" class ="form-control" value ="<?php echo  $fullname;?>">
                        </div>

                        <div class= "form-group">
                        <label class="text-dark" >MY EMAIL</label>
                        <input type="email" name ="email" class ="form-control" value ="<?php echo  $email;?>">
                        </div>

                        <div class= "form-group">
                        <label class="text-dark" >MY ADDRESS</label>
                        <input type="email" name ="email" class ="form-control" value ="<?php echo  $email;?>">
                        </div>

                        <div class= "form-group">
                        <label class="text-dark" >MY BIO</label>
                        <input type="text" name ="userbio"
                        class ="form-control" value ="<?php echo  $userbio;?>">
                        </div>

                    <?php if(isset($_GET['edit'])):?>
                        <div class= "form-group">
                        <a class="btn btn-info" href="profile.php?changepic">Change profile picture</a>  

                    <?php if(isset($_GET['edit'])):
                    if ($_GET['edit'] == "changepic"):?>
						<label class="text-dark" >MY PROFILE PICTURE</label>
                        <input type="file" name ="image"
                        class ="custom_file text-dark" >
                        </div> 

                    <?php endif ;?>
                    <?php endif ;?>
                    <?php endif ;?>
                        <div class= "form-group">
                        <?php
                    if($update ==true):
                        ?>
                        <button type="submit" name ="update" class ="btn btn-info">update</button>
                        
                    <?php endif ;?>
                        </div>
                    </form>
						</div>

						<div class ="col-md-2">
						</div>
<div class ="col-md-4">
<?php  

$conn= connect_func();
$result= $conn->query("SELECT * FROM user WHERE userid = $userid");
 


while($row =$result->fetch_assoc())
    {  
		$username =$row['username'];
		$bio = $row['bio'];
        ?>  
        <div class="col-xs-3">  
		<?php require_once '../USER/test.php';
                    if (isset($_SESSION['message'])):
                 ?>

                 <div class="alert alert-<?=$_SESSION['msg_type']?>">
                 <?php
                 echo $_SESSION['message'];
                 unset ($_SESSION['message']);
                 ?>
                 </div>
                 <?php endif ?>
                 <p class="page-header" > 
            <span>  
            
            <a class="btn btn-info" href="profile.php?edit">edit profile</a>   
            
                    </span>  
                    
            </p>  
            <h5 class="text-dark" ><?php echo $bio; ?></h5>  
            
			<img src="<?php echo $row['userpic']; ?>" class="img-rounded" width="350px" height="350px" /><hr>  
			
        
        </div>         
        <?php  
    }  
 

	 
?>  

</div>  
</div> 
</body> 
</html>