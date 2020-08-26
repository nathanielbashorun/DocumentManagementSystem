<?php
    require('config.php');
    session_start();
    $statusMsg = '';
    $targetDir = "Uploads/";
    $fileName = basename($_FILES["upload_file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
 
    if($_FILES["upload_file"]["name"] != ''){
        $allowtypes = array('pdf');
        if(in_array($fileType, $allowtypes)){
            if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $targetFilePath)){               
                $sql= "
                    INSERT INTO files
                    (User_id, file_name, uploaded_on)
                    VALUES('" . $_SESSION['staff_id'] . "', '".$fileName."', NOW())
                ";                
                $statement = $db->prepare($sql);
                        
                if($statement->execute()){
                    $statusMsg = "The file ".$fileName." has been uploaded successfully";
                }
                else
                {
                    $statusMsg = "Error In File Upload";
                }
            }else
            {
                $statusMsg = "Error In File Upload";
            }        
        }else
        {
            $statusMsg = "File Not Supported!";
        }
    }else
        {
            $statusMsg = "Choose File To Upload!";
        }   
        echo $statusMsg;
?>