<?php
  //Admin action to generate report for the academic session
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
    <title>DMS | Upload Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style3.css">

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
              <a class="nav-link" href="">Profile</a>
            </li>
          </ul>

          <ul class="nav navbar-nav ml-auto">
          <li class="nav-item">
            <label style="color:white">Hi - <?php echo $_SESSION['username'] ?><a class="nav-link" href="upload_report.php?logout=true" style="color:white">Logout</a></label>
            </li>
          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br><br><br></div>
    <form method="POST">
            <div class="text-danger"></div>            
            <div class="col-lg-4 offset-lg-1">
                <div class="form-group">
                    <label class="col-form-label" for="academic_session">Academic Session</label>
                    <input type="text" class="form-control" id="academic_session" name="academic_session" required>
                </div>
 
                <div class="d-flex justify-content-center mt-3 login_container">
                    <input type="submit" name="upload" id="upload" class="btn btn-success upload" value="Upload">
                </div>    
            </div>
        
        </form>
         
    <br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
          $(function(){
              $('#upload').click(function(e){
                  var valid = this.form.checkValidity();
                  if(valid){
                      var academic_session = $('#academic_session').val();
                                                                                       
                      e.preventDefault();

                      $.ajax({
                          type: 'POST',
                          url: 'report_process.php',
                          data: {academic_session: academic_session},
                          success:function(data){
                              Swal.fire({
                                  'title': 'Success!',
                                  'text': data,
                                  'type': 'success'
                              })
                              $('#academic_session').val("");
                              
                          },  
                          error:function(data){
                              Swal.fire({
                                  'title': 'Error!',
                                  'text': 'There was an error in saving your data',
                                  'type': 'error'
                              })
                          }
                      });
                  }
                  else{
                      Swal.fire({
                                  'title': 'Please fill all required fields',
                                  'text': 'error!',
                                  'type': 'error'
                              })
                  }
              });
          });
    </script>
</body>
</html>