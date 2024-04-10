
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once ('../Includes/init.php');

//------------------------SAVE--------------------------------------------------

  if(isset($_POST['save'])){
      $firstName = input_cleaner($_POST['firstName']);
      $lastName = input_cleaner($_POST['lastName']);
      $email = input_cleaner($_POST['email']);
      $stuPhone = input_cleaner($_POST['stuPhone']);

      $classId = input_cleaner($_POST['classId']);
      $classArmId = input_cleaner($_POST['classArmId']);

      $dateCreated = date("Y-m-d");
          //for mail
      $classInfo = getClass($classId);
      $className = $classInfo['className'];

      $classArmInfo = getClassArm($classArmId);
      $classArmName = $classArmInfo['classArmName'];

      $getTeacher = getTeacher($classId, $classArmId);
      $instructor = $getTeacher['firstName']. " " .$getTeacher['lastName'];

      //Studnet profile
      $name = $_FILES['img']['name'];
      $size = $_FILES['img']['size'];
      $type = $_FILES['img']['type'];
      $file_temp = $_FILES['img']['tmp_name'];
      $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($name, PATHINFO_EXTENSION);
      $file_path = '../Photo/' . $unique_name;
      move_uploaded_file($file_temp, $file_path);
      //
      $qry = "SELECT className FROM tblclass WHERE Id = $classId";
      $result = $conn->query($qry);
      $row = $result->fetch_assoc();
      $className = $row['className'];
      // generate admission number
      $randomNumber = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
      $year = date("y");
      $admissionNumber = strtoupper(substr($className, 0, 2)) . '/' . $randomNumber . '/' . $year;
      // check if admission number already exists
      $query=mysqli_query($conn,"SELECT * FROM tblstudents WHERE admissionNumber ='$admissionNumber'");
      $ret=mysqli_fetch_array($query);

      if($ret > 0){ 
          $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This admissionNumber Already Exists!</div>";
      }
      else{
          // insert student record with admission number
          $query=mysqli_query($conn,"INSERT INTO tblstudents(firstName,lastName,email,admissionNumber,password,stuPhone,classId,classArmId,dateCreated,stuProfile) 
          VALUES('$firstName','$lastName','$email','$admissionNumber','12345','$stuPhone','$classId','$classArmId','$dateCreated','$file_path')");
          if ($query) {

            // Mail student about there registration 

              // $user = "Student";
              // if(isset($user)&&isset($firstName)&&isset($lastName)&&isset($admissionNumber)&&isset($className)&&isset($classArmName)&&isset($instructor)&&isset($file_path)&&isset($dateCreated)&&isset($email)){
              //   mailStudent($user,$firstName,$lastName,$admissionNumber,$className,$classArmName,$instructor,$file_path,$dateCreated,$email);
              // }else{
              //   header('Location: index.php');
              //   exit;
              // }
              
              $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
              if (extension_loaded('gd')) {
                generateIdCard($admissionNumber); //Id card is generated when registreting student
              }
          }
          else {
              $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
          }
      }
  }
  //---------------------------------------End-SAVE-------------------------------------------------------------
  //---------------------------------------EDIT-------------------------------------------------------------
  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
      $Id = input_cleaner($_GET['Id']);
      // Fetch the student record from the database
      $query = mysqli_query($conn, "SELECT * FROM tblstudents WHERE Id = '$Id'");
      $row = mysqli_fetch_array($query);
      // Handle form submission
      if (isset($_POST['update'])) {
          $firstName = input_cleaner($_POST['firstName']);
          $lastName = input_cleaner($_POST['lastName']);
          $email = input_cleaner($_POST['email']);
          $stuPhone = input_cleaner($_POST['stuPhone']);

          $classId = input_cleaner($_POST['classId']);
          $classArmId = input_cleaner($_POST['classArmId']);
          $dateCreated = date("Y-m-d");
          //
          //Studnet profile
          $name = $_FILES['img']['name'];
          $size = $_FILES['img']['size'];
          $type = $_FILES['img']['type'];
          $file_temp = $_FILES['img']['tmp_name'];
          $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($name, PATHINFO_EXTENSION);
          $file_path = '../Photo/' . $unique_name;
          move_uploaded_file($file_temp, $file_path);
          // profile end
          //
          
          $qry = "SELECT className FROM tblclass WHERE Id = $classId";
          $result = $conn->query($qry);
          $row = $result->fetch_assoc();
          $className = $row['className'];
          // generate admission number
          $randomNumber = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
          $year = date("y");
          $admissionNumber = strtoupper(substr($className, 0, 2)) . '/' . $randomNumber . '/' . $year;

              // Check if the new admission number is already in use by another student
              $query = mysqli_query($conn, "SELECT Id FROM tblstudents WHERE admissionNumber = '$admissionNumber' AND Id = '$Id'");
              if (mysqli_num_rows($query) > 0) {
                  $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Admission number already inuse by another student!</div>";
              } else {
                  // Update the student record in the database
                  $query = mysqli_query($conn, "UPDATE tblstudents SET firstName = '$firstName', lastName = '$lastName', admissionNumber = '$admissionNumber', password = '12345', classId = '$classId',email = '$email' ,stuPhone = '$stuPhone',classArmId = '$classArmId', dateCreated = '$dateCreated',stuProfile='$file_path' WHERE Id = '$Id'");
                    if ($query) {
                      $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Registered sucessfully</div>";
                        // Redirect to the student list page on success
                      header('Location:createStudents.php');
                      exit;
                    } else {
                        // Display an error message on failure
                        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Regsitration failed! Please try again later</div>";
                        header('Location:createStudents.php');
                        exit;
                    }
              }
      }
  }
  //---------------------------------------END-EDIT-------------------------------------------------------------
  //--------------------------------DELETE------------------------------------------------------------------
    if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
      {
          $Id= input_cleaner($_GET['Id']);
          $qry = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
                              tblstudents.lastName,tblstudents.admissionNumber,tblstudents.dateCreated
                              FROM tblstudents
                              INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                              INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId WHERE tblstudents.Id = $Id";
          $result = $conn->query($qry);
          $row = $result->fetch_assoc();

          $className = $row['className'];
          $firstName = $row['firstName'];
          $lastName = $row['lastName'];
          
          $query = mysqli_query($conn,"SELECT Id,stuProfile FROM tblstudents WHERE Id='$Id'");
          $row = mysqli_fetch_array($query);
          $profile_path = $row['stuProfile'];
          $y = '../ID Cards/'.$firstName.' '.$lastName.'_'.$className.'.pdf';
          $z = '../Certeficate/'.$firstName.' '.$lastName.'-'.$className.'.pdf';
          $a = '../ID Cards/'.$firstName.' '.$lastName.'_'.$className.'.jpg';
          $b = '../Certeficate/'.$firstName.' '.$lastName.'-'.$className.'.jpg';

          if(file_exists($y) && file_exists($a)){
            unlink($y);
            unlink($a);
          }
          if(file_exists($z) && file_exists($b)){
            unlink($z);
            unlink($b);
          }
          if(unlink($profile_path)){ 
              $query = mysqli_query($conn,"DELETE FROM tblstudents WHERE Id='$Id'");
              if ($query == TRUE) {
                  header('Location:createStudents.php');
                  exit;
              }
              else{
                  $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
              }
          }
          else{
              $query = mysqli_query($conn,"DELETE FROM tblstudents WHERE Id='$Id'");
              header('Location:createStudents.php');
              exit;
          }
      }

      // if(isset($_POST['generate'])){
      //     generateIdCard('PE/640/23');
      // }

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
  <style>
    .success-message {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  padding: 10px;
  background: green;
  color: white;
  text-align: center;
  font-weight: bold;
  z-index: 9999;
}
.error-message {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  padding: 10px;
  background: red;
  color: white;
  text-align: center;
  font-weight: bold;
  z-index: 9999;
}
  </style>
<!-- Script for classes dropdown -->
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
            <h1 class="h3 mb-0 text-gray-800">Create Students</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Students</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Students</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <!-- This is a form where students are registered, there is also an update and save where the student information is updated for existing student and saved for new students respectively.  -->
                  <form role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">First name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="firstName" value="<?php echo $row['firstName'];?>" id="exampleInputFirstName" required>
                        </div>
                        <div class="col-xl-6">
                            <label class="form-control-label">Last name<span class="text-danger ml-2">*</span></label>
                            <input type="text" class="form-control" name="lastName" value="<?php echo $row['lastName'];?>" id="exampleInputFirstName" required>
                        </div>
                        <div class="col-xl-6">
                            <label class="form-control-label">Email address<span class="text-danger ml-2">*</span></label>
                            <input type="text" class="form-control" name="email" value="<?php echo $row['email'];?>" id="exampleInputFirstName" required>
                        </div>

                        <div class="col-xl-6">
                            <label class="form-control-label">Phone number<span class="text-danger ml-2">*</span></label>
                            <input type="text" class="form-control" name="stuPhone" value="<?php echo $row['stuPhone'];?>" id="exampleInputFirstName" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">Select Class<span class="text-danger ml-2">*</span></label>
                          <?php
                          $qry= "SELECT * FROM tblclass ORDER BY className ASC";
                          $result = $conn->query($qry);
                          $num = $result->num_rows;		
                            if ($num > 0){
                              echo ' <select required name="classId" onchange="classArmDropdown(this.value)" class="form-control mb-3">';
                              echo'<option value="">--Select Class--</option>';
                              while ($rows = $result->fetch_assoc()){
                              echo'<option value="'.$rows['Id'].'" >'.$rows['className'].'</option>';
                                  }
                                      echo '</select>';
                                  }
                              ?>  
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Batch<span class="text-danger ml-2">*</span></label>
                              <?php
                                  echo"<div id='txtHint'></div>";
                              ?>
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Upload Student Photo</label>
                          <input type="file" class="form-control" name="img" id="exampleInputFirstName" required >
                        </div>

                        <!-- <div class="col-xl-6">
                          <label class="form-control-label">Generate id </label>
                          <button type="submit" name='generate'>Click me</button>
                        </div> -->
                    </div>
                      <?php
                        if (isset($Id) && $_GET['action'] == "edit")
                        {
                          ?>
                          <button type="submit" name="update" class="btn btn-warning">Update</button>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <?php
                        } else {           
                          ?>
                          <button type="submit" name="save" class="btn btn-primary">Save</button>
                          <?php
                        }         
                      ?>
                  </form>
                </div>
              </div>
              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">All Student</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Admission No</th>
                            <th>Class</th>
                            <th>Batch</th>
                            <th>Date registered</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <!-- <th>Generate ID</th>
                            <th>Generate Certeficate</th> -->
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          //Query selects the students
                              $query = "SELECT tblstudents.Id,tblstudents.stuPhone,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
                              tblstudents.lastName,tblstudents.admissionNumber,tblstudents.dateCreated,tblstudents.email
                              FROM tblstudents
                              INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                              INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId";
                              $rs = $conn->query($query);
                              $num = $rs->num_rows;
                              $sn=0;
                              $status="";
                              if($num > 0)
                              { 
                                while ($rows = $rs->fetch_assoc())
                                  {

                                    $x = $rows['Id'];
                                    $y = '../ID Cards/'.$rows['firstName'].' '.$rows['lastName'].'_'.$rows['className'].'.pdf';
                                    $z = '../Certeficate/'.$rows['firstName'].' '.$rows['lastName'].'-'.$rows['className'].'.pdf';

                                    // $downloadCerteficate = 'Not found';
                                    // $downloadIdCard = 'No Id'; //if file is not found for Id Card 
                                    // if (file_exists($y) && $rows['email'] != ' ') { //if file path is found
                                    //       $downloadIdCard = "<a href='../Downloads/downloadID.php?file_path=".urlencode($y)."&studentName=".$rows['firstName']."&studentEmail=".$rows['email']."'><i class='fas fa-fw fa-download'></i></a>";
                                    // } //we are sending request for downloadID.php to download the ID card and also send it to the student.
                                    
                                    // if (extension_loaded('gd')) {
                                    //   $downloadCerteficate = "<a href='#' onclick='generateCerteficate(".$x.", \"".$z."\")'><i class='fas fa-fw fa-download'></i></a>"; //Id card is generated when registreting student
                                    // }
                                    $sn = $sn + 1;
                                    echo"
                                      <tr>
                                        <td>".$sn."</td>
                                        <td>".$rows['firstName']."</td>
                                        <td>".$rows['lastName']."</td>
                                        <td>".$rows['email']."</td>
                                        <td>".$rows['stuPhone']."</td>
                                        <td>".$rows['admissionNumber']."</td>
                                        <td>".$rows['className']."</td>
                                        <td>".$rows['classArmName']."</td>
                                        <td>".$rows['dateCreated']."</td>
                                      
                                        <td><a href='?action=edit&Id=".$rows['Id']."'><i class='fas fa-fw fa-edit'></i></a></td>
                                        <td><a href='?action=delete&Id=".$rows['Id']."'><i class='fas fa-fw fa-trash'></i></a></td>

                                        <td>".$downloadIdCard."</td> 

                                        <td>".$downloadCerteficate."</td> 

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

  <!-- Script -->
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
    //ID
    function generateIdCard(studentId, path) {
      // Prevent the default behavior of the link
      event.preventDefault();
      // Make an AJAX request to the ID card generation script
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "../ControlIdentification/index.php?Id=" + studentId, true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          // Redirect to the PHP file that serves the generated file for download
          window.location.href = "../Downloads/downloadID.php?file_path=" + path;
          // Wait for the download to complete before displaying the success message or error message
          setTimeout(function () {
            // Check if the file was downloaded successfully
            var downloadStatus = localStorage.getItem("downloadStatus");
            if (downloadStatus === "success") {

              
              // Display a success message to the user
              var successMessage = document.createElement("div");
              successMessage.classList.add("error-message");
              successMessage.innerText = "Student ID card not generated successfully!";
              document.body.appendChild(successMessage);
              setTimeout(function () {
                successMessage.remove();
              }, 3000);
            } else {
              // Display an error message to the user
              var successMessage = document.createElement("div");
              successMessage.classList.add("success-message");
              successMessage.innerText = "Student ID card generated and downloaded successfully!";
              document.body.appendChild(successMessage);
              setTimeout(function () {
                successMessage.remove();
              }, 2000);
              <?php ?>
            }
            // Remove the download status from localStorage
            localStorage.removeItem("downloadStatus");
          }, 2000);
          
        } else {
          // Display an error message to the user
          var errorMessage = document.createElement("div");
          errorMessage.classList.add("error-message");
          errorMessage.innerText =
            "Error generating student ID card!";
          document.body.appendChild(errorMessage);
        }
      };
      // Send the AJAX request
      xhr.send();
    }

    // Handle error message from downloadID.php
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("error_message")) {
      var errorMessage = document.createElement("div");
      errorMessage.classList.add("error-message");
      errorMessage.innerText = urlParams.get("error_message");
      document.body.appendChild(errorMessage);
    }

    // Listen for the download complete event
    window.addEventListener("storage", function (event) {
      if (event.key === "downloadStatus") {
        localStorage.setItem("downloadStatus", event.newValue);
      }
    });
    //
  //Certeficate
  function generateCerteficate(studentId,paths) {
      // Prevent the default behavior of the link
      event.preventDefault();
      // Make an AJAX request to the ID card generation script
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "../ControlIdentification/index2.php?Id=" + studentId, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Display a success message to the user
          var successMessage = document.createElement("div");
          successMessage.classList.add("success-message");
          successMessage.innerText = "Student Certeficate generated successfully!";
          document.body.appendChild(successMessage);
          
          // Remove the success message after 3 seconds
          setTimeout(function() {
            successMessage.remove();
          }, 3000);
          window.location.href = "../Downloads/certeficateDownload.php?file_path="+paths;
        } else {
          // Display an error message to the user
          var errorMessage = document.createElement("div");
          errorMessage.classList.add("error-message");
          errorMessage.innerText = "Error generating student ID card!";
          document.body.appendChild(errorMessage);
        }
      };
      xhr.send();
  }
  </script>
</body>

</html>