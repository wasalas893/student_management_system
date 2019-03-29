<?php session_start();  ?>
<?php  require_once('inc/connection.php');  ?>
<?php  require_once('inc/function.php');  ?>
<?php
    
    if(isset($_POST['sumit'])){
    	$errors=array();

    	if(!isset($_POST['emai']) || strlen(trim($_POST['emai'])) <1){
               $errors[]='Username is Missing/Invalid';

    	}
    	if(!isset($_POST['Password']) || strlen(trim($_POST['Password'])) <1){
               $errors[]='Password is Missing/Invalid';

    	}
    	  if(empty($errors)){
    	  	$emai=mysqli_real_escape_string($connection,$_POST['emai']);
    	  	
    	  	$Password=mysqli_real_escape_string($connection,$_POST['Password']);
    	  	$hashed_password=$Password;


           $query="SELECT * FROM users 
           WHERE emai='{$emai}'
            AND Password='{$hashed_password}'
            	LIMIT 1";

          $result_set=mysqli_query($connection,$query); 
          
          if($result_set){
          	if(mysqli_num_rows($result_set)==1){
              $user=mysqli_fetch_assoc($result_set);
              $_SESSION['user_id']=$user['id'];
              $_SESSION['first_name']=$user['first_name'];
			  
			  
			 
 
                header('location:users.php');
          	}else{
          		$errors[]='Invalid Username/password';
          	}
          }else{
          	$errors[]='Database query failed';
          }  	


    	  }
    }



  ?>

<!DOCTYPE html>
<html>
<head>
	<title>log in-usermanagment system</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

	 <h2>Student Managment System</h2>

       <div class='login'>
       	 <form action="index.php" method="post">
       	 	
       	 		<h1>Login Here</h1>
       	 		<?php   
                        if(isset($errors)&&!empty($errors)){ 
                        	echo '<p class="error">Invalid Username/Password</p>';
                        }
       	 		   ?>
       	 		
       	 		<p>
       	 			<label for="">Username:</label>
       	 			<input type="text" name="emai" id="" placeholder="Emai Address">
       	 		</p>
       	 		<p>
       	 			<label for="">Password:</label>
       	 			<input type="Password" name="Password" id="" placeholder="Password">
       	 		</p>
       	 		<p>
       	 			<button type="sumit" name="sumit">log In</button>
       	 		</p>
       	 	
       	 </form>

       </div>


</body>
</html>
<?php mysqli_close($connection);	  ?>