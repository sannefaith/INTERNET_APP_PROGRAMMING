<?php
session_start();

require_once("../USER/test.php");
$id= $_SESSION['userid'];
$username = '';
$email = '';
$usertype = '';
$userbio='';
$conn = connect_func();

$update = true;
    $result =$conn->query("SELECT * FROM user WHERE userid = $id");

    if($result)
    {
        $row = $result->fetch_array();
        $username =$row['username']; 
        $email =$row['email']; 
		$userbio =$row['bio']; 
	
    }


if(isset($_POST['update']))
{
    $id=$_POST['uid'];
    $username=$_POST['uname'];
    $email=$_POST['email'];
	$userbio=$_POST['userbio'];
	$image = $_POST['image'];
  
    update_func4($username,$email,$userbio,$id,$image);
    
   
    $_SESSION['message']= "Record has been updated";
    $_SESSION['msg_type']= "success";
    header("loctaion: upload_image.php");
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

<ul >
<li><img src="LOGOO.jpg" class="img-rounded" width="70px" height="70px" /></li>
    <li class="active"><a href="upload_image.php"><strong>My profile</strong></a></li>
    <li ><a href='manageorders.php'><strong>Manage Orders</strong></a></li>
    <li ><a href="viewusers.php"> <strong>Manage users</strong></a></li>
    <li><a href="managemenu.php"><strong>Manage Menu</strong></a></li>
     <li><a href="logout.php"><strong>Log out</strong></a></li>
     <li><a href='#'><strong>-</strong></a></li>
     <li><a href='#'><strong>-</strong></a></li>
     <li><a href='#'><strong>-</strong></a></li>
     <li><a href='#'><strong>-</strong></a></li>
     <li><a href='#'><strong>-</strong></a></li>
     
    <li class="text-dark">Hello <?php echo $_SESSION['username']?></li>
</ul>

</div>

	
<div class="container">  
<h1 class = "text text-dark"><?php echo $_SESSION['username']?>'s PROFILE</h1>  
<div class="row">  
<div class = "col-md-4">
<form action="upload_image.php" method ="POST" enctype="mulitipart/form-data">
                        <h4 class="text-dark">MY DETAILS</h4>

                        <input type="hidden" name ="uid" value ="<?php echo  $id;?>"> 

                        <div class= "form-group">
                        <label class="text-dark" >MY USERNAME</label>
                        <input type="text" name ="uname" class ="form-control" value ="<?php echo  $username;?>" >
                        </div>
                    
                        <div class= "form-group">
                        <label class="text-dark" >MY EMAIL</label>
                        <input type="email" name ="email" class ="form-control" value ="<?php echo  $email;?>">
                        </div>

                        <div class= "form-group">
                        <label class="text-dark" >MY BIO</label>
                        <input type="text" name ="userbio"
                        class ="form-control" value ="<?php echo  $userbio;?>">
                        </div>
                    
                        <div class= "form-group">
						<label class="text-dark" >MY PROFILE PICTURE</label>
                        <input type="file" name ="image"
                        class ="custom_file text-dark" >
                        </div>

                        <div class= "form-group">
                        <?php
                        if($update ==true):
                        ?>
                            <button type="submit" name ="update" class ="btn btn-info">update</button>
                        <?php else:?>
                            <button type="submit" name ="save" class ="btn btn-primary">Save</button>
                        
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
		<h5 class="text-dark" >This is me !</h5> 
			<img src="<?php echo $row['userpic']; ?>" class="img-rounded" width="350px" height="350px" /><hr>  
			<h5 class="text-dark" ><?php echo $bio; ?></h5>  
            <p class="page-header" >  
            <span>  
            <a class="btn btn-info" href="upload_image.php?edit=<?php echo $row['userid']; ?>">edit</a>   
            
            </span>  
            </p>  
        </div>         
        <?php  
    }  
 

	 
?>  

</div>  
</div> 
</body> 
</html>