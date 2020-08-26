<?php
  // Admin viewing a Student's Profile
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
    <title>DMS | Student Profile</title>
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
            <label style="color:white">Hi - <?php echo $_SESSION['username'] ?><a class="nav-link" href="student_profileadmin.php?logout=true" style="color:white">Logout</a></label>
          </li>

          </ul>

        </div>
      </div>
    </div>
    <div class="col-lg-12"><br><br><br><br></div>            
    <br>
    <div class="container">    
      <div class="row">
        <div class="col-lg-6">        
          <div class="bs-component">
    <?php
    $message = "";
    if(isset($_GET['id'])){
    $query = "
            SELECT * FROM student_details
            WHERE matric_number = '" . $_GET['id'] . "'               
        ";            
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {                

            $output = '
            <table class="table table-responsive table-striped">
            
            <tr><td>Firstname: ' . $row['firstname'] . '</td></tr>                              
            <tr><td>Lastname: ' . $row['lastname'] . '</td></tr>
            <tr><td>Middlename: ' . $row['middlename'] . '</td></tr>
            <tr><td>Sex: ' . $row['sex'] . '</td></tr> 
            <tr><td>Level: ' . $row['level'] . '</td></tr> 
            <tr><td>Matric Number: ' . $row['matric_number'] . '</td></tr>  
            <tr><td>Student Status: ' . $row['student_status'] . '</td></tr>      
            <tr><td>Department: ' . $row['department'] . '</td></tr> 
            <tr><td>Course: ' . $row['course'] . '</td></tr>
            <tr><td>Telephone Number: ' . $row['phone_number'] . '</td></tr>                                                              
            <tr><td>Email: ' . $row['email'] . '</td></tr>                                
            <tr><td>Address: ' . $row['address'] . '</td></tr>                                                                    
            
            ';
        }
        $output .= '</table>';
        echo $output;
    }
        ?>
      </div>
      </div>
    <?php
      if(isset($_POST['update']))
      {
        
        $sql = "
            UPDATE student_details
            SET student_status = '".$_POST["student_status"]."'
            WHERE matric_number = '".$_GET['id']."'
        ";
        $statement = $db->prepare($sql);
        $res = $statement->execute();
        if($res){
          $message = "Successfully Updated ✅"; 
        }
        else{
          $message = "Error❗❗❗";
        }
      }
    ?>
    
    <div class="col-lg-4 offset-lg-1">
      <form action="" method="post">   
        <div class="text-info"><?php echo $message; ?></div>      
        <div class="form-group">
          <label for="student_status">Student's status</label>
          <select class="form-control" id="student_status" name="student_status" required>
            <option><?php foreach($result as $row){echo $row['student_status'];} ?></option>
            <option>Available</option>
            <option>Suspension</option>
            <option>Expelled</option>
            <option>Having disciplinary case</option>
            <option>On probation</option>
          </select>                          
        </div><br><br>      
      <!-- <div class="form-group">      
        <div class="custom-control custom-radio">
          <input type="radio" id="customRadio1" name="student_status" class="custom-control-input">
          <label class="custom-control-label" for="customRadio1">Available</label>
        </div>
        <div class="custom-control custom-radio">
          <input type="radio" id="customRadio2" name="student_status" class="custom-control-input">
          <label class="custom-control-label" for="customRadio2">Suspended</label>
        </div>       
        <div class="custom-control custom-radio">
          <input type="radio" id="customRadio3" name="student_status" class="custom-control-input">
          <label class="custom-control-label" for="customRadio3">Expelled</label>
        </div>
        <div class="custom-control custom-radio">
          <input type="radio" id="customRadio4" name="student_status" class="custom-control-input">
          <label class="custom-control-label" for="customRadio4">Having disciplinary case</label>
        </div>
        <div class="custom-control custom-radio">
          <input type="radio" id="customRadio5" name="student_status" class="custom-control-input">
          <label class="custom-control-label" for="customRadio5">On probation</label>
        </div>
      </div> -->
      <button type="submit" class="btn btn-primary btn-md" style="margin:0px 130px" id="update" name="update">Update</button>
      </form>
    </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script type="text/javascript">
        // $(function(){
        //     $('#update').click(function(e){
        //         var valid = this.form.checkValidity(e);
        //         if(valid){
        //             var action = "student_status";
        //             var student_status = $('#student_status').val();    
                                                                                                     
        //             e.preventDefault();

        //             $.ajax({
        //                 type: 'POST',
        //                 url: 'report_process.php',
        //                 data: {action: action, student_status: student_status},
        //                 success:function(data){
        //                     Swal.fire({
        //                         'title': 'Success!',
        //                         'text': data,
        //                         'type': 'success'
        //                     })                            
                            
        //                 },  
        //                 error:function(data){
        //                     Swal.fire({
        //                         'title': 'Error!',
        //                         'text': 'There was an error in saving your data',
        //                         'type': 'error'
        //                     })
        //                 }
        //             });
        //         }
        //         else{
        //             Swal.fire({
        //                         'title': 'Please fill all required fields',
        //                         'text': 'error!',
        //                         'type': 'error'
        //                     })
        //         }
        //     });
        // });
  </script>

</body>
</html>

