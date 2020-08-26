<?php
    require_once('config.php');
    session_start();
    $message = '';
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_new_password = $_POST["confirm_new_password"];
    $sql = "
        SELECT * FROM student_details
        WHERE matric_number = '".$_SESSION['matric_number']."'        
    ";
    $statement = $db->prepare($sql);
    $statement->execute();               
    $result = $statement->fetchAll();
    $count = $statement->rowCount();            
    if($count > 0)
    {
        foreach($result as $row)
        {
            $old_pass = $row['password'];
            if(!empty($old_password))
            {
                if(sha1($old_password) == $old_pass)
                {
                    if(!empty($new_password))
                    {
                        if($confirm_new_password == $new_password)
                        {
                            $new_pass = sha1($confirm_new_password);
                            $sql = "
                            UPDATE student_details
                            SET password = '".$new_pass."'
                            WHERE matric_number = '".$_SESSION["matric_number"]."'
                            ";
                            $statement = $db->prepare($sql);
                            $success = $statement->execute();
                            if($success)
                            {
                                $message = "Password successfully changed ✅";
                            }
                            else
                            {
                                $message =  "Error in changing password 🚫";
                            }
                        }
                        else
                        {
                            $message = "new passwords do not match❗";
                        }
                    }
                    else
                    {
                        $message = "type your new password";
                    }                
                }
                else
                {
                    $message = "Wrong old password❗";
                }
            }
            else
            {
                $message = "Enter the details";
            }            
        }
    }
    echo $message;
?>   