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
    <title>DMS | CS</title>
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
            <label style="color:white"><?php echo $_SESSION['staff_lastname']?> <?php echo $_SESSION['staff_firstname']?><a class="nav-link" href="cs_staff.php?logout=true" style="color:white">Logout</a></label>
          </li>
          
          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br></div>
    
    <br><br>
    <div class="container">
        
        <h2 align="center" class="cabinet_title">Computer Science</h2>        
        <?php 

          $sql = "
            SELECT * FROM student_details
            WHERE course = 'Computer Science' AND level = '".$_GET['id']."'
            ORDER BY lastname ASC
          ";
          $statement = $db->prepare($sql);
          $statement->execute();
          $result = $statement->fetchAll();
          $count = $statement->rowCount();        
          $output = '
          <table class="table table-striped">
          <tr>
              <td>Name</td>                    
              <td>View Cabinet</td>                                                           
          </tr>
          ';
          if($count > 0)
          {               
          foreach($result as $row)
          {                       
              $data_student = $row['matric_number'];                                
              $output .= '
              <tr>                        
                  <td>'.$row['lastname'].' '.$row['firstname'].' '.$row['middlename'].'</td>                                            
                  <td><a href="staff_admincabinet.php?id='.$data_student.'" data-name='.$row['matric_number'].' id="view_departments" class="view_files btn btn-info btn-xs">View</a></td>                                                                                        
              </tr>
              ';
                                
          }                
          }
          $output .= '</table>';
          echo $output;
        ?>
    </div>

</body>
</html>
<script>
  $(document).ready(function(){
        load_cs_list();
        function load_cs_list()
        {
            var action = "fetch_cs";
            $.ajax({
                url: 'actionstaff.php',
                method: 'POST',
                data: {action:action},
                success:function(data)
                {
                    $('#cs_table').html(data);
                }
            })
        }
    
        $(document).on('click', '.view_profile', function(){
          var student_profile = $(this).data("name");            
          var action = "fetch_student_profile";
          $.ajax({
                  url: 'actionstaff.php',
                  method: 'POST',
                  data: {student_profile:student_profile, action:action},
                  success:function(data)
                  {
                    $('#cs_table').html(data);
                  }
              });
        });
        $(document).on('click', '.delete_file', function(){
            var file_name = $(this).data("name");
            var file_id = $(this).data("id");
            var action = "remove_student_file";
            if(confirm("Are you sure you want to delete this file?"))
            {
                $.ajax({
                    url: 'actionadmin.php',
                    method: 'POST',
                    data: {file_name:file_name, action:action, file_id:file_id},
                    success:function(data)
                    {                        
                        alert(data);
                    }
                });
            }
            else
            {
                return false;
            }
        });

      });
</script>