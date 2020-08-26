<?php
//Admin registering student to the system
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
    <title>DMS | Register Student</title>
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
            <label style="color:white">Hi - <?php echo $_SESSION['username'] ?><a class="nav-link" href="student_registration.php?logout=true" style="color:white">Logout</a></label>
            </li>
          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br><br><br></div>
    <div class="container">
        <div class="bs-docs-section">
          <div class="row">
            <div class="col-lg-12">
              <div class="page-header">
                <h1 id="forms">Register Student</h1>
              </div>
            </div>
          </div>
            <div class="row">
                <div class="col-lg-6">
                <div class="bs-component">
                    <form action="registration.php" method="post">
                    <fieldset>
                    <legend>Fill up the form with the correct values</legend>
                    <hr class="mb-3"><br>         
                        <div class="form-group">
                          <label for="firstname">Firstname *</label>
                          <input type="text" class="form-control" name="firstname" id="firstname" required>
                        </div>              
                        <div class="form-group">
                          <label for="lastname">Lastname *</label>
                          <input type="text" class="form-control" id="lastname" name="lastname" required>                        
                        </div>                                              
                        <div class="form-group">
                          <label for="middlename">Middlename *</label>
                          <input type="text" class="form-control" id="middlename" name="middlename" required>                          
                        </div>
                        <div class="form-group">
                          <label for="matric_number">Matric Number *</label>
                          <input type="text" class="form-control" id="matric_number" name="matric_number" required>                          
                        </div>
                        <div class="form-group">
                          <label for="course">Course of Study *</label>
                              <select class="form-control" id="course" name="course" required>
                              <option></option>
                              <option>Computer Science</option>
                              <option>Computer Information Systems</option>
                              <option>Computer Technology</option>                              
                            </select>                            
                        </div>                                                
                      </fieldset>
                      <button type="submit" class="btn btn-primary btn-md" id="submit">Submit</button>
                    </form>
                </div>

                </div>
            </div>
        </div>
    </div>
    <br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
          $(function(){
              $('#submit').click(function(e){
                  var valid = this.form.checkValidity();
                  if(valid){
                      var firstname = $('#firstname').val();
                      var lastname = $('#lastname').val();
                      var middlename = $('#middlename').val();                      
                      var matric_number = $('#matric_number').val();
                      var course = $('#course').val();                                                                
                      e.preventDefault();

                      $.ajax({
                          type: 'POST',
                          url: 'student_process.php',
                          data: {firstname: firstname,lastname: lastname,middlename: middlename,matric_number: matric_number,course: course},
                          success:function(data){
                              Swal.fire({
                                  'title': 'Success!',
                                  'text': data,
                                  'type': 'success'
                              })
                              $('#firstname').val("");
                              $('#lastname').val("");
                              $('#middlename').val("");                              
                              $('#matric_number').val("");
                              $('#course').val("");                             
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