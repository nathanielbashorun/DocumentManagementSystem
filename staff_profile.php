<?php
    require('config.php');

    session_start();
    
    if(!isset($_SESSION['staff_id'])){
        header('Location: stafflogin.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION);
        header('Location: stafflogin.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DMS | Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>

     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();

    </script>
  </head>
  <body>
    <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
      <div class="container">
        <a href="indexstaff.php" class="navbar-brand">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="indexstaff.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="staff_department.php">Department</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../help/">Search</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reports.php">Departmental Reports</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="staff_profile.php">Profile</a>
            </li>
            
          </ul>

          <ul class="nav navbar-nav ml-auto">
          <li class="nav-item">
            <label style="color:white"><?php echo $_SESSION['staff_lastname']?> <?php echo $_SESSION['staff_firstname']?><a class="nav-link" href="staff_profile.php?logout=true" style="color:white">Logout</a></label>
          </li>
          
          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br></div>        
    <div class="navbar navbar-expand-sm" style="margin: 0px 300px"><a href="staff_update_profile.php" class="nav-link">Update Profile</a><a href="staff_change_password.php" class="nav-link">Change Password</a></div>
    <br>
    <div class="container">    
    <?php
    $query = "
            SELECT * FROM staff_details
            WHERE staff_id = '" . $_SESSION['staff_id'] . "'               
        ";            
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {                
            $output = '
            <table class="table table-responsive table-striped">
            
            <tr><td>Firstname: ' . $row['staff_firstname'] . '</td></tr>                              
            <tr><td>Lastname: ' . $row['staff_lastname'] . '</td></tr>
            <tr><td>Middlename: ' . $row['staff_middlename'] . '</td></tr>
            <tr><td>Sex: ' . $row['sex'] . '</td></tr>              
            <tr><td>Staff ID: ' . $row['staff_id'] . '</td></tr>                                 
            <tr><td>Telephone Number: ' . $row['phone_number'] . '</td></tr>                                                              
            <tr><td>Email: ' . $row['email'] . '</td></tr>                                
            <tr><td>Address: ' . $row['address'] . '</td></tr>                                                                                
            ';
        }
        $output .= '</table>';
        echo $output;
        ?>

    </div>

</body>
</html>