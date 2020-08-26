<?php
    //Backend of the report generation
    require_once('config.php');
    
    require('diag.php');
 
    session_start();

    $academic_session = $_POST['academic_session'];

    $sql_cs_enrolled = "
        SELECT * FROM student_details
        WHERE course = 'Computer Science' AND level = '100'        
    ";
    $statement_cs_enrolled = $db->prepare($sql_cs_enrolled);
    $statement_cs_enrolled->execute();                
    $count_cs_enrolled = $statement_cs_enrolled->rowCount();
    $sql_cis_enrolled = "
        SELECT * FROM student_details
        WHERE course = 'Computer Information Systems' AND level = '100'        
    ";
    $statement_cis_enrolled = $db->prepare($sql_cis_enrolled);
    $statement_cis_enrolled->execute();                
    $count_cis_enrolled = $statement_cis_enrolled->rowCount();
    $sql_ct_enrolled = "
        SELECT * FROM student_details
        WHERE course = 'Computer Technology' AND level = '100'        
    ";
    $statement_ct_enrolled = $db->prepare($sql_ct_enrolled);
    $statement_ct_enrolled->execute();                
    $count_ct_enrolled = $statement_ct_enrolled->rowCount();
    $total_enrolled = $count_cs_enrolled + $count_cis_enrolled + $count_ct_enrolled;

    $sql_100 = "
        SELECT * FROM student_details
        WHERE level = '100'        
    ";
    $statement_100 = $db->prepare($sql_100);
    $statement_100->execute();                
    $count_100 = $statement_100->rowCount();
    $sql_200 = "
        SELECT * FROM student_details
        WHERE level = '200'        
    ";
    $statement_200 = $db->prepare($sql_200);
    $statement_200->execute();                
    $count_200 = $statement_200->rowCount();
    $sql_300 = "
        SELECT * FROM student_details
        WHERE level = '300'        
    ";
    $statement_300 = $db->prepare($sql_300);
    $statement_300->execute();                
    $count_300 = $statement_300->rowCount();
    $sql_400 = "
        SELECT * FROM student_details
        WHERE level = '400'        
    ";
    $statement_400 = $db->prepare($sql_400);
    $statement_400->execute();                
    $count_400 = $statement_400->rowCount();
    
    $sql_cs = "
        SELECT * FROM student_details
        WHERE course = 'Computer Science'        
    ";
    $statement_cs = $db->prepare($sql_cs);
    $statement_cs->execute();                
    $count_cs = $statement_cs->rowCount();

    $sql_cis = "
        SELECT * FROM student_details
        WHERE course = 'Computer Information Systems'        
    ";
    $statement_cis = $db->prepare($sql_cis);
    $statement_cis->execute();                
    $count_cis = $statement_cis->rowCount();

    $sql_ct = "
        SELECT * FROM student_details
        WHERE course = 'Computer Technology'        
    ";
    $statement_ct = $db->prepare($sql_ct);
    $statement_ct->execute();                
    $count_ct = $statement_ct->rowCount();
    $total_students = $count_cs + $count_cis + $count_ct;

    $sql = "
        SELECT * FROM student_details
        WHERE level = '100' AND student_status = 'Probation'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_100_prb = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '200' AND student_status = 'Probation'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_200_prb = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '300' AND student_status = 'Probation'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_300_prb = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '400' AND student_status = 'Probation'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_400_prb = $statement->rowCount();

    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Science' AND student_status = 'Probation'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cs_prb = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Information Systems' AND student_status = 'Probation'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cis_prb = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Technology' AND student_status = 'Probation'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_ct_prb = $statement->rowCount();
    $total_probation = $count_cs_prb + $count_cis_prb + $count_ct_prb;

    $sql = "
        SELECT * FROM student_details
        WHERE level = '100' AND student_status = 'Having disciplinary case'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_100_svp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '200' AND student_status = 'Having disciplinary case'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_200_svp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '300' AND student_status = 'Having disciplinary case'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_300_svp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '400' AND student_status = 'Having disciplinary case'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_400_svp = $statement->rowCount();

    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Science' AND student_status = 'Having disciplinary case'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cs_svp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Information Systems' AND student_status = 'Having disciplinary case'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cis_svp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Technology' AND student_status = 'Having disciplinary case'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_ct_svp = $statement->rowCount();
    $total_cases = $count_cs_svp + $count_cis_svp + $count_ct_svp;
    
    $sql = "
        SELECT * FROM student_details
        WHERE level = '100' AND student_status = 'Suspension'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_100_sus = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '200' AND student_status = 'Suspension'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_200_sus = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '300' AND student_status = 'Suspension'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_300_sus = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '400' AND student_status = 'Suspension'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_400_sus = $statement->rowCount();

    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Science' AND student_status = 'Suspension'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cs_sus = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Information Systems' AND student_status = 'Suspension'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cis_sus = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Technology' AND student_status = 'Suspension'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_ct_sus = $statement->rowCount();
    $total_sus = $count_cs_sus + $count_cis_sus + $count_ct_sus;

    $sql = "
        SELECT * FROM student_details
        WHERE level = '100' AND student_status = 'Expelled'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_100_exp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '200' AND student_status = 'Expelled'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_200_exp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '300' AND student_status = 'Expelled'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_300_exp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE level = '400' AND student_status = 'Expelled'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_400_exp = $statement->rowCount();

    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Science' AND student_status = 'Expelled'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cs_exp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Information Systems' AND student_status = 'Expelled'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_cis_exp = $statement->rowCount();
    $sql = "
        SELECT * FROM student_details
        WHERE course = 'Computer Technology' AND student_status = 'Expelled'
    ";
    $statement = $db->prepare($sql);
    $statement->execute();                
    $count_ct_exp = $statement->rowCount();
    $total_exp = $count_cs_exp + $count_cis_exp + $count_ct_exp;

    class PDF extends PDF_Diag
    {    
    function Header()
    {
        global $title;
        $w = $this->GetStringWidth($title)+6;
        $this->SetX((210-$w)/2);
        $this->Image('img/logo2.jpg',10,6,23);
        $this->SetFont('Times','B',15);
        $this->SetLineWidth(1);
        $this->Cell($w,10,$title,0,0,'C');
        $this->Ln(20);
    }

    function Chapter($label)
    {
        $this->SetFont('Arial','',12);                
        $this->SetFillColor(4, 4, 92);        
        $this->Cell(0,6,$label,0,1,'L',true);        
        $this->Ln(4);
    }

    function MyBody()
    {
        

    }

    function Layout($num, $label, $file, $type)
    {
        
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times','',12);
        $this->Cell(0,10,$this->PageNo(),0,0,'C');
    }

    }

    $pdf = new PDF();

    
    $dataStudentsAdmitted = array('Computer Science' => $count_cs_enrolled, 'Computer Information Systems' => $count_cis_enrolled, 'Computer Technology' => $count_ct_enrolled);
    $dataStudentsNumber = array('100 level' => $count_100, '200 level' => $count_200, '300 level' => $count_300, '400 level' => $count_400);
    $dataStudentsNumber2 = array('Computer Science' => $count_cs, 'Computer Information Systems' => $count_cis, 'Computer Technology' => $count_ct);
    $dataStudentsProbation = array('100 level' => $count_100_prb, '200 level' => $count_200_prb, '300 level' => $count_300_prb, '400 level' => $count_400_prb);
    $dataStudentsProbation2 = array('Computer Science' => $count_cs_prb, 'Computer Information Systems' => $count_cis_prb, 'Computer Technology' => $count_ct_prb);
    $dataStudentsDisciplinaryCases = array('100 level' => $count_100_svp, '200 level' => $count_200_svp, '300 level' => $count_300_svp, '400 level' => $count_400_svp);
    $dataStudentsDisciplinaryCases2 = array('Computer Science' => $count_cs_svp, 'Computer Information Systems' => $count_cis_svp, 'Computer Technology' => $count_ct_svp);
    $dataStudentsSuspension = array('100 level' => $count_100_sus, '200 level' => $count_200_sus, '300 level' => $count_300_sus, '400 level' => $count_400_sus);
    $dataStudentsSuspension2 = array('Computer Science' => $count_cs_sus, 'Computer Information Systems' => $count_cis_sus, 'Computer Technology' => $count_ct_sus);
    $dataStudentsExpulsion = array('100 level' => $count_100_exp, '200 level' => $count_200_exp, '300 level' => $count_300_exp, '400 level' => $count_400_exp);
    $dataStudentsExpulsion2 = array('Computer Science' => $count_cs_exp, 'Computer Information Systems' => $count_cis_exp, 'Computer Technology' => $count_ct_exp);

    $title = "REPORT FOR THE ".$academic_session." ACADEMIC SESSION";
    $pdf->SetTitle($title);    
    $pdf->SetAuthor('BU');    
    $pdf->AliasNbPages();

    $pdf->AddPage();
    $pdf->Ln();
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Chapter('Number Of Students Enrolled');    
    $pdf->SetFont('Arial', 'BIU', 12);    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);  
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsAdmitted, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80); 
    $pdf->SetFont('Times', 'B', 12);    
    $pdf->SetTextColor(0, 0, 0);   
    $pdf->Cell(2, 4, 'Total number of students admitted for the academic session: '.$total_enrolled.'');
    
    $pdf->AddPage();
    $pdf->Ln();
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Chapter('Number Of Students In The Department');    
    $pdf->SetFont('Arial', 'BIU', 12);    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsNumber, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsNumber2, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $pdf->SetFont('Times', 'B', 12);    
    $pdf->SetTextColor(0, 0, 0);   
    $pdf->Cell(2, 4, 'Total number of students in the department: '.$total_students.'');

    $pdf->AddPage();
    $pdf->Ln();
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Chapter('Students On Probation');    
    $pdf->SetFont('Arial', 'BIU', 12);    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsProbation, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsProbation2, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);    
    $pdf->SetFont('Times', 'B', 12);    
    $pdf->SetTextColor(0, 0, 0);   
    $pdf->Cell(2, 4, 'Total number of students on probation: '.$total_probation.'');

    $pdf->AddPage();
    $pdf->Ln();
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Chapter('Students Having Discplinary Cases');    
    $pdf->SetFont('Arial', 'BIU', 12);    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsDisciplinaryCases, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsDisciplinaryCases2, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $pdf->SetFont('Times', 'B', 12);    
    $pdf->SetTextColor(0, 0, 0);   
    $pdf->Cell(2, 4, 'Total number of students having disciplinary cases: '.$total_cases.'');

    $pdf->AddPage();
    $pdf->Ln();
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Chapter('Students on Suspension');    
    $pdf->SetFont('Arial', 'BIU', 12);    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsSuspension, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsSuspension2, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $pdf->SetFont('Times', 'B', 12);    
    $pdf->SetTextColor(0, 0, 0);   
    $pdf->Cell(2, 4, 'Total number of students on suspension: '.$total_sus.'');

    $pdf->AddPage();
    $pdf->Ln();
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Chapter('Students On Expulsion');    
    $pdf->SetFont('Arial', 'BIU', 12);    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsExpulsion, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->BarDiagram(190, 70, $dataStudentsExpulsion2, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);
    $pdf->SetFont('Times', 'B', 12);    
    $pdf->SetTextColor(0, 0, 0);   
    $pdf->Cell(2, 4, 'Total number of students Expelled: '.$total_exp.'');
    
    
    $fileName = basename($title);
    $output = $pdf->Output("Uploads/$fileName", "F");       

    $sql= "
        INSERT INTO reports
        (User_id, file_name, uploaded_on)
        VALUES('".$_SESSION['user_id']."', '".$fileName."', NOW())
    ";                
    $statement = $db->prepare($sql);
            
    if($statement->execute() && !$output)
    {
        echo "report uploaded successfully";
    }
    else
    {
        echo "Error";
    }
 