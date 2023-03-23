<?php 
  include "header.php";
  // session_start();
  $useridandpage = $_GET['id'];
  //   echo $useridandpage;
  $userid_page=explode('.',$useridandpage);
  $page=end($userid_page);
  $userid=$userid_page[0];
  if(!$userid){
    header("Location: http://localhost/okcl/okcl_crud/employee.php");
  }

  if(isset($_POST['submit'])){
    include "config.php";

    $fname =mysqli_real_escape_string($conn,$_POST['fname']);
    $mname =mysqli_real_escape_string($conn,$_POST['mname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $dob =mysqli_real_escape_string($conn,$_POST['dob']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $role = mysqli_real_escape_string($conn,$_POST['role']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,md5($_POST['password']));
    $city = mysqli_real_escape_string($conn,$_POST['address']);
    $pin = mysqli_real_escape_string($conn,$_POST['pin']);
    date_default_timezone_set("asia/kolkata");
    $d=date('d/m/Y h:i:sa');

    $sql = "UPDATE employee SET fname = '{$fname}', mname = '{$mname}', lname = '{$lname}', dob='{$dob}' ,gender = '{$gender}', role = '{$role}',phone='{$phone}',email='{$email}',password='{$password}',city='{$city}',pin='{$pin}' WHERE user_id = {$userid}";

    if(mysqli_query($conn,$sql)){
      $_SESSION['updateusermessage']='<div class="alert alert-success">User Detail Update Successfully...!</div>';
      header("Location: employee.php?page=$page");
    }
  }
?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading text-center">Modify User Details</h1>
      </div>
      <div class="col-md-offset-3  ml-md-3 col-md-12 col-xl-10 m-lg-auto">
        <?php
          
          include "config.php";
          $user_id = $userid;
          $sql = "SELECT * FROM employee WHERE user_id = {$user_id}";
          $result = mysqli_query($conn, $sql) or die("Query Failed.");
          
          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              
              ?>
              <!-- Form Start -->
              <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" name="fname" value="<?php echo $row['Fname'];  ?>" class="form-control" placeholder="First Name" required>
                </div>
                <div class="form-group">
                  <label>Middle Name</label>
                  <input type="text" name="mname" value="<?php echo $row['Mname'];  ?>" class="form-control" placeholder="Middle Name">
                </div>
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" name="lname" value="<?php echo $row['Lname'];  ?>" class="form-control" placeholder="Last Name" required>
                </div>
                <div class="form-group">
                  <label>D.O.B.</label>
                  <input type="date" name="dob" value="<?php echo $row['dob'];  ?>" class="form-control"  required>
                </div>
                <div class="form-group">
                  <label>Gender</label><br>
                  <input type="radio" name="gender" value="male"  required><label >Male</label>
                  <input type="radio" name="gender"value="female"   required><label>Female</label>
                </div>
                <div class="form-group">
                  <label>User Role</label>
                  <select class="form-control" name="role" value="<?php echo $row['role'];  ?>">
                      
                    <?php
                      if($_SESSION['role'] =="admin"){
                        if($user_role=='admin'){
                          echo "<option value='admin' selected>Admin</option>
                          <option value='manager'>Manager</option>
                          <option value='employee'>Employee</option>";
                        }
                        else if($user_role=='manager'){
                          echo "<option value='admin' >Admin</option>
                          <option value='manager' selected>Manager</option>
                          <option value='employee'>Employee</option>";
                        }
                        else{
                          echo "<option value='admin' >Admin</option>
                          <option value='manager' >Manager</option>
                          <option value='employee' selected>Employee</option>";
                        }
                              
                      }
                      else{
                        if($user_role=='manager'){
                          echo "<option value='manager' selected>Manager</option>
                          <option value='employee'>Employee</option>";
                        }
                        else{
                          echo "<option value='manager' >Manager</option>
                          <option value='employee' selected>Employee</option>";
                        }
                      }
                          
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" value="<?php echo $row['phone'];  ?>" class="form-control" placeholder="Phone" min="10" max="10" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" value="<?php echo $row['email'];  ?>" class="form-control" placeholder="Email" required>
                </div>
                  
                <div class="form-group">
                  <label>City</label>
                  <input type="text" name="address" value="<?php echo $row['city'];  ?>" class="form-control" placeholder="Address" required>
                </div>
                <div class="form-group">
                  <label>Pin No.</label>
                  <input type="text" name="pin" value="<?php echo $row['pin'];  ?>" class="form-control" placeholder="pin" min=6 required>
                </div>
                <br>
                <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
              </form>
              <!-- /Form -->
              <?php
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