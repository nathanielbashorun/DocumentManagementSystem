<?php
    //Student User Actions
    require('config.php');
    session_start();

    if(isset($_POST["action"]))
    {
        if($_POST["action"] == "update_profile")
        {
            if(strlen($_POST['phone_number']) <= 11 && strlen($_POST['phone_number']) >= 11)
            {
                $sql = "
                    UPDATE student_details
                    SET sex = '".$_POST["sex"]."', level = '".$_POST["level"]."', phone_number = '".$_POST["phone_number"]."', email = '".$_POST["email"]."', address = '".$_POST["address"]."'
                    WHERE matric_number = '".$_SESSION["matric_number"]."'
                ";
                $statement = $db->prepare($sql);            
                if($statement->execute())
                {
                    echo "Profile Successfully Updated";                
                }
                else
                {
                    echo "Error In Updating Profile";
                }
            }
            else
            {
                header('HTTP/1.1 500 Internal Server Error');
                echo "Invalid phone number";
            }
            
        }
        if($_POST["action"] == "fetch")
        {
            $folder = array_filter(glob('Uploads'), 'is_dir');            
            $sql = "
                SELECT * FROM files
                WHERE User_id = '".$_SESSION['matric_number']."' 
                ORDER BY uploaded_on DESC
            ";
            $statement = $db->prepare($sql);
            $statement->execute();            
            $result = $statement->fetchAll();
            $count = $statement->rowCount();        
            $output = '
            <table class="table table-bordered table-striped">
                <tr>
                    <th>File Name</th>                    
                    <th>Update</th>
                    <th>Delete</th>                    
                    <th>View Files</th>
                </tr>
            ';
            if($count > 0)
            {
                foreach($result as $row)
                {    
                    $file_data = scandir("Uploads"); 
                    $path = "Uploads" . '/' . $row['file_name'];                
                    $output .= '
                    <tr>
                        <td>' . $row['file_name'] . '</td>                    
                        <td><button type="button" id="update" name="update" data-name="' . $row['file_name'] . '" class="update btn btn-warning btn-xs">Update</button></td>
                        <td><button type="button" id="delete" name="delete" data-name="' . $row['file_name'] . '" class="delete btn btn-danger btn-xs">Delete</button></td>                        
                        <td><a href="' .$path. '" target="_blank" id="view_files" name="view_files" data-name="' . $row['file_name'] . '" class="btn btn-secondary btn-xs">View File</a></td>
                    </tr>
                    ';
                    
                }
            }           
            else
            {
                $output .= '
                <tr>
                    <td colspan="6">No Files Found</td>
                </tr>
                ';
            }
            $output .= '</table>';
            echo $output;
        }        

        if($_POST["action"] == "change")
        {                              
            $oldname = "Uploads" . '/' . $_POST["old_name"];
            $newname = "Uploads" . '/' . $_POST["folder_name"];                          
                            
            $sql = "
                UPDATE files
                SET file_name = '".$_POST["folder_name"]."'
                WHERE file_name = '".$_POST["old_name"]."' AND User_id = '".$_SESSION["matric_number"]."'
            ";
            $statement = $db->prepare($sql);
            $statement->execute();
            rename($oldname, $newname);
            echo "File Name Changed!";
                                       
        }
        if($_POST["action"] == "remove_folder")
        {        
            //unlink($_POST["folder_name"]);            
            if(file_exists("Uploads" . '/' . $_POST["folder_name"]))
            {
                $sql = "
                    DELETE FROM files
                    WHERE file_name = '".$_POST["folder_name"]."' AND User_id = '".$_SESSION["matric_number"]."'
                ";
                $statement = $db->prepare($sql);
                $statement->execute();
                unlink("Uploads" . '/' . $_POST["folder_name"]);
                echo "File Deleted!";
            }
        }        
    }    
?>