<?php include("conn.php"); ?>
<?php if(isset($_POST['login'])): ?>
<?php 
	//1. Testing username and password
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$select = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
	$result = mysqli_query($connection, $select);
	while($row = mysqli_fetch_array($result)){		
		$db_username = $row['username'];
		$db_password = $row['password'];
	}
	if($username == $db_username && $password == $db_password){		
		session_start();
   		$_SESSION['username'] = $username;
		header('Location: gr_admin.php');		
	}
	else
		header("Location: gr_admin_login.php");
	
 ?>
<?php endif; ?>