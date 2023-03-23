<?php
include "header.php";
  //user login or not
  if(isset($_SESSION["email"])){
    header("Location: employee.php");
  }
 // Registered  message
  if(isset($_SESSION["registeredmessage"])){
    echo $_SESSION["registeredmessage"];
    unset($_SESSION["registeredmessage"]);

  }
  // Updation message
if(isset($_SESSION['updateuserpassword'])){
  echo $_SESSION['updateuserpassword'];
  unset($_SESSION['updateuserpassword']);

}
// Login Detail Wrong Message
if(isset($_SESSION['logindetailwrong'])){
  echo $_SESSION['logindetailwrong'];
  unset($_SESSION['logindetailwrong']);
}
?>


<html>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                <div class="col-md-12">
                    <h1 class="admin-heading text-center mt-3">Login</h1>
                </div>
                <div class="col-md-offset-3  ml-md-3 col-md-12 col-xl-10 m-lg-auto" >

                        
                        <!-- Form Start -->
                        <form   action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                            <div class="form-group">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="text" name="email" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password<span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group d-flex justify-content-start">
                              <input type="submit" name="login" class="btn btn-primary" value="Login" /><br>
                              <label class="register ml-3 mt-1">Don't have an account? <a href="register.php">Register,</a></label>
                              <label class="forget mt-1"><a href="forget.php">Forget Password</a></label>
                            </div>
                            
                        </form>
                        <!-- /Form  End -->
                        <?php
                          if(isset($_POST['login'])){
                            include "config.php";
                            if(empty($_POST['email']) || empty($_POST['password'])){
                              echo '<div class="alert alert-danger">All Fields must be entered.</div>';
                              die();
                            }else{
                              $email = mysqli_real_escape_string($conn, $_POST['email']);
                              $password =  mysqli_real_escape_string($conn, md5($_POST['password']));

                              $sql = "SELECT user_id,Fname, email,password, role FROM employee WHERE email = '{$email}' AND password= '{$password}'";

                              $result = mysqli_query($conn, $sql) or die("Query Failed.");

                              if(mysqli_num_rows($result) > 0){

                                while($row = mysqli_fetch_assoc($result)){
                                  $_SESSION["Fname"] = $row['Fname'];
                                  $_SESSION["email"] = $row['email'];
                                  $_SESSION["user_id"] = $row['user_id'];
                                  $_SESSION["role"] = $row['role'];
                                  $_SESSION["loginsuccess"]='<div class="alert alert-success">Login Successfully...!</div>';
                                  header("Location:employee.php");
                                }

                              }else{
                              // echo '<div class="alert alert-danger">Username and Password are not matched.</div>';
                              $_SESSION['logindetailwrong']='<div class="alert alert-danger">Email or Password are not matched.</div>';
                              header("location:index.php");
                            }
                          }
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include "footer.php"; 
        ?>
    </body>
</html>
