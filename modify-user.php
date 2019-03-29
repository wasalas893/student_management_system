<?php session_start();  ?>
<?php  require_once('inc/connection.php');  ?>
<?php  require_once('inc/function.php');  ?>
<?php 
        
        if(!isset($_SESSION['user_id'])){
          header('location:index.php');
          }



      $errors=array();
      $user_id='';
      $first_name ='';
      $last_name ='';
      $Password ='';
      $email ='';
      


      if(isset($_GET['user_id'])){
        //getting the user information
        $user_id=mysqli_real_escape_string($connection, $_GET['user_id']);

        $query ="SELECT * FROM users WHERE id={$user_id} LIMIT 1";

         $result_set=mysqli_query($connection,$query);

         if($result_set){
          if(mysqli_num_rows($result_set)==1){
            //user found
            $result=mysqli_fetch_assoc($result_set);
                 
                  $first_name =$result['first_name'];
                  $last_name =$result['last_name'];
                  $email =$result['emai'];



          }else{
                //user notfound
            header('location:users.php?err=user_not_found');

          }

         }else{
          //query unsuccessful
          header('location:users.php?err=query_failed');
         }
      }

      if(isset($_POST['submit'])){ 
              $user_id=$_POST['user_id'];
               $first_name =$_POST['first_name'];
               $last_name =$_POST['last_name'];
               $email =$_POST['email'];
               



         //cheking reqired fields 

            $req_fields=array('user_id','first_name','last_name','email');

           $errors=array_merge($errors,check_req_fields($req_fields));

              //cheking max length

            $max_len_fields=array('first_name' =>100,'last_name' =>100,'email' =>100);

             $errors=array_merge($errors,check_max_len($max_len_fields));

        //cheking if email address already exitss;

        $email =mysqli_real_escape_string($connection,$_POST['email']);
        $query ="SELECT * FROM users WHERE emai='{$email}' AND id !={$user_id} LIMIT 1";

        $result_set=mysqli_query($connection,$query);

         if($result_set){
          if(mysqli_num_rows($result_set)==1){
            $errors[]='Email address already exists';
          }
         }


         if(empty($errors)){
          // no erroes found..... adding new record
          $first_name=mysqli_real_escape_string($connection,$_POST['first_name']);
          $last_name=mysqli_real_escape_string($connection,$_POST['last_name']);
          
           //email address is already sanitized
         $hashed_password=$Password;
 
          $query="UPDATE users SET";
          $query .="first_name='{$first_name}', ";
             $query .="last_name='{$last_name}', ";
                $query .="email='{$email}' ";
                   $query .="WHERE id={$user_id} LIMIT 1";

         $result=mysqli_query($connection,$query);

         if($result){
          //query successsfull.... redirecting to users page
             header('location:users.php?user_modifyed=true');

         }else{
          $errors[]='Failed to modify the record the new record.';
         }


         }



      }   

         ?>

<!DOCTYPE html>
<html>
<head>
	<title>View/Modify user</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<header>
		<div class="appname">Student Managment System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>!<a href="logout.php">Log out</a></div>
	</header>
    <main>
		<h1>Add New Modify student<span><a href="users.php"><br>Back to user List</br></a></span></h1>

       <?php   
               if(!empty($errors)){
                  display_errors($errors);
               }



       ?>


        <form action="modify-user.php" method="post" class="userform">
           <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> 
           <p>
               <label for="">First Name:</label>
               <input type="text" name="first_name" <?php echo 'value="' . $first_name . '"'; ?>>
           </p>

           <p>
               <label for="">Last Name:</label>
               <input type="text" name="last_name" <?php echo 'value="' . $last_name . '"'; ?>>
           </p>

           <p>
               <label for="">Email Address:</label>
               <input type="text" name="email" <?php echo 'value="' . $email . '"'; ?> >
           </p>

           <p>
               <label for="">Password:</label>
              <span></span> | <a href="change-password.php?user_id=<?php echo $user_id; ?> ">Change Password</a>
           </p>

           <p>
               <label for="">&nbsp;</label>
               <button type="submit" name="submit">Save</button>
           </p>
        </form>
    	
    </main>
</body>
</html>
