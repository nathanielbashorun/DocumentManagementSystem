<?php
    // The Admin User Actions
    require('config.php');
    session_start();

    if(isset($_GET['change'])){                
        header('Location: indexstudent.php');
    }

    if(isset($_POST["action"]))
    {
        if($_POST["action"] == "fetch")
        {            
            $sql = "
                SELECT * FROM files
                WHERE User_id = '".$_SESSION['user_id']."'
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
                WHERE file_name = '".$_POST["old_name"]."' AND User_id = '".$_SESSION["user_id"]."'
            ";
            $statement = $db->prepare($sql);
            $statement->execute();
            rename($oldname, $newname);
            echo "File Name Changed!";
                                       
        }
        if($_POST["action"] == "remove_folder")
        {
            if(file_exists("Uploads" . '/' . $_POST["folder_name"]))
            {
                $sql = "
                    DELETE FROM files
                    WHERE file_name = '".$_POST["folder_name"]."' AND User_id = '".$_SESSION["user_id"]."'
                ";
                $statement = $db->prepare($sql);
                $statement->execute();
                unlink("Uploads" . '/' . $_POST["folder_name"]);
                echo "File Deleted!";
            }            
        }        
        if($_POST["action"] == "fetch_staff_list")
        {
            $sql = "
                SELECT * FROM staff_details                         
            ";
            $statement = $db->prepare($sql);
            $statement->execute();            
            $result = $statement->fetchAll();
            $output = '
            <table class="table table-striped">
                <tr>                                   
                    <th>Staff Name</th>
                    <th>Phone Number</th>                                        
                    <th>Email Address</th>
                    <th>Delete Account</th>
                </tr>
            ';
            foreach($result as $row)
            {                                                                      
                $output .= '
                <tr>                        
                    <td>'.$row['staff_lastname'].' '.$row['staff_firstname'].' '.$row['staff_middlename'].'</td>                                            
                    <td>'.$row['phone_number'].'</td>                                                                                        
                    <td>'.$row['email'].'</td>                                                                                        
                    <td><button data-name='.$row['staff_id'].' class="delete_staff_account btn btn-danger btn-xs">Delete</button></td>
                </tr>
                ';                                                  
            }
            $output .= '</table>';
            echo $output; 
        }
        if($_POST["action"] == "delete_staff_account")
        {
            $query = "
                DELETE FROM staff_details
                WHERE staff_id = '" .$_POST["account"]. "'        
            ";            
            $statement = $db->prepare($query);
            
            if($statement->execute())
            {
                echo "Account successfully deleted";
            }
            else
            {
                echo "Error in deleting account";
            }
        }
        if($_POST["action"] == "fetch_departments")
        {   
            $sql_cs = "
                SELECT * FROM student_details
                WHERE course = 'Computer Science'           
            ";
            $statement_cs = $db->prepare($sql_cs);
            $statement_cs->execute();            
            $result_cs = $statement_cs->fetchAll();
            $count_cs = $statement_cs->rowCount();      
            $sql_cis = "
                SELECT * FROM student_details
                WHERE course = 'Computer Information Systems'           
            ";
            $statement_cis = $db->prepare($sql_cis);
            $statement_cis->execute();            
            $result_cis = $statement_cis->fetchAll();
            $count_cis = $statement_cis->rowCount();   
            $sql_ct = "
                SELECT * FROM student_details
                WHERE course = 'Computer Technology'           
            ";
            $statement_ct = $db->prepare($sql_ct);
            $statement_ct->execute();            
            $result_ct = $statement_ct->fetchAll();
            $count_ct = $statement_ct->rowCount();           
            $output = '
            <table class="table table-striped">
                <tr>
                    <td>Department</td>                    
                    <td style="text-align:center">Number of students</td>
                    <td style="text-align:center">View Department</td>                                        
                </tr>
            ';
            $output .= '
                <tr>
                    <th>Computer Science</th>
                    <td style="text-align:center">'.$count_cs.'</td>
                    <td style="text-align:center"><a href="cs_levels_admin.php" id="view_departments" class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>Computer Information Systems</th>
                    <td style="text-align:center">'.$count_cis.'</td>
                    <td style="text-align:center"><a href="cis_levels_admin.php" id="view_departments" class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>Computer Technology</th>
                    <td style="text-align:center">'.$count_ct.'</td>
                    <td style="text-align:center"><a href="ct_levels_admin.php" id="view_departments" class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';            
            $output .= '</table>';
            echo $output;
        }
        if($_POST["action"] == "fetch_levels_cs")
        {
            $level_100 = 100;
            $level_200 = 200;
            $level_300 = 300;
            $level_400 = 400;
            $sql_100 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Science' AND level ='100'
                ORDER BY level ASC
            ";
            $statement_100 = $db->prepare($sql_100);
            $statement_100->execute();
            $result_100 = $statement_100->fetchAll();
            $count_100 = $statement_100->rowCount();
            $sql_200 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Science' AND level ='200'
                ORDER BY level ASC
            ";
            $statement_200 = $db->prepare($sql_200);
            $statement_200->execute();
            $result_200 = $statement_200->fetchAll();
            $count_200 = $statement_200->rowCount();
            $sql_300 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Science' AND level ='300'
                ORDER BY level ASC
            ";
            $statement_300 = $db->prepare($sql_300);
            $statement_300->execute();
            $result_300 = $statement_300->fetchAll();
            $count_300 = $statement_300->rowCount();     
            $sql_400 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Science' AND level ='400'
                ORDER BY level ASC
            ";
            $statement_400 = $db->prepare($sql_400);
            $statement_400->execute();
            $result_400 = $statement_400->fetchAll();
            $count_400 = $statement_400->rowCount();   
            $output = '
            <table class="table table-striped">
                <tr>
                    <td>Level</td>                    
                    <td style="text-align:center">Number of students</td>
                    <td style="text-align:center">View Students</td>                                        
                </tr>
            ';
            $output .= '
                <tr>
                    <th>100</th>
                    <td style="text-align:center">'.$count_100.'</td>
                    <td style="text-align:center"><a href="cs_admin.php?id='.$level_100.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>200</th>
                    <td style="text-align:center">'.$count_200.'</td>
                    <td style="text-align:center"><a href="cs_admin.php?id='.$level_200.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>300</th>
                    <td style="text-align:center">'.$count_300.'</td>
                    <td style="text-align:center"><a href="cs_admin.php?id='.$level_300.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>400</th>
                    <td style="text-align:center">'.$count_400.'</td>
                    <td style="text-align:center"><a href="cs_admin.php?id='.$level_400.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '</table>';
            echo $output;
        }        
        if($_POST["action"] == "fetch_levels_ct")
        {
            $level_100 = 100;
            $level_200 = 200;
            $level_300 = 300;
            $level_400 = 400;
            $sql_100 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Technology' AND level ='100'
                ORDER BY level ASC
            ";
            $statement_100 = $db->prepare($sql_100);
            $statement_100->execute();
            $result_100 = $statement_100->fetchAll();
            $count_100 = $statement_100->rowCount();
            $sql_200 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Technology' AND level ='200'
                ORDER BY level ASC
            ";
            $statement_200 = $db->prepare($sql_200);
            $statement_200->execute();
            $result_200 = $statement_200->fetchAll();
            $count_200 = $statement_200->rowCount();
            $sql_300 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Technology' AND level ='300'
                ORDER BY level ASC
            ";
            $statement_300 = $db->prepare($sql_300);
            $statement_300->execute();
            $result_300 = $statement_300->fetchAll();
            $count_300 = $statement_300->rowCount();     
            $sql_400 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Technology' AND level ='400'
                ORDER BY level ASC
            ";
            $statement_400 = $db->prepare($sql_400);
            $statement_400->execute();
            $result_400 = $statement_400->fetchAll();
            $count_400 = $statement_400->rowCount();   
            $output = '
            <table class="table table-striped">
                <tr>
                    <td>Level</td>                    
                    <td style="text-align:center">Number of students</td>
                    <td style="text-align:center">View Students</td>                                        
                </tr>
            ';
            $output .= '
                <tr>
                    <th>100</th>
                    <td style="text-align:center">'.$count_100.'</td>
                    <td style="text-align:center"><a href="ct_admin.php?id='.$level_100.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>200</th>
                    <td style="text-align:center">'.$count_200.'</td>
                    <td style="text-align:center"><a href="ct_admin.php?id='.$level_200.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>300</th>
                    <td style="text-align:center">'.$count_300.'</td>
                    <td style="text-align:center"><a href="ct_admin.php?id='.$level_300.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>400</th>
                    <td style="text-align:center">'.$count_400.'</td>
                    <td style="text-align:center"><a href="ct_admin.php?id='.$level_400.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '</table>';
            echo $output;
        }        
        if($_POST["action"] == "fetch_levels_cis")
        {
            $level_100 = 100;
            $level_200 = 200;
            $level_300 = 300;
            $level_400 = 400;
            $sql_100 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Information Systems' AND level ='100'
                ORDER BY level ASC
            ";
            $statement_100 = $db->prepare($sql_100);
            $statement_100->execute();
            $result_100 = $statement_100->fetchAll();
            $count_100 = $statement_100->rowCount();
            $sql_200 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Information Systems' AND level ='200'
                ORDER BY level ASC
            ";
            $statement_200 = $db->prepare($sql_200);
            $statement_200->execute();
            $result_200 = $statement_200->fetchAll();
            $count_200 = $statement_200->rowCount();
            $sql_300 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Information Systems' AND level ='300'
                ORDER BY level ASC
            ";
            $statement_300 = $db->prepare($sql_300);
            $statement_300->execute();
            $result_300 = $statement_300->fetchAll();
            $count_300 = $statement_300->rowCount();     
            $sql_400 = "
                SELECT * FROM student_details
                WHERE course = 'Computer Information Systems' AND level ='400'
                ORDER BY level ASC
            ";
            $statement_400 = $db->prepare($sql_400);
            $statement_400->execute();
            $result_400 = $statement_400->fetchAll();
            $count_400 = $statement_400->rowCount();   
            $output = '
            <table class="table table-striped">
                <tr>
                    <td>Level</td>                    
                    <td style="text-align:center">Number of students</td>
                    <td style="text-align:center">View Students</td>                                        
                </tr>
            ';
            $output .= '
                <tr>
                    <th>100</th>
                    <td style="text-align:center">'.$count_100.'</td>
                    <td style="text-align:center"><a href="cis_admin.php?id='.$level_100.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>200</th>
                    <td style="text-align:center">'.$count_200.'</td>
                    <td style="text-align:center"><a href="cis_admin.php?id='.$level_200.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>300</th>
                    <td style="text-align:center">'.$count_300.'</td>
                    <td style="text-align:center"><a href="cis_admin.php?id='.$level_300.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '
                <tr>
                    <th>400</th>
                    <td style="text-align:center">'.$count_400.'</td>
                    <td style="text-align:center"><a href="cis_admin.php?id='.$level_400.'"  class="btn btn-info btn-xs">View</a></td>
                </tr>
            ';
            $output .= '</table>';
            echo $output;
        }        
        if($_POST["action"] == "delete_account")
        {
            $query = "
                DELETE FROM student_details
                WHERE matric_number = '" .$_POST["account"]. "'        
            ";            
            $statement = $db->prepare($query);
            
            if($statement->execute())
            {
                echo "Account successfully deleted";
            }
            else
            {
                echo "Error in deleting account";
            }
        }                
        if($_POST["action"] == "remove_student_file")
        {            
            if(file_exists("Uploads" . '/' . $_POST["file_name"]))
            {
                $sql = "
                    DELETE FROM files
                    WHERE file_name = '".$_POST["file_name"]."' AND User_id = '".$_POST["file_id"]."'
                ";
                $statement = $db->prepare($sql);
                $statement->execute();
                unlink("Uploads" . '/' . $_POST["file_name"]);
                echo "File Deleted!";
            }
        }
        if($_POST["action"] == "fetch_reports")
        {            
            $sql = "
                SELECT * FROM reports                
                ORDER BY uploaded_on DESC
            ";
            $statement = $db->prepare($sql);
            $statement->execute();            
            $result = $statement->fetchAll();
            $count = $statement->rowCount();        
            $output = '
            <table class="table table-striped">
                <tr>
                    <th>File Name</th>                                        
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
                        <td><button type="button" id="delete" name="delete" data-name="' . $row['file_name'] . '" class="delete_report btn btn-danger btn-xs">Delete</button></td>                        
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
        if($_POST["action"] == "remove_report")
        {
            if(file_exists("Uploads" . '/' . $_POST["folder_name"]))
            {
                $sql = "
                    DELETE FROM reports
                    WHERE file_name = '".$_POST["folder_name"]."' AND User_id = '".$_SESSION["user_id"]."'
                ";
                $statement = $db->prepare($sql);
                $statement->execute();
                unlink("Uploads" . '/' . $_POST["folder_name"]);
                echo "File Deleted!";
            }            
        }               
    }    
?>