<?php
    // Staff registration data entering datatbase with password generation
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
    $staff_id = $_POST['staff_id'];        
    $password = password_generate(7);
    $secured_password = sha1($password);
    $sql = 'INSERT INTO staff_details(staff_firstname, staff_lastname, staff_middlename, staff_id, password) VALUES(?,?,?,?,?)';
    $stmtinsert = $db->prepare($sql);
    $result = $stmtinsert->execute([$firstname, $lastname, $middlename, $staff_id, $secured_password]);
    if($result){            
        echo "Data successfully saved Staff's Password: ".$password;        
    }
    else{
        echo "error in connecting to the database"; 
    }
 