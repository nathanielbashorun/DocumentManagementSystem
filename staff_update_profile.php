<?php
  //Staff profile update
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
<?php
    $query = "
            SELECT * FROM staff_details
            WHERE staff_id = '" . $_SESSION['staff_id'] . "'               
        ";            
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();        
?>            
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DMS | Update Profile</title>
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
            <label style="color:white"><?php echo $_SESSION['staff_lastname']?> <?php echo $_SESSION['staff_firstname']?><a class="nav-link" href="staff_update_profile.php?logout=true" style="color:white">Logout</a></label>
          </li>
          
          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br><br><br><br></div>
    <div class="container">
        <div class="bs-docs-section">
          <div class="row">
            <div class="col-lg-12">
              <div class="page-header">
                <h1 id="forms">Update Profile</h1>
              </div>
            </div>
          </div>
            <div class="row">
                <div class="col-lg-6">
                <div class="bs-component">
                    <form action="registration.php" method="post">
                    <fieldset>                    
                    <hr class="mb-3"><br>
                        <div class="form-group">
                          <label for="firstname">Firstname *</label>
                          <input type="text" class="form-control" name="firstname" id="firstname" value="<?php foreach($result as $row){echo $row['staff_firstname'];} ?>" disabled="">
                        </div>
                        <div class="form-group" disabled>
                          <label for="lastname">Lastname *</label>
                          <input type="text" class="form-control" id="lastname" name="lastname" value="<?php foreach($result as $row){echo $row['staff_lastname'];} ?>" disabled="">                        
                        </div>
                        <div class="form-group">
                          <label for="middlename">Middlename *</label>
                          <input type="text" class="form-control" id="middlename" name="middlename" value="<?php foreach($result as $row){echo $row['staff_middlename'];} ?>" disabled="">                          
                        </div>
                        <div class="form-group">
                          <label for="sex">Sex *</label>
                          <select class="form-control" id="sex" name="sex" value="<?php foreach($result as $row){echo $row['sex'];} ?>" required>
                          <option><?php foreach($result as $row){echo $row['sex'];} ?></option>
                          <option>Male</option>
                          <option>Female</option>
                          </select>                          
                        </div>                        
                        <div class="form-group">
                          <label for="matric_number">Staff ID *</label>
                          <input type="text" class="form-control" id="matric_number" name="matric_number" value="<?php foreach($result as $row){echo $row['staff_id'];} ?>" disabled="">                          
                        </div>                                                
                        <div class="form-group">
                          <label for="phone_number">Telephone Number *</label>
                          <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php foreach($result as $row){echo $row['phone_number'];} ?>" required>                          
                        </div>
                        <div class="form-group">
                          <label for="email">Email *</label>
                          <input type="email" class="form-control" id="email" name="email" value="<?php foreach($result as $row){echo $row['email'];} ?>" required>                          
                        </div>
                        <div class="form-group">
                          <label for="address">Address *</label>
                          <textarea class="form-control text_resize" id="address" name="address" rows="3" required><?php foreach($result as $row){echo $row['address'];}?></textarea>                          
                        </div>
                      </fieldset>
                      <button type="submit" class="btn btn-primary btn-md" id="update">Update</button>
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
              $('#update').click(function(e){
                  var valid = this.form.checkValidity();
                  if(valid){               
                      var action = "update_profile";       
                      var sex = $('#sex').val();                                                                                        
                      var phone_number = $('#phone_number').val();                     
                      var email = $('#email').val();
                      var address = $('#address').val();                                           
                      e.preventDefault();

                      $.ajax({
                          type: 'POST',
                          url: 'actionstaff.php',
                          data: {action: action,sex: sex,phone_number: phone_number,email: email, address: address},
                          success:function(data){
                              Swal.fire({
                                  'title': 'Success!',
                                  'text': data,
                                  'type': 'success'
                              })                              
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