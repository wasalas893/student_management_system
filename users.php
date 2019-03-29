<!DOCTYPE html>
<?php session_start();  ?>
<?php  require_once('inc/connection.php');  ?>
<?php  require_once('inc/function.php');  ?>
<?php 
        if(!isset($_SESSION['user_id'])){
        	header('location:index.php');
          }

       $user_list='';

        $query="SELECT * FROM users WHERE is_deleted=0 ORDER BY first_name";
        $users=mysqli_query($connection,$query);

           verify_query($users);

        	while ($user=mysqli_fetch_assoc($users)) {
        		$user_list .="<tr>";
        		$user_list .="<td>{$user['first_name']}</td>";
                $user_list .="<td>{$user['last_name']}</td>";
                 $user_list .="<td>{$user['emai']}</td>";
                 $user_list .="<td><a href=\"modify-user.php?user_id={$user['id']}\">Edite</a></td>";
                  $user_list .="<td><a href=\"delete-user.php?user_id={$user['id']}\">Delete</a></td>";
                 
                 
        		$user_list .="<tr>";
                 
        		
        	}

 ?>
<html>
<head>
	<title>users</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<header>
		<div class="appname">Student Managment System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>!<a href="logout.php">Log out</a></div>
	</header>
    <main>
    	<h1>Student List<span><a href="add-user.php"><br>Add New Student</br></a></span></h1>
    	<table class="masterlist">
    		<tr>
    			<th>First Name</th>
    			<th>Last Name</th>
    			<th>Email</th>
    			<th>Edite</th>
               
    			<th>Deleted</th>
    		</tr>

    		<?php echo $user_list; ?>

    	</table>
    </main>
</body>
</html>