
<?php
  if(isset($_SESSION['flag'])){
    $flag==$_SESSION['flag'];
  }
  else{
    $flag=true;
  }
  
  // session_start();
  include "header.php";
  if(!isset($_SESSION["email"])){
    header("Location: http://localhost/okcl/okcl_crud/index.php");
   
  }
  


  
  // echo $_SESSION["role"];
  if(isset($_SESSION["adduser_by_admin_and_manager"])){
    echo $_SESSION["adduser_by_admin_and_manager"];
    unset($_SESSION["adduser_by_admin_and_manager"]);

  }
  if(isset($_SESSION["loginsuccess"])){
    echo $_SESSION["loginsuccess"];
    unset($_SESSION["loginsuccess"]);

  }
  if(isset($_SESSION["deleteuser"])){
    echo $_SESSION["deleteuser"];
    unset($_SESSION["deleteuser"]);

  }
  
  if(isset($_SESSION['updateusermessage'])){
    echo $_SESSION['updateusermessage'];
    unset($_SESSION['updateusermessage']);
  }
  if(isset($_SESSION['updateloginuserpassword'])){
    echo $_SESSION['updateloginuserpassword'];
    unset($_SESSION['updateloginuserpassword']);
  }
  if(isset($_GET['page'])){
    $pages=$_GET['page'];
  }
  else{
    $pages=1;
  }
?>
<style>
       
        
        </style>
<div id="admin-content">
  <div class="container">
    <div class="col-md-12">
        <h1 class="admin-heading text-center">All Users</h1>
    </div>
    <div  class="row">
      <?php
        if($_SESSION["role"]!="employee"){
      ?>
      <div class="col p-0">
		    <button class="btn add-new "><a style="color:white;" href="register.php?adduser_by_admin_and_manager=<?php echo 'true' ?>">add user</a>  </button>
    	</div>
      <?php
        }
        ?>
      <div class="col p-0 ">
        <input  id="mysearch" class="input rounded-2 p-1" type="text" placeholder="Search By Email" onkeyup="search()" autocomplete="off">
      </div>
      <div class="col p-0 ">
        <button style="float:right;" class="btn add-new pl-4 pr-4" onclick="sortTable()">Sort</button>
      </div>
      
    </div>
    
    <div class="row">
      <div class="table-responsive">
        <?php
          include "config.php";
          //   /* Calculate Offset Code */
          // $limit = 5;
          // if(isset($_GET['page'])){
          //   $page = $_GET['page'];
          // }
          // else{
          //       $page = 1;
          // }

          // $offset = ($page - 1) * $limit;

          
          $sql = "SELECT * FROM employee ORDER BY user_id ";//LIMIT {$offset},{$limit}
          $result = mysqli_query($conn, $sql) or die("Query Failed.");
          if(mysqli_num_rows($result) > 0){
            ?>
            <table class="table" id="mytable">
              <thead class="table-dark">
                <th>S.No.</th>
                <th>Full Name</th>
                <th>D.O.B.</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Email</th>
                <th>City</th>
                <th>Pin</th>
                <?php
                if($_SESSION["role"]=="admin"){
                ?>
                <th>Edit</th>
                <th>Delete</th>
                <?php
                }
                else if($_SESSION["role"]=="manager"){
                ?>
                <th>Edit</th>
                <?php
                }
                else{}
                ?>
              </thead>
              <tbody>
                <?php
                // $serial = $offset + 1;
                  $serial=1;
                while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                  <td class='id'><?php echo $serial; ?></td>
                  <td><?php $mname=$row['Mname']!=""?" ".$row['Mname']:""; 
                      echo ucwords($row['Fname'].$mname." ". $row['Lname']," "); 
                  ?></td>
                  <td><?php echo $row['dob']; ?></td>
                  <td><?php echo ucwords($row['gender']," "); ?></td>
                  <td><?php
                  if($row['role'] == "employee"){
                    echo "Employee";
                  }else if($row['role'] == "admin"){
                    echo "Admin";
                  }
                  else if($row['role'] == "manager"){
                    echo "Manager";
                  }
                  //   else{
                  //     echo "Other";
                  //   }
                  ?></td>
                  <td><?php echo $row['phone']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo ucwords($row['city']," "); ?></td>
                  <td><?php echo $row['pin']; ?></td>
                  <?php
                  if($_SESSION["role"]=="admin"){
                  ?>
                  <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"].".".$pages; ?>' onClick='return updated()'><i class='fa fa-edit text-primary'></i></a></td>
                  <td class='delete'><a href='delete-user.php?id=<?php echo $row["user_id"].".".$pages; ?>' onClick='return deleted()'><i class="fa fa-trash text-danger" ></i></a></td>
                  <?php
                    }
                    else if($_SESSION["role"]=="manager"){
                      if($row['role']=='manager' || $row['role']=='employee'){
                  ?>
                  <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"].".".$pages; ?>' onClick='return updated()'><i class='fa fa-edit'></i> </a></td>
                  <?php
                      }
                      else{
                  ?>

                  <?php
                      } 
                  }
                    ?>
                              
                </tr>
                <?php
                $serial++;
                } 
                ?>
              </tbody>
            </table>
            <script>
              function sortTable() {
                var table, rows, sorting, i, x, y, shouldsorting;
                table = document.getElementById("mytable");
                sorting = true;
                while (sorting) {
                  sorting = false;
                  rows = table.getElementsByTagName("tr");
                  for (i = 1; i < (rows.length - 1); i++) {
                    shouldsorting = false;
                    x = rows[i].getElementsByTagName("td")[1];
                    y = rows[i + 1].getElementsByTagName("td")[1];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                      shouldsorting = true;
                      break;
                    }
                  }
                  if (shouldsorting) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    sorting = true;
                  }
                }  
              }
                
              
              
              

              
              function search(){
                var filter,mytable,tr,td,i,textvalue;
                filter=document.getElementById("mysearch").value.toUpperCase();
                mytable=document.getElementById("mytable");
                tr=mytable.getElementsByTagName("tr");
                for(i=0;i<tr.length;i++){
                  td=tr[i].getElementsByTagName("td")[6];
                  if(td){
                    textvalue=td.textContent  ||td.innerHTML;
                    if(textvalue.toUpperCase().indexOf(filter)> -1){
                      tr[i].style.display="";
                    }
                    else{
                      tr[i].style.display="none";
                    }
                  }
                }
              }
              function deleted(){

                if(confirm('Are You Sure You Want to Delete User...!')) return  true;
                else return false;
                }
                function updated(){

                if(confirm('Are You Sure You Want to Update User Detail...!')) return  true;
                else return false;


              }

            </script>
            <?php
              }else {
                echo "<h3>No Results Found.</h3>";
              }
                
            ?>
      </div>
      <?php
        
        
        
        // show pagination
        // $sql1 = "SELECT * FROM employee";
        // $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

        // if(mysqli_num_rows($result1) > 0){

        //   $total_records = mysqli_num_rows($result1);

        //   $total_page = ceil($total_records / $limit);
        //   if($limit<$total_records){
        //   echo '<ul style="margin-left:38%;" class="pagination ml-auto mt-3 user-page">';
        //   if($page > 1){
        //     echo '<li class="page-item "><a class= "page-link " href="employee.php?page='.($page - 1).'">Prev</a></li>';
        //   }
        //   for($i = 1; $i <= $total_page; $i++){
        //     if($i == $page){
        //       $active = "active";
        //     }else{
        //       $active = "";
        //     }
        //     echo '<li class="'.$active.' page-item "><a class= "page-link" href="employee.php?page='.$i.'">'.$i.'</a></li>';
        //   }
        //   if($total_page > $page){
        //     echo '<li class="page-item "><a class= "page-link" href="employee.php?page='.($page + 1).'">Next</a></li>';
        //   }

        //   echo '</ul>';
        // }
        // }


      ?>


        
    </div>
    
  </div>
  
  
</div>
 