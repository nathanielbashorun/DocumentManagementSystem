<?php
    //Login Page Of The System
   require('config.php');

   session_start();

   $message = '';

   if(isset($_SESSION['matric_number']))
   {
       header("location: indexstudent.php");
   }

   if(isset($_POST['login']))
   {
       $query = "
        SELECT * FROM student_details
        WHERE matric_number = :matric_number AND password = :password AND student_status!='Suspension' AND student_status!='Expelled' LIMIT 1
       ";
       $statement = $db->prepare($query);
       $statement->execute(
           array(
               ':matric_number' => $_POST['username'],
               ':password' => sha1($_POST['password'])
           )
        );
        $count = $statement->rowCount();
        if($count > 0)
        {
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                $_SESSION['matric_number'] = $row['matric_number'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['middlename'] = $row['middlename'];
                $sub_query = "
                    INSERT INTO login_details
                    (user_id)
                    VALUES('" . $row['matric_number'] . "')
                ";
                $statement = $db->prepare($sub_query);
                $statement->execute();
                $_SESSION['login_details_id'] = $db->lastInsertId();
                header("location: indexstudent.php");
            }
        }
        else
        {
            $message = '<label>Wrong username or password</label>';
        }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DMS | STUDENT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <style>
        html,body{
            background: url(img/cabinet.jpg);
            background-size: 100%;
            background-width: 100%;
        }
    </style>
</head>
<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="img/logo2.jpg" alt="Babcock University" class="brand_logo">
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <form method="POST">
                        <div class="text-danger"><?php echo $message ?></div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="username" id="username" class="form-control input_user" required>
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control input_pass" required>
                        </div>
                </div>
                <div class="d-flex justify-content-center mt-3 login_container">
                    <input type="submit" name="login" id="login" class="btn login_btn" value="Login">
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>