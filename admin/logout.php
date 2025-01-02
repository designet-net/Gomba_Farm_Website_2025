<?php 
// Begin the session
session_start();

// Unset all of the session variables.
session_unset();

// Destroy the session.
session_destroy();
?>
<?php include("header.php");?>

<?php include("footer.php");?>