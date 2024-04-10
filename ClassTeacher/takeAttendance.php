<?php 
error_reporting(0);
// include '../Includes/dbcon.php';
// include '../Includes/session.php';
require_once('../Includes/init.php');


if(isset($_SESSION['alredyTaken'])){
  $statusMsg = "<div class='alert alert-danger w-50'  id='status_message'>Attendance Taken for the day</div>";
  unset($_SESSION['alredyTaken']);
}

if(isset($_SESSION['sucess'])){
  $statusMsg = "<div class='alert alert-success w-50' id='status_message'>Attendance Taken</div>";
  unset($_SESSION['sucess']);
}

if(isset($_SESSION['tryAgain'])){
  $statusMsg = "<div class='alert alert-danger w-50'  id='status_message'>Please Try again later!</div>";
  unset($_SESSION['tryAgain']);
}
if(isset($_SESSION['fail'])){
  // $statusMsg = "<div class='alert alert-danger w-50'  id='status_message'>Please Try again later!</div>"; //If this happens check the function takeAttendance
  $statusMsg = $_SESSION['fail']; //If this happens check the function takeAttendance
  // unset($_SESSION['fail']);
}

    // $query = "SELECT tblclass.className,tblclassarms.classArmName 
    // FROM tblclassteacher
    // INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    // INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    // Where tblclassteacher.Id = '$_SESSION[userId]'";
    // $rs = $conn->query($query);
    // $num = $rs->num_rows;
    // $rrw = $rs->fetch_assoc();


// //Following is which enables for the attendance to be taken 
// //session and Term 
//         // get the list of class arms for the current class

// $qry = mysqli_query($conn, "SELECT Id FROM tblclassarms WHERE classId = '$_SESSION[classId]'");
// $classArmIds = array();
// while ($rw = mysqli_fetch_array($qry)) {
//     $classArmIds[] = $rw["Id"]; //array of batch Id for the class 
// }


// foreach ($classArmIds as $classArmId) {

//     // get the session term ID and date for the attendance record
//     $querey=mysqli_query($conn,"select * from tblsessionterm where isActive ='1'");
//     $rwws=mysqli_fetch_array($querey);
//     $sessionTermId = $rwws['Id'];
//     $dateTaken = date("Y-m-d");

//     // check if attendance has already been taken for the current class arm and date
//     $qurty=mysqli_query($conn,"select * from tblattendance where classId = '$_SESSION[classId]' AND classArmId = '$classArmId' and dateTimeTaken='$dateTaken'");
//     $count = mysqli_num_rows($qurty);

//     if($count == 0) { // if attendance record does not exist, insert new record

//         // insert attendance record for each student in the current class arm
//         $qus=mysqli_query($conn,"select * from tblstudents where classId = '$_SESSION[classId]' AND classArmId = '$classArmId'");
//         while ($ros = $qus->fetch_assoc()) {
//             $qquery=mysqli_query($conn,"insert into tblattendance(admissionNo,classId,classArmId,sessionTermId,status,dateTimeTaken) 
//             value('$ros[admissionNumber]','$_SESSION[classId]','$classArmId','$sessionTermId','0','$dateTaken')");
//         }
//     }



    
//             if (isset($_POST['save'])) {
//             $admissionNo = $_POST['admissionNo'];
//             $check = $_POST['check'];
//             $N = count($admissionNo);
//             $status = "";

//             // check if attendance has already been taken for the current class arm and date
//             $qurty = mysqli_query($conn, "SELECT * FROM tblattendance WHERE classId = '$_SESSION[classId]' AND classArmId = '$classArmId' AND dateTimeTaken = '$dateTaken' AND status = '1'");
//             $count = mysqli_num_rows($qurty);

//             if ($count > 0) {
//                 $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Attendance has been taken for today!</div>";
//             } else {
//                 // insert new attendance records
//                 for ($i = 0; $i < $N; $i++) {
//                     $admissionNo[$i]; // admission Number

//                     // Determine the status value based on checkbox state
//                     $statusValue = isset($check[$i]) ? '1' : '0';

//                     $qquery = mysqli_query($conn, "INSERT INTO tblattendance (admissionNo, status) VALUES ('$check[$i]', '$statusValue')");

//                     if ($qquery) {
//                         $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Attendance Taken Successfully!</div>";
//                     } else {
//                         $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
//                     }
//                 }
//             }
//           }
// }



$currentDate = date('Y-m-d');

if (isset($_POST['save'])) {
  $check = $_POST['check']; //Contains list of students addmission number that are present 

  $classArmId = $_POST['classArmIdSelected']; //Contains the specific batch identification 
  $studentInBatch = getStudentsByClassArmId($classArmId); //Gets all students in the batch with classId , classArmId ,and admission number 
  if(empty($check)){
    $check = array();
    // print("<pre>");
    // print_r($check);
  }
  foreach ($studentInBatch as $value){ //Loop thorugh each student in the batch 
    $studentAddmission_Number = $value['admissionNumber']; //addmission number of that a student from the batch
    $classId = $value['classId'];
    $classArmId = $value['classArmId'];

    if (!in_array($studentAddmission_Number, $check, true)) { //If the student from the batch is not in the array of check it means it is not selected , which also means he/she is not present  
      $status = '0';
    }else{
      $status = '1';
    }

    takeAttendance($studentAddmission_Number, $classId, $classArmId, $status, $currentDate);

  }

}


// $difference = 04:10:30.000000 - 04:10:52.000000





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
  <style>
        #check{
        width: 40%;
        height: calc(1.5em + 0.75rem + 0px);
        /* padding: 0.375rem 0.75rem; */
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
    }
  </style>


  <script>
    function classArmDropdown(str) {
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
            xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
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
            <h1 class="h3 mb-0 text-gray-800">Take Attendance (Today's Date : <?php echo $todaysDate = date("m-d-Y");?>)</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Student in Class</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Input Group -->
              <!-- Form to be submitted by checking the boxes if the student is present-->
                  <form method="post">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">All Students</h6>
          <h6 class="m-0 font-weight-bold text-danger">Note: <i>Check if present , leave unchecked if absent</i></h6>
        </div>
        <div class="table-responsive p-3">
          <?php echo $statusMsg; ?>

          <!-- Add a dropdown to select the class arm -->
          <div class="form-group">
            <label for="classArmSelect">Select a batch:</label>
            <select name="classArmId" class="form-control" id="classArmSelect">
              <?php
              $classArmArray = $_SESSION['classArmId'];
              $delimiter = ',';
              $classArmArray = explode($delimiter, $classArmArray);

              echo "<option>--Select--</option>";
              // $classArmIds = $_SESSION['classArmIds_' . $_SESSION['emailAddress'] . '_' . $_SESSION['password']];
              foreach ($classArmArray as $classArmId) { //Array of class arm Id collection 
                
                if(!empty(getClassArm($classArmId))){ //If the class arm exists 
                  // Associate class name with it to 
                  $classArmInfo = getClassArm($classArmId); //Select the class Id of the specific batch
                  $classId = $classArmInfo['classId'];  
                  $classQuery = "SELECT className FROM tblclass WHERE Id = '$classId'"; //Use the class arm to get the name of the class 
                  $classResult = $conn->query($classQuery);
                  $className = $classResult->fetch_assoc()['className'];


                  $classArmQuery = "SELECT classArmName FROM tblclassarms WHERE Id = '$classArmId'";
                  $classArmResult = $conn->query($classArmQuery);
                  $classArmName = $classArmResult->fetch_assoc()['classArmName'];
                  echo "<option value='$classArmId' name='classArmId'>$classArmName | $className</option>";
                }
              }
              ?>
            </select>
          </div>

          <!-- Add a button to fetch the list of students for the selected class arm -->
          <button type="submit" name="fetch_students" class="btn btn-primary mb-4">Fetch Students</button>

          <?php
          if (isset($_POST['classArmId'])) {
            // Retrieve the selected class arm ID
            $selectedClassArmId = $_POST['classArmId'];

            if (isset($_POST['fetch_students'])) {
              // Fetch the students for the selected class arm
              $query = "SELECT tblstudents.Id,tblstudents.admissionNumber,tblclass.className,tblclass.Id As classId,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
                        tblstudents.lastName,tblstudents.admissionNumber,tblstudents.dateCreated,tblstudents.classArmId
                        FROM tblstudents
                        INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                        INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                        WHERE tblstudents.classArmId = '$selectedClassArmId'";
              $rs = $conn->query($query);
              $num = $rs->num_rows;
              $sn=0;
              if($num > 0)
              { 
                // Display the table of students for the selected class arm
                // Retrieve the data with the highest ID
                $sql = "SELECT * FROM tblattendance WHERE classArmId = '$selectedClassArmId' ORDER BY Id DESC LIMIT 1";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                  // Fetch the row with the highest ID
                  $row = $result->fetch_assoc();
                  // $lastDateTaken = substr($row['dateTimeTaken'], 0, -7); //The last day the attendance was taken 
                  $lastDateTaken = $row['dateTimeTaken']; //The last day the attendance was taken 
                  if($lastDateTaken == $currentDate){
                    echo '<div class="card p-3 border h5">Attendance for today is taken | The last attendance was taken on ' .$lastDateTaken. '</div>';
                  }else{
                    echo '<div class="card p-3 border h5">The last attendance was taken on ' .$lastDateTaken. '</div>';
                  }
                }
                
                echo '<table class="table align-items-center table-flush table-hover">';
                echo '<thead class="thead-light">';
                echo '<tr>';
                echo '<th>#</th>';
                echo '<th>First Name</th>';
                echo '<th>Last Name</th>';
                echo '<th>Class</th>';
                echo '<th>Batch</th>';
                echo '<th>Check</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($rows = $rs->fetch_assoc())
                {
                  $sn = $sn + 1;
                  echo"

                    <tr>
                      <td>".$sn."</td>
                      <td>".$rows['firstName']."</td>
                      <td>".$rows['lastName']."</td>
                      <td>".$rows['className']."</td>
                      <td>".$rows['classArmName']."</td>
                      <td><input name='check[]' type='checkbox' id='check' value=".$rows['admissionNumber']." class='form-control'></td>
                    </tr>";
                  echo "<input name='classArmIdSelected' value=".$rows['classArmId']." type='hidden' class='form-control'>";
                }
                echo '</tbody>';
                echo '</table>';

                // Display the button to take attendance
                echo '<button type="submit" name="save" class="btn btn-primary">Take Attendance</button>';
              }
              else
              {
                echo   
                "<div class='alert alert-danger' role='alert'>
                  No Students Found!
                </div>";
              }
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</form>
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