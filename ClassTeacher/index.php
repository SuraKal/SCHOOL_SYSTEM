
<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once('../Includes/init.php');


// Get the Class batchs for the session 
$classArmArray = $_SESSION['classArmId'];

$delimiter = ',';
$classArmArray = explode($delimiter, $classArmArray);


// // After Retrieving the classArmIds array for the current user from the session variable
//             // Initialize a variable to store the total number of value for the user
            $totalStudents = 0;
            $totAttendance = 0;
            $numClassArms = 0;
            $totalClass = array();
            $totalClassNumber = 0;
            $classId = '';
            // Loop through each classArmId for the user and retrieve the number of different values for the dashboard
            // The array contains all the class arms of that specifc teacher
            foreach ($classArmArray as $classArmId) {
                  if(!empty($classArmId)){
                    $classArmInfo = getClassArm($classArmId); //Select the class Id of the specific batch
                    if(!empty($classArmInfo)){ //Check if it is not empty 
                      $classId = $classArmInfo['classId']; 

                      // print("<pre>");
                      // print_r($classArmInfo);

                      

                      // Total student
                      $queryStudent=mysqli_query($conn,"SELECT * from tblstudents where classId = '$classId' AND classArmId = '$classArmId'");                       
                      $students = mysqli_num_rows($queryStudent);
                      $totalStudents += $students;

                      //Total attendance 
                      $queryAttendance=mysqli_query($conn,"SELECT * from tblattendance where classId = '$classId' AND classArmId = '$classArmId'");                       
                      $Attendance = mysqli_num_rows($queryAttendance);
                      $totAttendance += $Attendance;

                      // Total Batchs 

                      $numClassArms = $numClassArms + 1;
                      
                      //Total class

                      if (!in_array($classId, $totalClass, true)) {
                        $totalClass[] = $classId;
                      }

                    }
                  }            
              }
$classCountTotal = count($totalClass);

        //       $totalClassLength = count($totalClass);
        // for ($i = 0; $i < $totalClassLength; $i++){

        //   $totalClassNumber = $totalClassNumber + 1;
        // }

// print("<pre>");
// print_r($totalClass);


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
  <title>Ennlite|Teacher|Dashboard</title>
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
            <h1 class="h3 mb-0 text-gray-800">Class Teacher Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>
          <div class="row mb-3">
          <?php 
            
          ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Students</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $totalStudents;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- View Total student attendance -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Student Attendance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totAttendance;?></div>

                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Class -->
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Class</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $classCountTotal;?></div>

                        </div>
                        <div class="col-auto">
                          <!-- <i class="fas fa-calendar fa-2x text-warning"></i> -->
                          <i class="fas fa-chalkboard fa-2x text-info"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
            <!-- Batchs-->
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Batchs</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $numClassArms;?></div>

                        </div>
                        <div class="col-auto">
                          <i class="fas fa-code-branch fa-2x text-primary"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

            
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <?php include 'includes/footer.php';?>
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
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>