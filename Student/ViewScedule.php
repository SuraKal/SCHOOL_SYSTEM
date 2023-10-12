
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once ('../Includes/init.php');

      // Start session
      $query = "SELECT tblclass.className, tblclassarms.classArmName, tblstudents.classId, tblstudents.classArmId
                FROM tblstudents
                INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                WHERE tblstudents.Id = '$_SESSION[userId]'";

      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rrw = $rs->fetch_assoc();

      // Retrieve classId and classArmId from the result set
      $classId = $rrw['classId'];
      $classArmId = $rrw['classArmId'];


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
  <link rel="stylesheet" href="../css/custom.css">
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
            <h1 class="h3 mb-0 text-gray-800">View Schedules</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Schedule Info</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card-body mt-2 border-top">
                  <form method="post">
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Which day<span class="text-danger ml-2">*</span></label>
                          <select required name="type" onchange="typeDropDown(this.value)" class="form-control mb-3">
                          <option value="">--Select--</option>
                          <option value="4">All Program Schedule</option>
                          <option value="5" >This Weeks Schedule</option>
                          <option value="6" >This Month Schedule</option>
                        </select>
                        </div>
                    </div>
                      <?php
                        echo"<div id='txtHint'></div>";
                      ?>
                    <button type="submit" name="Take" class="btn btn-primary">Show</button>
                  </form>
              </div>
              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Class scheudle</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover table_width">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Tittle</th>
                            <th>Dis.pt</th>
                            <th>Refer_link</th>
                            <th>Starts at</th>
                            <th>Ends at</th>
                            <th>Download your Note</th>
                          </tr>
                        </thead>
                        <tbody>
                    <?php
                      if(isset($_POST['Take'])){
                          $type =  $_POST['type']; //Which type does the student choose
                          if($type == "4"){
                            //All sechedule
                              $query = "SELECT tblschedules.date,tblschedules.title,tblschedules.description,tblschedules.Reference,tblschedules.timeFrom,tblschedules.timeTo,tblschedules.Doc
                              FROM tblschedules
                              
                              INNER JOIN tblstudents
                              ON tblschedules.classId = tblstudents.classId AND tblschedules.classArmId = tblstudents.classArmId
                              where tblstudents.Id = '$_SESSION[userId]'
                                ";
                              $rs = $conn->query($query);
                                  $num = $rs->num_rows;
                                  $sn=0;
                                  $status="";
                                  if($num > 0)
                                  { 
                                    while ($rows = $rs->fetch_assoc())
                                      {
                                          
                                        $sn = $sn + 1;
                                        echo"
                                          <tr>
                                            <td>".$sn."</td>
                                            <td>".$rows['date']."</td>
                                            <td>".$rows['title']."</td>
                                            <td>".$rows['description']."</td>
                                            <td>".$rows['Reference']."</td>
                                            <td>".$rows['timeFrom']."</td>
                                            <td>".$rows['timeTo']."</td>
                                            <td>";
                                            // Check if the Doc file exists
                                            if (file_exists($rows['Doc'])) {
                                                // Output a download link for the file
                                                echo "<a href='download.php?file_path=".urlencode($rows['Doc'])."'><i class='fas fa-fw fa-download'></i></a>";
                                            }else{
                                              echo "<a class='btn-light p-1' disabled>No Note</a>";
                                            }
                                            
                                            echo "</td>
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
                              if($type == "5"){
                            // This week 
                              $query = "SELECT tblschedules.date,tblschedules.title,tblschedules.description,tblschedules.Reference,tblschedules.timeFrom,tblschedules.timeTo,tblschedules.Doc
                              FROM tblschedules
                              INNER JOIN tblstudents
                              ON tblschedules.classId = tblstudents.classId AND tblschedules.classArmId = tblstudents.classArmId
                              where tblstudents.Id = '$_SESSION[userId]' AND WEEK(tblschedules.date) = WEEK(NOW())
                                  ";
                              $rs = $conn->query($query);
                                  $num = $rs->num_rows;
                                  $sn=0;
                                  $status="";
                                  if($num > 0)
                                  { 
                                    while ($rows = $rs->fetch_assoc())
                                      {
                                          
                                        $sn = $sn + 1;
                                        echo"
                                          <tr>
                                            <td>".$sn."</td>
                                            <td>".$rows['date']."</td>
                                            <td>".$rows['title']."</td>
                                            <td>".$rows['description']."</td>
                                            <td>".$rows['Reference']."</td>
                                            <td>".$rows['timeFrom']."</td>
                                            <td>".$rows['timeTo']."</td>
                                            <td>";
                                            // Check if the Doc file exists
                                            if (file_exists($rows['Doc'])) {
                                                // Output a download link for the file
                                                echo "<a href='download.php?file_path=".urlencode($rows['Doc'])."'><i class='fas fa-fw fa-download'></i></a>";
                                            }
                                            
                                            echo "</td>
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
                              if($type == "6"){
                            //This month
                                $query = "SELECT tblschedules.date,tblschedules.title,tblschedules.description,tblschedules.Reference,tblschedules.timeFrom,tblschedules.timeTo,tblschedules.timeTo,tblschedules.Doc
                                FROM tblschedules
                                INNER JOIN tblstudents
                                ON tblschedules.classId = tblstudents.classId AND tblschedules.classArmId = tblstudents.classArmId
                                where tblstudents.Id = '$_SESSION[userId]' AND MONTH(tblschedules.date) = MONTH(NOW()) AND YEAR(tblschedules.date) = YEAR(NOW())
                                  ";
                                $rs = $conn->query($query);
                                    $num = $rs->num_rows;
                                    $sn=0;
                                    $status="";
                                    if($num > 0)
                                    { 
                                      while ($rows = $rs->fetch_assoc())
                                        {
                                            
                                          $sn = $sn + 1;
                                          echo"
                                            <tr>
                                              <td>".$sn."</td>
                                              <td>".$rows['date']."</td>
                                              <td>".$rows['title']."</td>
                                              <td>".$rows['description']."</td>
                                              <td>".$rows['Reference']."</td>
                                              <td>".$rows['timeFrom']."</td>
                                              <td>".$rows['timeTo']."</td>
                                              <td>";
                                              // Check if the Doc file exists
                                              if (file_exists($rows['Doc'])) {
                                                  // Output a download link for the file
                                                  echo "<a href='download.php?file_path=".urlencode($rows['Doc'])."'><i class='fas fa-fw fa-download'></i></a>";
                                              } 
                                              
                                              echo "</td>
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
  <!-- scripts used -->
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