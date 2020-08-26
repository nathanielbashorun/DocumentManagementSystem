<?php
    // Student registration data entering datatbase with password generation
    require_once('config.php');
 ?>
 <?php
    function password_generate($chars)
    {
        $data = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];    
    $middlename = $_POST['middlename'];
    $matric_number = $_POST['matric_number'];
    $course = $_POST['course'];
    $department = 'Computer Science';  
    $student_status = 'Available';        
    $password = password_generate(7);
    $secured_password = sha1($password);    
    if(strlen($matric_number) <= 7 && strlen($matric_number) >= 7)
    {
        $sql = 'INSERT INTO student_details(firstname, lastname, middlename, matric_number, course, department, student_status, password) VALUES(?, ?,?,?,?,?,?,?)';
        $stmtinsert = $db->prepare($sql);
        $result = $stmtinsert->execute([$firstname, $lastname, $middlename, $matric_number, $course, $department, $student_status, $secured_password]);
        if($result){          
            if(substr($matric_number, 0, 2) == 19)   
            {
                $sql = "
                    UPDATE student_details
                    SET level = '100'
                    WHERE matric_number = '".$matric_number."'
                ";
                $statement = $db->prepare($sql);            
                $statement->execute();
            }
            else if(substr($matric_number, 0, 2) == 18)
            {
                $sql = "
                    UPDATE student_details
                    SET level = '200'
                    WHERE matric_number = '".$matric_number."'
                ";
                $statement = $db->prepare($sql);            
                $statement->execute();
            }
            else if(substr($matric_number, 0, 2) == 17)
            {
                $sql = "
                    UPDATE student_details
                    SET level = '300'
                    WHERE matric_number = '".$matric_number."'
                ";
                $statement = $db->prepare($sql);            
                $statement->execute();
            }
            else if(substr($matric_number, 0, 2) <= 16)
            {
                $sql = "
                    UPDATE student_details
                    SET level = '400'
                    WHERE matric_number = '".$matric_number."'
                ";
                $statement = $db->prepare($sql);            
                $statement->execute();
            }
            echo "Data successfully saved Student's Password: ".$password;        
        }
        else{
            echo "error in connecting to the database"; 
        }
    }
    else
    {
        echo "Invalid matric number";
        header('HTTP/1.1 500 Internal Server Error');        
    }