
<?php
 session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Crud</title>
  </head>
  <body>
    <div id="header-admin">
      <!-- container -->
      <div class="container">
        <!-- row -->
        <div class="row">
          <!-- LOGO -->
          <div class="text-center">
            <h1 class="logo">CRUD</h1>
          
          </div>

          <!-- /LOGO -->
          <!-- LOGO-Out -->
          <?php
            if(isset($_SESSION["email"])){
          ?>
          <div class="text-center ">
            <a href="logout.php" class="admin-logout text-light">Hello <?php echo ucwords($_SESSION["Fname"]," "); ?>, logout</a>
          </div>
          <?php
            }
          ?>
          <!-- /LOGO-Out -->
        </div>
      </div>
    </div>

  </body>
</html>
