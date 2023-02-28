<?php
include "config.php";
session_start();
$useridandpage = $_GET['id'];
$userid_page=explode('.',$useridandpage);
$page=end($userid_page);
$user_id=$userid_page[0];
if(!$userid){
  header("Location: http://localhost/okcl/okcl_crud/employee.php");
}
$sql = "DELETE FROM employee WHERE user_id = {$user_id}";

if(mysqli_query($conn, $sql)){
  $_SESSION['deleteuser']='<div class="alert alert-success">Delete User Successfully...!</div>';
  header("Location: http://localhost/okcl/okcl_crud/employee.php?page=$page");
}
else{
  $_SESSION['deleteuser']='<div class="alert alert-danger">Can\'t Delete the User Record...!</div>';
  header("Location: http://localhost/okcl/okcl_crud/employee.php?page=$page");
   
}

mysqli_close($conn);

?>
