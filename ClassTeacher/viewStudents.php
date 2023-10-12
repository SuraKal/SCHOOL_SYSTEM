
<?php 
error_reporting(0);
// include '../Includes/dbcon.php';
// include '../Includes/session.php';
require_once('../Includes/init.php');

        // Query to selct his students in a row 
        $query = "SELECT tblclassteacher.Id,tblclassteacher.emailAddress,tblclassteacher.password,tblclass.className,tblclassarms.classArmName 
        FROM tblclassteacher
        INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
        INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
        Where tblclassteacher.emailAddress = '$_SESSION[emailAddress]' AND tblclassteacher.password = '$_SESSION[password]'";
        $rs = $conn->query($query);
        $num = $rs->num_rows;
        $rrw = $rs->fetch_assoc();

//         // Get the Class batchs for the session 
$classArmArray = $_SESSION['classArmId'];

$delimiter = ',';
$classArmArray = explode($delimiter, $classArmArray);
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
            <h1 class="h3 mb-0 text-gray-800">All Student</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Student in Class</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Input Group -->
            <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Student In Class</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone number</th>
                        <th>Class</th>
                        <th>Batch</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Prepare a placeholder for the classArmIds
                          $placeholders = implode(',', array_fill(0, count($classArmArray), '?'));

                          // Prepare the query with parameterized statements
                          $query = "SELECT tblstudents.firstName, tblstudents.lastName, tblstudents.classId, tblstudents.stuPhone,tblstudents.classArmId, tblclass.className, tblclassarms.classArmName, tblclassarms.Id AS classArmId
                                    FROM tblstudents
                                    INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                                    INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                                    WHERE tblstudents.classArmId IN ($placeholders)";

                          // Prepare the statement
                          $stmt = $conn->prepare($query);

                          if ($stmt) {
                              // Bind the classArmIds as parameters
                              $stmt->bind_param(str_repeat('i', count($classArmArray)), ...$classArmArray);

                              // Execute the statement
                              $stmt->execute();

                              // Get the result set
                              $result = $stmt->get_result();

                              if ($result->num_rows > 0) {
                                  $sn = 0; // Initialize the $sn variable

                                  while ($row = $result->fetch_assoc()) {
                                      $sn++;
                                      echo "
                                          <tr>
                                              <td>".$sn."</td>
                                              <td>".$row['firstName']."</td>
                                              <td>".$row['lastName']."</td>
                                              <td>".$row['stuPhone']."</td>
                                              <td>".$row['className']."</td>
                                              <td>".$row['classArmName']."</td>
                                          </tr>";
                                  }
                              }

                              // Close the result set and statement
                              $result->close();
                              $stmt->close();
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