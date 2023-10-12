
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once('../Includes/init.php');

$current_page = basename($_SERVER['PHP_SELF']);

//Fetchs the teachers information
        $query = "SELECT *
        FROM tblclassteacher
        Where tblclassteacher.emailAddress = '$_SESSION[emailAddress]' AND tblclassteacher.password = '$_SESSION[password]'";
        $rs = $conn->query($query);
        $num = $rs->num_rows;
        $rrw = $rs->fetch_assoc();  


  // ***********To mark the report to handling ***************************//
  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
    {
          $Id= $_GET['Id'];
          handleReport($Id, $current_page);

                // $query=mysqli_query($conn,"update tblreport set status='1'
                // where Id='$Id'");
                //         if ($query) {
                //             echo "<script type = \"text/javascript\">
                //             window.location = (\"ManageReport.php\")
                //             </script>"; 
                //         }
                //         else
                //         {
                //             $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
                //         }
    }
//--------------------------------EndMarking------------------------------------------------------------------

// *******************Delete a report*********************************/

  if (isset($_GET['Id']) && isset($_GET['classArmId']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['Id'];
        $classArmId= $_GET['classArmId'];

        $query = mysqli_query($conn,"DELETE FROM tblreport WHERE Id='$Id'");
          if ($query == TRUE) {
                  header('Location: ManageReport.php');
                  exit;

          }else{
              $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
          }
      
  }
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
<?php include 'includes/title.php';?>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

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
            <h1 class="h3 mb-0 text-gray-800">Manage Reports</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Reports</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Reports list</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Class</th>
                            <th>Batch</th>
                            <th>Issue On</th>
                            <th>Issue discr.</th>
                            <th>Suggusts</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          //Selects his reports
                              $query = "SELECT tblreport.Id,tblreport.classId,tblreport.classArmId,tblreport.issueTittle,tblreport.issueDis,tblreport.recommond,tblreport.status,tblreport.staff,tblreport.teacherId,tblreport.student,tblreport.dateCreated,tblclass.className,tblclassarms.classArmName,tblreport.pass 
                              FROM tblreport
                              INNER JOIN tblclass ON tblclass.Id = tblreport.classId
                              INNER JOIN tblclassarms ON tblclassarms.Id = tblreport.classArmId
                              WHERE tblreport.teacherId = '$_SESSION[emailAddress]' AND tblreport.pass = '$_SESSION[password]' AND tblreport.staff = '2'";
                              $rs = $conn->query($query);
                              $num = $rs->num_rows;
                              $sn=0;
                              $status="";
                              if($num > 0)
                              { 
                                while ($rows = $rs->fetch_assoc())
                                  {
                                    if($rows['status'] == '0'){$status = "On-Progress";}else{$status = "Handling";}
                                    $sn = $sn + 1;
                                    
                                    echo"
                                      <tr>
                                        <td>".$sn."</td>
                                        <td>".$rows['className']."</td>
                                        <td>".$rows['classArmName']."</td>
                                        <td>".$rows['issueTittle']."</td>
                                        <td>".$rows['issueDis']."</td>
                                        <td>".$rows['recommond']."</td>
                                        <td>".$status."</td>
                                        <td><a href='?action=mark&Id=".$rows['Id']."'>Handle</a></td> 
                                        <td><a href='?action=delete&Id=".$rows['Id']."&classArmId=".$rows['classArmId']."'><i class='fas fa-fw fa-trash'></i></a></td>
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