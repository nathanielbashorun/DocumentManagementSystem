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
    <title>DMS | Student Cabinet</title>
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
            <label style="color:white"><?php echo $_SESSION['staff_lastname']?> <?php echo $_SESSION['staff_firstname']?><a class="nav-link" href="staff_admincabinet.php?logout=true" style="color:white">Logout</a></label>
          </li>
          
          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br></div>
    
    <br><br>
    <div class="container">

     <?php 
        $sql_std = "
          SELECT * FROM student_details
          WHERE matric_number = '".$_GET['id']."'          
      ";
      $statement_std = $db->prepare($sql_std);
      $statement_std->execute();
      $result_std = $statement_std->fetchAll();
      $count_std = $statement_std->rowCount();
      foreach($result_std as $row_std)
      {
        $student_profile = $row_std['matric_number'];
      }
     ?>
        
        <h2 align="center" class="cabinet_title">Cabinet</h2>        
        <div id="cabinet_table" class="table-responsive">
          <div align="right">
            <?php 
              $output = '
                <a href="staff_profileadmin.php?id='.$student_profile.'" align="right" class="btn btn-info">view student details</a>
              ';
              echo $output;
            ?>            
          </div>          
        <?php              
          if(isset($_GET['id'])){
            $sql = "
                  SELECT * FROM files
                  WHERE User_id = '".$_GET['id']."'
                  ORDER BY uploaded_on ASC
              ";
              $statement = $db->prepare($sql);
              $statement->execute();
              $result = $statement->fetchAll();
              $count = $statement->rowCount();        
              $output = '
              <table class="table table-striped">
              <tr>
                  <th>File Name</th>                                    
                  <th></th>                    
                  <th>View Files</th>
              </tr>
              ';
              if($count > 0)
              {               
                  foreach($result as $row)
                  {    
                      $file_data = scandir("Uploads"); 
                      $path = "Uploads" . '/' . $row['file_name'];                                  
                      $output .= '
                      <tr>
                          <td>' . $row['file_name'] . '</td>                                            
                          <td></td>                        
                          <td><a href="'.$path.'" target="_blank" id="view_files" name="view_files" data-name="' . $row['file_name'] . '" class="btn btn-secondary btn-xs">View File</a></td>
                      </tr>
                      ';
                                        
                  }                
              }
              else
              {
                  $output .= '
                  <tr>
                      <td colspan="6">No Files Found</td>
                  </tr>
                  ';
              }
              $output .= '</table>';
              echo $output;
          }

      ?>

        </div>
    </div>
    

</body>
</html>
<script>
  $(document).ready(function(){
        //load_cabinet_list();
        function load_cabinet_list()
        {            
            var student_files = $.get( "actionadmin.php", { name: 'id'}); 
            var action = "fetch_student_files";            
            $.ajax({
                url: 'actionadmin.php',
                method: 'POST',
                data: {action:action, student_files:student_files},
                success:function(data)
                {
                    $('#cabinet_table').html(data);
                }
            })          
        }
         
        $(document).on('click', '.view_profile', function(){
          var student_profile = $(this).data("name");            
          var action = "fetch_student_profile";
          $.ajax({
                  url: 'actionadmin.php',
                  method: 'POST',
                  data: {student_profile:student_profile, action:action},
                  success:function(data)
                  {
                    $('#cis_table').html(data);
                  }
              });
        });        

      });
</script>