<?php
include "header.php";
$admin_and_manager=false;

if(isset($_SESSION['useralreadyregisteredmessage'])){
    echo $_SESSION['useralreadyregisteredmessage'];
    unset($_SESSION['useralreadyregisteredmessage']);
}

if(isset($_POST['save'])){
    $adduser_by_admin_and_manager=$_GET['adduser_by_admin_and_manager'];
    if($adduser_by_admin_and_manager==true){
      $_SESSION['adduser_by_admin_and_manager']='<div class="alert alert-success">Registered Sucessfully...!.</div>';
    }
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
    // echo $fname,",",$mname,",",$lname,",",$dob,",",$gender,",",$role,",",$phone,",",$email,",",$password,",",$city,",",$pin,",",$d;
    
    $sql = "SELECT email FROM employee WHERE email = '{$email}'";
  
    $result = mysqli_query($conn, $sql) or die("Query Failed.");
  
    if(mysqli_num_rows($result) > 0){
      $_SESSION['useralreadyregisteredmessage']='<div class="alert alert-danger">Email already Exists.</div>';
      header("Location: register.php");
    }else{
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $_SESSION['useralreadyregisteredmessage']='<div class="alert alert-danger">Incorrect Email..!</div>';
            header("Location: register.php");
        }
        else if(strlen($pin)!=6 || !is_numeric($pin)) {
            $_SESSION['useralreadyregisteredmessage']='<div class="alert alert-danger">Pin must be six digit!</div>';
            header("Location: register.php");
          }
        else{
            $sql1 = "INSERT INTO employee (fname,mname,lname,dob,gender,role,phone,email,password,city,pin,datetime)
            VALUES ('{$fname}','{$mname}','{$lname}','{$dob}','{$gender}','{$role}','{$phone}','{$email}','{$password}','{$city}','{$pin}','{$d}')";
            
            if(mysqli_query($conn,$sql1) && !isset($SESSION['email'])){
                $_SESSION['registeredmessage']='<div class="alert alert-success">Registered Sucessfully...!.</div>';
                header("Location: http://localhost/okcl/okcl_crud/index.php");
            }
            else if(mysqli_query($conn,$sql1) && isset($SESSION['email'])){
                $_SESSION['registeredmessage']='<div class="alert alert-success">Registered Sucessfully...!.</div>';
                header("Location: http://localhost/okcl/okcl_crud/employee.php");
            }
            else{
                echo "<div class='alert alert-danger'>Can't Insert User.</div>";
            }
        }
    }
  }


?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading text-center">Add User</h1>
            </div>
            <div class="col-md-offset-3  ml-md-3 col-md-12 col-xl-10 m-lg-auto" >
                <!-- Form Start -->
                <form  action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" name="mname" class="form-control" placeholder="Middle Name">
                    </div>
                    <div class="form-group">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="form-group">
                        <label>D.O.B.<span class="text-danger">*</span></label>
                        <input type="date" name="dob" class="form-control"  required>
                    </div>
                    <div class="form-group">
                        <label>Gender<span class="text-danger">*</span></label><br>
                        <input type="radio" name="gender" value="male"   required><label >Male</label>
                        <input type="radio" name="gender"value="female"   required><label>Female</label>
                    </div>
                    <div class="form-group">
                        <label>User Role<span class="text-danger">*</span></label>
                        <select class="form-control" name="role" >
                            <option value="" >Select Option</option>
                            <option value="admin">Admin</option>
                            <!-- <option value="1">Admin</option> -->
                            <option value="manager">Manager</option>
                            <option value="employee">Employee</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone<span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone" min="10" max="10" required>
                    </div>
                    <div class="form-group">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label>Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label>City<span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                    </div>
                    <div class="form-group">
                        <label>Pin No.<span class="text-danger">*</span></label>
                        <input type="text" name="pin" class="form-control" placeholder="pin" min=6 required>
                    </div>
                    <br>
                    <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                    <?php  
                        if(!isset($_SESSION['email'])){
                            echo '<label style="margin-left:3px;">Have an account? <a href="index.php" >login</a></label>';
                        }
                        else{
                            echo '<label style="margin-left:10px;"><a href="employee.php" >Back</a></label>';
                        }
                    ?>
                        

                </form>
                    <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php
    include "footer.php"; 
?>