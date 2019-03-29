<?php session_start();  ?>
<?php  require_once('inc/connection.php');  ?>
<?php  require_once('inc/function.php');  ?>
<?php 
        
        if(!isset($_SESSION['user_id'])){
          header('location:index.php');
          }



      $errors=array();
      $first_name ='';
      $last_name ='';
      $email ='';
      $Password ='';

      if(isset($_POST['submit'])){ 
               $first_name =$_POST['first_name'];
               $last_name =$_POST['last_name'];
               $email =$_POST['email'];
               $Password =$_POST['Password'];



         //cheking reqired fields 

            $req_fields=array('first_name','last_name','email','Password');

           $errors=array_merge($errors,check_req_fields($req_fields));

              //cheking max length

            $max_len_fields=array('first_name' =>100,'last_name' =>100,'email' =>100,'Password' =>100);

             $errors=array_merge($errors,check_max_len($max_len_fields));

        //cheking if email address already exitss;

        $email =mysqli_real_escape_string($connection,$_POST['email']);
        $query ="SELECT * FROM users WHERE emai='{$email}' LIMIT 1";

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
          $Password=mysqli_real_escape_string($connection,$_POST['Password']);
           //email address is already sanitized
            $hashed_password=$Password;

          $query ="INSERT INTO users(";
          $query .="first_name,last_name,emai,Password,is_deleted";
          $query .=") VALUES (";
          $query .="'{$first_name}', '{$last_name}', '{$email}','{$hashed_password}',0 ";
          $query .=")";

         $result=mysqli_query($connection,$query);

         if($result){
          //query successsfull.... redirecting to users page
             header('location:users.php?user_added=true');

         }else{
          $errors[]='Failed to add the new record.';
         }


         }



      }   

         ?>

<!DOCTYPE html>
<html>
<head>
	<title>Add new student</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<header>
		<div class="appname">Student Managment System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>!<a href="logout.php">Log out</a></div>
	</header>
    <main>
		<h1>Add New Student<span><a href="users.php"><br>Back to user List</br></a></span></h1>

       <?php   
               if(!empty($errors)){
                echo '<div class="errmsg">';
                echo '<b>There were error(s) on your from.</b><br>';
                foreach ($errors as $error) {
                    echo $error . '<br>';
                }
                   echo '</div>';

               }



       ?>


        <form action="add-user.php" method="post" class="userform">
            
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
               <label for="">New Password:</label>
               <input type="Password" name="Password">
           </p>

           <p>
               <label for="">&nbsp;</label>
               <button type="submit" name="submit">Save</button>
           </p>
        </form>
    	
    </main>
</body>
</html>
