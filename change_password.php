<?php
    require('config.php');

    session_start();
    
    if(!isset($_SESSION['matric_number'])){
        header('Location: studentlogin.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION);
        header('Location: studentlogin.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DMS | Change Password</title>
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
        <a href="indexstudent.php" class="navbar-brand">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="indexstudent.php">Home</a>
            </li>            
            <li class="nav-item">
              <a class="nav-link" href="../help/">Search</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../help/">Upload Document</a> 
            </li>
            <li class="nav-item">
              <a class="nav-link" href="studentprofile.php">Profile</a>
            </li>
            
          </ul>

          <ul class="nav navbar-nav ml-auto">
          <li class="nav-item">
          <label style="color:white"><?php echo $_SESSION['lastname']?> <?php echo $_SESSION['firstname']?> <?php echo $_SESSION['middlename']?><a class="nav-link" href="change_password.php?logout=true" style="color:white">Logout</a></label>
          </li>

          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br></div>
    <br><br>
    <div class="container">
        <form method="POST">
            <div class="text-danger"></div>            
            <div class="col-lg-4 offset-lg-1">
                <div class="form-group">
                    <label class="col-form-label" for="old_password">Old password</label>
                    <input type="password" class="form-control"  id="old_password" name="old_password">
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="new_password">New password</label>
                    <input type="password" class="form-control"  id="new_password" name="new_password">
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="confirm_new_password">Confirm new password</label>
                    <input type="password" class="form-control"  id="confirm_new_password" name="confirm_new_password">
                </div>
                <div class="d-flex justify-content-center mt-3 login_container">
                    <input type="submit" name="update" id="update" class="btn btn-success update" value="Update">
                </div>    
            </div>
        
        </form>
        
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
          $(function(){
              $('#update').click(function(e){
                  var valid = this.form.checkValidity();
                  if(valid){
                    e.preventDefault();
                    var old_password = $('#old_password').val();
                    var new_password = $('#new_password').val();
                    var confirm_new_password = $('#confirm_new_password').val();
                      $.ajax({
                          type: 'POST',
                          url: 'change_password_process.php',
                          data: {old_password:old_password, new_password:new_password, confirm_new_password:confirm_new_password},
                          success:function(data){
                              Swal.fire({
                                  'title': '',
                                  'text': data,
                                  'type': ''
                              })
                              $('#old_password').val("");
                              $('#new_password').val("");
                              $('#confirm_new_password').val("");
                              
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
