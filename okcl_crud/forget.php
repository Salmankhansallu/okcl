<?php
  include 'header.php';
  include 'config.php';
  // session_start();
  // Wrongusername
  if(isset($_SESSION["wrongemail"])){
  echo $_SESSION["wrongemail"];
  unset($_SESSION["wrongemail"]);

  }
 
?>

<body>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading text-center">Forget Password</h1>
              </div>
              <div class="col-md-offset-3  ml-md-3 col-md-12 col-xl-10 m-lg-auto" >
                          <!-- Form Start -->
                  <form id="forgetpassword" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                      <div class="form-group">
                          <label>Email<span class="text-danger">*</span></label>
                          <input type="text" name="email" class="form-control" placeholder="" required>

                      </div>
                      <div class="form-group">
                          <label>D.O.B.<span class="text-danger">*</span></label>
                          <input type="date" name="dob" class="form-control" placeholder="" required>

                      </div>
                      <br>
                      <input type="submit" name="login" class="btn btn-primary" value="Submit" />
                      <label>  <a href="index.php" style="margin-left:50px;">Back</a></label>
                  </form>
                          <!-- Form End-->
              </div>
          </div>
      </div>
  </div>


  <?php

    if(isset($_POST['login'])){  
      $email=$_POST['email'];
      $dob=$_POST['dob'];
      $sql="SELECT email,dob FROM employee WHERE email='{$email}' AND dob='{$dob}'";
      $result=mysqli_query($conn,$sql) or die("Query is Failed.");


      if(mysqli_num_rows($result) > 0){

        while($row=mysqli_fetch_assoc($result)) {
          $_SESSION['emailupdate']=$row['email'];
          header("Location: update-password.php");
        }
      }

      else{
        $_SESSION['wrongemail']= '<div class="alert alert-danger">Email or D.O.B. are Incorrect...!.</div>';
        header("Location: forget.php");
      }
    }


  ?>
  <?php
   include "footer.php"; 
  ?>
</body>

