<?php
    // Uploaded Reports Lists
    require('config.php');

    session_start();
    
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION);
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DMS | Reports</title>
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
        <a href="index.php" class="navbar-brand">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="departments.php">Department</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reports_admin.php">Departmental Reports</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add_user.php">Add User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../help/">Search</a> 
            </li>
            <li class="nav-item">
              <a class="nav-link" href="upload_report.php">Upload Report</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../help/">Profile</a>
            </li>
          </ul>

          <ul class="nav navbar-nav ml-auto">
          <li class="nav-item">
            <label style="color:white"><?php echo $_SESSION['username'] ?><a class="nav-link" href="reports_admin.php?logout=true" style="color:white">Logout</a></label>
          </li>

          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br></div>
    
    <br><br>
    <div class="container">
        
        <h2 align="center" class="cabinet_title">Departmental Reports</h2>
        
        <div id="folder_table" class="table-responsive">
          
        </div>
    </div>

</body>
</html>


<script>
    $(document).ready(function(){
        load_report_list();
        function load_report_list()
        {
            var action = "fetch_reports";
            $.ajax({
                url: 'actionadmin.php',
                method: 'POST',
                data: {action:action},
                success:function(data)
                {
                    $('#folder_table').html(data);
                }
            })
        }                
        $(document).on('click', '.view_files', function(){
            var folder_name = $(this).data("name");
            var action = "fetch_files";
            $.ajax({
                url: 'actionadmin.php',
                method: 'POST',
                data: {folder_name:folder_name, action:action},
                success:function(data)
                {
                    $('#filelistModal').modal('show');
                    $('#file_list').html(data);
                }
            });
        });        
        $(document).on('click', '.delete_report', function(){
            var folder_name = $(this).data("name");
            var action = "remove_report";
            if(confirm("Are you sure you want to delete this file?"))
            {
                $.ajax({
                    url: 'actionadmin.php',
                    method: 'POST',
                    data: {folder_name:folder_name, action:action},
                    success:function(data)
                    {
                        load_report_list();
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