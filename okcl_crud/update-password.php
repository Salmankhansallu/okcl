
<?php
    include "header.php";
    if(!isset($_SESSION['emailupdate']) ){
        header("Location: http://localhost/okcl/okcl_crud/forget.php");

    }
    if(isset($_SESSION['emailwrongforupdate'])){
        echo $_SESSION["emailwrongforupdate"];
        unset($_SESSION["emailwrongforupdate"]);
    }

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading text-center">Reset Password</h1>
            </div>
            <div class="col-md-offset-3  ml-md-3 col-md-12 col-xl-10 m-lg-auto" >
                <!-- Form Start -->
                <form id="forgetpassword" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="form-group">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control" placeholder="Email" required>

                    </div>
                    <div class="form-group">
                        <label>Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>

                    </div>
                    <br>
                    <input type="submit" name="reset" class="btn btn-primary" value="Reset" />
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php
    include "footer.php"; 
?>
<?php
    if(isset($_POST['reset'])){
        include "config.php";
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,md5($_POST['password']));
        // echo $email,"and",$_SESSION['emailupdate'];
        $sql1="SELECT email FROM employee where email='{$_SESSION["emailupdate"]}'";
        $result=mysqli_query($conn,$sql1);
        while($row=mysqli_fetch_assoc($result)){
            if($row['email']==$email){
                $sql2 = "UPDATE employee SET email = '{$row["email"]}', password = '{$password}' where email='{$_SESSION["emailupdate"]}'";
                if(mysqli_query($conn,$sql2)){
                    // $_SESSION['emailupdate']="";
                    if(isset($_SESSION["email"])){
                        $_SESSION['updateloginuserpassword']='<div class="alert alert-success">Password Update Successfully...!</div>';

                        header("Location: employee.php");
                    }
                    else{
                        $_SESSION['updateuserpassword']='<div class="alert alert-success">Password Update Successfully....!</div>';
                        header("Location: index.php");
                    }
                    
                }
                else{
                    $_POST['email']="";
                    $_SESSION['emailwrongforupdate']='<div class="alert alert-danger">Somethink Wrong...!</div>';
                    header("Location: update-password.php");
                }
            }
            else{
                $_SESSION['emailwrongforupdate']='<div class="alert alert-danger">Email does not matched...!</div>';
                header("Location: update-password.php");
            }
        }
    
    }
?>