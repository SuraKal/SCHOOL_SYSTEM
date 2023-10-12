<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
?>
        <table border="1">
        <thead>
            <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Admission No</th>
            <th>Class</th>
            <th>Batch</th>
            <th>Status</th>
            <th>Date</th>
            </tr>
        </thead>
                <?php 
                    $filename="Attendance list";
                    $dateTaken = date("Y-m-d", strtotime("-7 days")); // The last 7 days record
                    $cnt=1;			
                    $ret = mysqli_query($conn,"SELECT *
                            FROM tblattendance
                            INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                            INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                            INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                            where tblattendance.dateTimeTaken >= '$dateTaken' ");

                    if(mysqli_num_rows($ret) > 0 )
                    {
                        while ($row=mysqli_fetch_array($ret)) 
                        { 
                            
                            if($row['status'] == '1'){$status = "Present"; $colour="#00FF00";}else{$status = "Absent";$colour="#FF0000";}
                            echo '  
                            <tr>  
                            <td>'.$cnt.'</td> 
                            <td>'.$firstName= $row['firstName'].'</td> 
                            <td>'.$lastName= $row['lastName'].'</td> 
                            <td>'.$admissionNumber= $row['admissionNumber'].'</td> 
                            <td>'.$className= $row['className'].'</td> 
                            <td>'.$classArmName=$row['classArmName'].'</td>	
                            <td>'.$status=$status.'</td>	 	
                            <td>'.$dateTimeTaken=$row['dateTimeTaken'].'</td>	 					
                            </tr>  
                            ';
                            header("Content-type: application/octet-stream");
                            header("Content-Disposition: attachment; filename=".$filename."-report.xls");
                            header("Pragma: no-cache");
                            header("Expires: 0");
                            $cnt++;
                        }
                    }
                ?>
</table>