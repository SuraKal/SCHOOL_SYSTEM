
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once('../Includes/init.php');

//Select Id,classArmId from all teachers 
//Explode there classArmId 
//Loop thorugh the classArmId array and find class Arm Id that is equal to the SESSION['classArmId']


        $classArmId = $_SESSION['classArmId'];
        $teacherId = getTeacherId($classArmId); //Returns the Id of the teacher
// echo $teacherId;
        //Fetchs the students admission number
        $query2 = "SELECT tblstudents.Id,tblstudents.admissionNumber 
        FROM tblstudents
        Where tblstudents.Id = '$_SESSION[userId]'";
        $rss = $conn->query($query2);
        $numm = $rss->num_rows;
        $rrww = $rss->fetch_assoc();

//------------------------SAVE--------------------------------------------------
 //This sends the report to the classes teacher
  if(isset($_POST['sendToInst'])){

    try{
    $issueTittle=$_POST['issueTittle'];
    $issueDis=$_POST['issueDis'];
    $recommond=$_POST['recommond'];
    $classId = $_SESSION['classId'];
    $classArmId = $_SESSION['classArmId'];
    $student = $rrww['admissionNumber'];
    $dateCreated = date("Y-m-d");

    $sql = "INSERT INTO tblreport (classId, classArmId, issueTittle, issueDis, recommond,status,staff,teacherId,student,dateCreated)
                          VALUES ('$classId', '$classArmId', '$issueTittle', '$issueDis', '$recommond', '0','2' ,'$teacherId','$student','$dateCreated')";
                    if ($conn->query($sql) === TRUE) {
                    // Success message
                      $status_message = "<div class='alert alert-success' style='margin-right:700px;'>Reported Successfully!</div>";

                } else {
                    // Error message
                    $status_message = "<div class='alert alert-success' style='margin-right:700px;'>Reported Error </div>";

                    
                }
      }catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
  }
  //
  //This sends the report to the acadamy 
    if(isset($_POST['sendToAca'])){

        try{

            $issueTittle=$_POST['issueTittle'];
            $issueDis=$_POST['issueDis'];
            $recommond=$_POST['recommond'];
            $classId = $_SESSION['classId'];
            $classArmId = $_SESSION['classArmId'];
            $student = $rrww['admissionNumber'];
            $dateCreated = date("Y-m-d");

            $sql = "INSERT INTO tblreport (classId, classArmId, issueTittle, issueDis, recommond,status,staff,teacherId,student,dateCreated)
            VALUES ('$classId', '$classArmId', '$issueTittle', '$issueDis', '$recommond', '0','3','$teacherId','$student','$dateCreated')";
            if ($conn->query($sql) === TRUE) {
              // Success message
                  $status_message = "<div class='alert alert-success' style='margin-right:700px;'>Reported Successfully!</div>";
                  
            } else {
                // Error message
                  $status_message = "<div class='alert alert-success' style='margin-right:700px;'>Reported Error</div>";
                            
              }
        }catch (\Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
      
    }
  //
  //Where status 
          //0 means onProgress , 1 means on handled
  //Where staff 
          //2 means sends it to teacher, 3 means sends it to the acadamy 
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
  <link rel="stylesheet" href="../css/custom.css">
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
            <h1 class="h3 mb-0 text-gray-800">Report</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Make a report</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Make a Report</h6>
                    <div id="status_message"><?php echo $status_message; ?></div>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                        <!-- Fill the Report info  -->
                        <div class="col-xl-6">
                          <label class="form-control-label">Report about<span class="text-danger ml-2">*</span></label>
                            <input type="text" class="form-control" required name="issueTittle" id="exampleInputFirstName">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">What is your report ?<span style="color:rgb(210, 218, 218);"> /max-200 characters</span></label>
                            <textarea id="exampleInputFirstName" name="issueDis" rows="4" cols="50" maxlength="150" class= "form-control" required>
                            </textarea>
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">What do you suggest ? <span style="color:rgb(210, 218, 218);"> /max-200 characters</span></label>
                            <textarea id="exampleInputFirstName" name="recommond" rows="4" cols="50" maxlength="150" class= "form-control">
                              
                            </textarea>
                        </div>
                          
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 col-xl-3"><button type="submit" name="sendToInst" class="btn btn-primary">Send to Instructor</button></div>
                        <div class="col-12 col-xl-8"><button type="submit" name="sendToAca" class="btn btn-primary">Send to Acadamey</button></div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- END/Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">All Reports made</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover table_width">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Reported On</th>
                            <th>Report discription</th>
                            <th>Report suggestion</th>
                            <th>Date reported</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                              $query = "SELECT *
                                FROM tblreport
                                INNER JOIN tblstudents ON tblreport.student = tblstudents.admissionNumber
                                WHERE tblstudents.Id = '$_SESSION[userId]'";
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
                                        <td>".$rows['issueTittle']."</td>
                                        <td>".$rows['issueDis']."</td>
                                        <td>".$rows['recommond']."</td>
                                        <td>".$rows['dateCreated']."</td>
                                        <td>".$status."</td>
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
  <script src="../js/script.js"></script>
  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>