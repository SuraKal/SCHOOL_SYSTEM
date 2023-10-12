
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <script>
    function typeDropDown(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxCallTypes.php?tid="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
       <?php include "Includes/topbar.php";?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Class Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Class Attendance</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">View Class Attendance</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                        <div>
                        
                        <?php
                        $qry= "SELECT * FROM tblstudents where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' ORDER BY firstName ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          
                          
                         
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                        <div class="col-xl-6">
                        <label class="form-control-label">Type<span class="text-danger ml-2">*</span></label>
                          <select required name="type" onchange="typeDropDown(this.value)" class="form-control mb-3">
                          <option value="">--Select--</option>
                          <option value="1" >All</option>
                          <option value="2" >By Single Date</option>
                          <option value="3" >By Date Range</option>
                        </select>
                        </div>
                    </div>
                      <?php
                        echo"<div id='txtHint'></div>";
                      ?>
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
              <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Class Attendance</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                   
                    <tbody>

                  <?php

                  if(isset($_POST['view'])){

                       $admissionNumber =  $_POST['admissionNumber'];
                       $type =  $_POST['type'];

                      if($type == "1"){ //All Attendance

                          $query = "SELECT tblattendance.Id,COUNT(CASE WHEN tblattendance.status = '1' THEN 1 END) AS Status1 ,COUNT(CASE WHEN tblattendance.status = '0' THEN 1 END) AS Status0, tblattendance.dateTimeTaken,
                          tblstudents.firstName,tblstudents.lastName,tblstudents.admissionNumber,tblclass.className,
                          tblclassarms.classArmName, tblattendance.status
                          FROM tblattendance
                          INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                          INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                          INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo 
                          GROUP BY tblstudents.firstName,tblstudents.lastName
                          ";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn=0;
                          $status="";
                          if($num > 0)
                          { 
                            while ($rows = $rs->fetch_assoc())
                              {
                                  if($rows['status'] == '1'){$status = "Present"; $colour="#00FF00";}else{$status = "Absent";$colour="#FF0000";}
                                $sn = $sn + 1;
                                echo"
                                  <tr>
                                    <td>".$sn."</td>
                                    <td>".$rows['firstName']."</td>
                                    <td>".$rows['lastName']."</td>
                                    <td>".$rows['admissionNumber']."</td>
                                    <td>".$rows['className']."</td>
                                    <td>".$rows['classArmName']."</td>
                                    <td>---</td>
                                    <td style='background-color:white;".$colour."'>".$rows['Status1']."</td>
                                    <td style='background-color:white;".$colour."'>".$rows['Status0']."</td>
                                    <td>".$rows['dateTimeTaken']."</td>
                                  </tr>";
                              }
                          }
                          else
                          {
                              echo   
                              "<div class='alert alert-danger' role='alert'>
                                No Record Found!
                                </div>";
                          }

                      }


                      if($type == "2"){ //Single Date Attendance
                                    $singleDate =  $_POST['singleDate'];

                                    $cnt=1;			
                                    $ret = mysqli_query($conn,"SELECT *
                                            FROM tblattendance
                                            INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                                            INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                                            INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                                            where DATE(tblattendance.dateTimeTaken) = '$singleDate' ");
                                            $sn=0;

                                    if(mysqli_num_rows($ret) > 0 )
                                    {
                                        while ($row=mysqli_fetch_array($ret)) 
                                        { 
                                            
                                            if($row['status'] == '1'){$status = "Present"; $colour="#00FF00";}else{$status = "Absent";$colour="#FF0000";}
                                            $sn = $sn + 1;

                                            echo '  
                                            <tr>  
                                            <td>'.$sn.'</td> 
                                            <td>'.$firstName= $row['firstName'].'</td> 
                                            <td>'.$lastName= $row['lastName'].'</td> 
                                            
                                            <td>'.$admissionNumber= $row['admissionNumber'].'</td> 
                                            <td>'.$className= $row['className'].'</td> 
                                            <td>'.$classArmName=$row['classArmName'].'</td>	
                                            
                                            <td>'.$status=$status.'</td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>'.$dateTimeTaken=$row['dateTimeTaken'].'</td>	 					
                                            </tr>  
                                            ';
                                        }

                                  }

                      }
                      if($type == "3"){ //Date Range Attendance

                              $fromDate =  $_POST['fromDate'];
                              $toDate =  $_POST['toDate'];
                         

                              $cnt=1;			
                              $ret = mysqli_query($conn,"SELECT *
                                      FROM tblattendance
                                      INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                                      INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                                      
                                      INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                                      where tblattendance.dateTimeTaken between '$fromDate' and '$toDate'  ");
                                      $sn=0;

                              if(mysqli_num_rows($ret) > 0 )
                              {
                                while ($row=mysqli_fetch_array($ret)) 
                                { 
                                    
                                    if($row['status'] == '1'){$status = "Present"; $colour="#00FF00";}else{$status = "Absent";$colour="#FF0000";}
                                    $sn = $sn + 1;
                                    echo '  
                                    <tr>  
                                    <td>'.$sn.'</td> 
                                    <td>'.$firstName= $row['firstName'].'</td> 
                                    <td>'.$lastName= $row['lastName'].'</td> 

                                    <td>'.$admissionNumber= $row['admissionNumber'].'</td> 
                                    <td>'.$className= $row['className'].'</td> 
                                    <td>'.$classArmName=$row['classArmName'].'</td>	
                                    <td>'.$status=$status.'</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>'.$dateTimeTaken=$row['dateTimeTaken'].'</td>	 					
                                    </tr>  
                                    ';
                                }
                              }








                        //  $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblclass.className,
                        // tblclassarms.classArmName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        // tblstudents.firstName,tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber
                        // FROM tblattendance
                        // INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                        // INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                        // INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        // INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        // INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                        // where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.admissionNo = '$admissionNumber' and tblattendance.classId = '$_SESSION[classId]' and tblattendance.classArmId = '$_SESSION[classArmId]'";
                        
                      }

                      
                  }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>
          </div>
          <!--Row-->

          <!-- Documentation Link -->
          <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>For more documentations you can visit<a href="https://getbootstrap.com/docs/4.3/components/forms/"
                  target="_blank">
                  bootstrap forms documentations.</a> and <a
                  href="https://getbootstrap.com/docs/4.3/components/input-group/" target="_blank">bootstrap input
                  groups documentations</a></p>
            </div>
          </div> -->

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
       <?php include "Includes/footer.php";?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
   <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>