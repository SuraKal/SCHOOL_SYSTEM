
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once ('../Includes/init.php');

//Getting current page 
$current_page = basename($_SERVER['PHP_SELF']);



//------------------------SAVE--------------------------------------------------

// Check if the form has been submitted
if (isset($_POST['save'])) {
    // Get form values
    $title = input_cleaner($_POST['tittle']);
    $description = input_cleaner($_POST['discription']);
    $reference = input_cleaner($_POST['Reference']);
    $timeFrom = date('h:i A', strtotime($_POST['timeFrom']));
    $timeTo = date('h:i A', strtotime($_POST['timeTo']));
    $timeFrom = input_cleaner($timeFrom);
    $timeTo = input_cleaner($timeTo);
    $type = input_cleaner($_POST['type']);

    // $classId = $rrw['classId'];
    $classArmId = $_POST['classArmId'];
    $classArmInfo = getClassArm($classArmId); //Select the class Id of the specific batch
    $classId = $classArmInfo['classId']; 

    $dateCreated = date("Y-m-d");

    // Handle file upload
        
        // Insert data into tblschedules with file path
        if ($type == "2" && isset($_POST['singleDate'])) {
            // Single date selected
            $singleDate = date('Y-m-d', strtotime($_POST['singleDate']));
            // Get the file data
                $name = $_FILES['document']['name'];
                $size = $_FILES['document']['size'];
                $type = $_FILES['document']['type'];
                $file_temp = $_FILES['document']['tmp_name'];

                $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($name, PATHINFO_EXTENSION);

                $file_path = '../Doc/' . $unique_name;
                move_uploaded_file($file_temp, $file_path);
                
            $sql = "INSERT INTO tblschedules (classId, classArmId, title, description, Reference, timeFrom, timeTo, date, date_created, Doc)
                    VALUES ('$classId', '$classArmId', '$title', '$description', '$reference', '$timeFrom', '$timeTo', DATE_FORMAT('$singleDate','%Y-%m-%d'), '$dateCreated', '$file_path')";
                    if ($conn->query($sql) === TRUE) {
                    // Success message
                    $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>";
                    // echo "Schedule saved successfully for $currentDate!";
                } else {
                    // Error message
                    $statusMsg ="<div class='alert alert-success' style='margin-right:700px;'>Error occur</div>";
                    
                }
        } else if ($type == "3" && isset($_POST['fromDate']) && isset($_POST['toDate'])) {
          $success = false;
          $error = false;
          $errorMsg = "";

          // Generate a unique file name for the uploaded file
          $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
          $file_path = '../Doc/' . $unique_name;

          // Date range selected
          $fromDate = date_create($_POST['fromDate']);
          $toDate = date_create($_POST['toDate']);

          // Loop through dates between dateFrom and dateTo
          $interval = date_interval_create_from_date_string('1 day');
          $currentDate = $fromDate;

          while ($currentDate <= $toDate) {
              $timeFrom = date('h:i A', strtotime($_POST['timeFrom']));
              $timeTo = date('h:i A', strtotime($_POST['timeTo']));

              // Insert data into tblschedule for each date
              $sql = "INSERT INTO tblschedules (classId, classArmId, title, description, Reference, timeFrom, timeTo, date, date_created, Doc)
                      VALUES ('$classId', '$classArmId', '$title', '$description', '$reference', '$timeFrom', '$timeTo', '".date_format($currentDate, 'Y-m-d')."', '$dateCreated', '$file_path')";

              // Execute the query
              if ($conn->query($sql) === TRUE) {
                  // Success message
                  $success = true;
              } else {
                  // Error message
                  $error = true;
                  $errorMsg = "Error: " . $sql . "<br>" . $conn->error;
              }

              // Increment current date by 1 day
              date_add($currentDate, $interval);
          }

          // Move the uploaded file to the server
          move_uploaded_file($_FILES['document']['tmp_name'], $file_path);

          if ($success) {
              $statusMsg ="<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>";
          }
          if ($error) {
              $statusMsg =$errorMsg;
          }

        } else {
            // Invalid form input
            echo "Invalid form input.";
        }
}

// -------------------End-Save-------------------------------------------
//--------------------EDIT------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
    {
          $Id= input_cleaner($_GET['Id']);

          $query=mysqli_query($conn,"select * from tblschedules where Id ='$Id'");
          $row=mysqli_fetch_array($query);

          //------------UPDATE-----------------------------
          if(isset($_POST['update'])){

                    $title = input_cleaner($_POST['tittle']);
                    $description = input_cleaner($_POST['discription']);
                    $reference = input_cleaner($_POST['Reference']);
                    $timeFrom = date('h:i A', strtotime($_POST['timeFrom']));
                    $timeTo = date('h:i A', strtotime($_POST['timeTo']));
                    $timeFrom = input_cleaner($timeFrom);
                    $timeTo = input_cleaner($timeTo);
                    $type = input_cleaner($_POST['type']);

                    // $classId = $rrw['classId'];
                    $classArmId = $_POST['classArmId'];
                    $classArmInfo = getClassArm($classArmId); //Select the class Id of the specific batch
                    $classId = $classArmInfo['classId'];


                    $dateCreated = date("Y-m-d");
                    if ($type == 2) {
                      // Single date selected
                      $singleDate =  date('Y-m-d', strtotime($_POST['singleDate']));
                      // $date = date('Y-m-d', strtotime($_POST['singleDate']));
                      $timeFrom = date('h:i A', strtotime($_POST['timeFrom']));
                      $timeTo = date('h:i A', strtotime($_POST['timeTo']));
                      $timeFrom = input_cleaner($timeFrom);
                      $timeTo = input_cleaner($timeTo);
                      $name = $_FILES['document']['name'];
                      $size = $_FILES['document']['size'];
                      $type = $_FILES['document']['type'];
                      $file_temp = $_FILES['document']['tmp_name'];
                      $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($name, PATHINFO_EXTENSION);
                      $file_path = '../Doc/' . $unique_name;
                      move_uploaded_file($file_temp, $file_path);
                      // Insert data into tblschedule
                      $query=mysqli_query($conn,"update tblschedules set classId = '$classId', classArmId='$classArmId', title='$title', description='$description', Reference='$reference', timeFrom='$timeFrom', timeTo='$timeTo', date='$singleDate', date_created='$dateCreated', Doc = '$file_path' where Id='$Id'");
                      // Execute the query
                      if ($query) {
                          header('Location:ViewScedule.php');
                          exit; 
                      }
                      else
                      {
                          $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
                      }
                    } else if ($type == 3) {
                        $success = false;
                        $error = false;
                        $errorMsg = "";
                        // Generate a unique file name for the uploaded file
                        $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
                        $file_path = '../Doc/' . $unique_name;
                        // Loop through dates between dateFrom and dateTo
                        $fromDate = date_create($_POST['fromDate']);
                        $toDate = date_create($_POST['toDate']);
                        
                        $interval = date_interval_create_from_date_string('1 day');
                        $currentDate = $fromDate;
                        while ($currentDate <= $toDate) {
                            $timeFrom = date('h:i A', strtotime($_POST['timeFrom']));
                            $timeTo = date('h:i A', strtotime($_POST['timeTo']));
                            // Insert data into tblschedule for each date
                            $query = mysqli_query($conn, "UPDATE tblschedules SET classId = '$classId', classArmId='$classArmId', title='$title', description='$description', Reference='$reference', timeFrom='$timeFrom', timeTo='$timeTo', date='".date_format($currentDate, 'Y-m-d')."', date_created='$dateCreated', Doc = '$file_path' WHERE Id='$Id'");

                            // Execute the query
                            if ($query) {
                                // Success message
                                $success = true;
                            } else {
                                // Error message
                                $error = true;
                                $errorMsg = "Error: " . $query . "<br>" . $conn->error;
                            }
                            // Increment current date by 1 day
                            date_add($currentDate, $interval);
                        }
                        // Move the uploaded file to the server
                        move_uploaded_file($_FILES['document']['tmp_name'], $file_path);
                        if ($success) {
                            header('Location:ViewScedule.php');
                            exit;  
                        } else {
                            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
                        }
                    }
            }
    }
    

  //--------------------------------End-Edit------------------------------------------------------------------
//--------------------------------DELETE------------------------------------------------------------------

    if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
    {
          $Id= input_cleaner($_GET['Id']);
          $query = mysqli_query($conn,"DELETE FROM tblschedules WHERE Id='$Id'");
          if ($query == TRUE) {
                  if (file_exists($_GET['Doc'])) {
                      // Output a download link for the file
                      unlink($_GET['Doc']);
                  }
                  header('Location:ViewScedule.php');
                  exit; 
          }
          else{
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
          }
        
    }
    

    // 
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
            <h1 class="h3 mb-0 text-gray-800">Create Class Schedule</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Class Schedule</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Schedule</h6>
                    <div id="status_message"><?php echo $statusMsg; ?> </div>
                </div>
                <div class="card-body">
                  <form method="post" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                        <div class="col-xl-3">
                        <label class="form-control-label">Tittle<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="tittle" value="<?php echo $row['title'];?>" id="exampleInputFirstName" required>
                        </div>
                        <div class="col-xl-9">
                        <label class="form-control-label">Description<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="discription" value="<?php echo $row['description'];?>" id="exampleInputFirstName" required> 
                        </div>
                        
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                            <label class="form-control-label">Reference links</label>
                          <input type="text" class="form-control" name="Reference" value="<?php echo $row['Reference'];?>" id="exampleInputFirstName" >
                        </div>
                        <div class="col-xl-6">
                            <label class="form-control-label">Upload files</label>
                            <input type="file" class="form-control" name="document" id="exampleInputFirstName" >
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-3">
                          <label for="time" class="form-control-label">Class starts at:</label>
                          <input type="time" class="form-control" id="time" name="timeFrom" placeholder="--:-- --" pattern="(1[012]|[1-9]):[0-5][0-9] (AM|PM)" required>
                        </div>
                        <div class="col-xl-3">
                          <label for="time" class="form-control-label">Class ends at:</label>
                          <input type="time" class="form-control" id="time" name="timeTo" placeholder="--:-- --" pattern="(1[012]|[1-9]):[0-5][0-9] (AM|PM)" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Type<span class="text-danger ml-2">*</span></label>
                          <select required name="type" onchange="typeDropDown(this.value)" class="form-control mb-3">
                          <option value="">--Select--</option>
                          <option value="2" >Single Date Sechdule</option>
                          <option value="3" >Weekly Sechdule </option>
                        </select>
                        </div>
                        <div class="form-group col-12 col-lg-4">
                          <label for="classArmSelect">For which batch:</label>
                          <select name="classArmId" class="form-control" id="classArmSelect" required>
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
                    </div>
                      <?php
                        echo"<div id='txtHint'></div>";
                      ?>
                    <?php
                        if (isset($Id))
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
                    <!--  -->
                  </form>
                </div>
                      
                    
            
              </div>
              <div class="text-black mt-5"> <h2 >View Schedule Info</h2></div>
              <div class="card-body mt-2 border-top" class="container">
                <div class="row">
                  <form method="post" class ="col">
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
                    <button type="submit" name="Take" class="btn btn-primary">Take me to my schedule</button>
                    
                  </form>
                  
                </div>
              </div>
              <!-- Input Group -->
              <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between col-10">
                    <h6 class="m-0 font-weight-bold text-primary">Class schedule</h6>
                    
                  </div>
                  <div>
                    <!-- <form method="post" class="mt-3 col-2">
                      <button type="submit" name="deleted" class="btn btn-danger">Delete all</button>
                    </form> -->
                    <?php
                        echo"<div id='txtHint'></div>";
                      ?>
                  </div>
                  
                </div>
                
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover table_width">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Batch</th>
                        <th>Date</th>
                        <th>Tittle</th>
                        <th>Starts at</th>
                        <th>Ends at</th>
                        <th>Detail</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Download</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                  <?php
                  if(isset($_POST['Take'])){
                      $type =  $_POST['type'];
                      $sn = 0;
                      if($type == "4"){

                                //All Attendance
                                foreach ($classArmArray as $classArmId) { //Array of class arm Id collection 

                                  if(!empty(getClassArm($classArmId))){ //If the class arm exists 
                                    // Associate class name with it to 
                                    $classArmInfo = getClassArm($classArmId); //Select the class Id of the specific batch
                                    $classId = $classArmInfo['classId'];  

                                    $query = "SELECT *,tblschedules.Id,tblclassarms.classArmName,tblclass.className
                                    FROM tblschedules
                                    INNER JOIN tblclass ON tblclass.Id = tblschedules.classId
                                    INNER JOIN tblclassarms ON tblclassarms.Id = tblschedules.classarmId
                                    WHERE tblschedules.classId = '$classId' AND tblschedules.classarmId = '$classArmId'";

                                      $rs = $conn->query($query);
                                      $num = $rs->num_rows;
                                      $status="";
                                      if($num > 0)
                                      { 
                                          while ($rows = $rs->fetch_assoc())
                                          {
                                              $sn = $sn + 1;
                                              echo "<tr>
                                                      <td>".$sn."</td>
                                                      <td>".$rows['className']."</td>
                                                      <td>".$rows['classArmName']."</td>
                                                      <td>".$rows['date']."</td>
                                                      <td>".$rows['title']."</td>
                                                      <td>".$rows['timeFrom']."</td>
                                                      <td>".$rows['timeTo']."</td>
                                                      <td><a href='scheduleDetail.php?Id=".$rows['Id']."&link=".$current_page."' class='btn-primary p-1 text-decoration-none'>View</a></td>
                                                      <td><a href='?action=edit&Id=".$rows['Id']."'><i class='fas fa-fw fa-edit'></i></a></td>
                                                      <td><a href='?action=delete&Id=".$rows['Id']."&Doc=".$rows['Doc']."'><i class='fas fa-fw fa-trash'></i></a></td>
                                                      <td>";
                                                      // Check if the Doc file exists
                                                          if (file_exists($rows['Doc'])) {
                                                          // Output a download link for the file
                                                            echo "<a href='download.php?file_path=".urlencode($rows['Doc'])."'><i class='fas fa-fw fa-download'></i></a>";
                                                          }  
                                              
                                              echo "</td>
                                                    </tr>";
                                          }
                                      }else
                                        {
                                            echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
                                        }
                                  } //If not end
                                } //For each end
                                




                              }
                              if($type == "5"){
                                // This week 
                                foreach ($classArmArray as $classArmId) { //Array of class arm Id collection 
                                  if (!empty(getClassArm($classArmId))) { //If the class arm exists 
                                    // Associate class name with it to 
                                    $classArmInfo = getClassArm($classArmId); //Select the class Id of the specific batch
                                    $classId = $classArmInfo['classId'];

                                    $query = "SELECT *,tblschedules.Id,tblclassarms.classArmName,tblclass.className
                                          FROM tblschedules
                                          INNER JOIN tblclass ON tblclass.Id = tblschedules.classId
                                          INNER JOIN tblclassarms ON tblclassarms.Id = tblschedules.classarmId
                                          WHERE tblschedules.classId = '$classId' AND tblschedules.classarmId = '$classArmId' AND WEEK(tblschedules.date) = WEEK(NOW())
                                            ";

                                    $rs = $conn->query($query);
                                    $num = $rs->num_rows;
                                    
                                    if ($num > 0) {
                                      while ($rows = $rs->fetch_assoc()) {

                                        $sn = $sn + 1;
                                        echo "
                                                      <tr>
                                                        <td>" . $sn . "</td>
                                                        <td>" . $rows['className'] . "</td>
                                                        <td>".$rows['classArmName']."</td>
                                                        <td>" . $rows['date'] . "</td>
                                                        <td>" . $rows['title'] . "</td>
                                                        <td>" . $rows['timeFrom'] . "</td>
                                                        <td>" . $rows['timeTo'] . "</td>
                                                        <td><a href='scheduleDetail.php?Id=".$rows['Id']."&link=" . $current_page . "' class='btn-primary p-1 text-decoration-none'>View</a></td>
                                                        <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i></a></td>
                                                        <td><a href='?action=delete&Id=" . $rows['Id'] . "&Doc=".$rows['Doc']."'><i class='fas fa-fw fa-trash'></i></a></td>
                                                        <td>";
                                                      // Check if the Doc file exists
                                                          if (file_exists($rows['Doc'])) {
                                                          // Output a download link for the file
                                                            echo "<a href='download.php?file_path=".urlencode($rows['Doc'])."'><i class='fas fa-fw fa-download'></i></a>";
                                                          }  
                                              
                                                        echo "</td>
                                                        </tr>";

                                      }
                                    } else {
                                      echo
                                        "<div class='alert alert-danger' role='alert'>
                                                    No Record Found!
                                                  </div>";
                                    }
                                  }
                                }
                              }
                    if ($type == "6") {
                      //This month
                            foreach ($classArmArray as $classArmId) { //Array of class arm Id collection 
                              if (!empty(getClassArm($classArmId))) { //If the class arm exists 
                                // Associate class name with it to 
                                $classArmInfo = getClassArm($classArmId); //Select the class Id of the specific batch
                                $classId = $classArmInfo['classId'];

                                $query = "SELECT *,tblschedules.Id,tblclassarms.classArmName,tblclass.className
                                          FROM tblschedules
                                          INNER JOIN tblclass ON tblclass.Id = tblschedules.classId
                                          INNER JOIN tblclassarms ON tblclassarms.Id = tblschedules.classarmId
                                          WHERE tblschedules.classId = '$classId' AND tblschedules.classarmId = '$classArmId' AND MONTH(tblschedules.date) = MONTH(NOW()) AND YEAR(tblschedules.date) = YEAR(NOW())
                                            ";

                                $rs = $conn->query($query);
                                $num = $rs->num_rows;
                                $status = "";
                                if ($num > 0) {
                                  while ($rows = $rs->fetch_assoc()) {
                                    $sn = $sn + 1;
                                    echo "
                                                  <tr>
                                                    <td>" . $sn . "</td>
                                                    <td>" . $rows['className'] . "</td>
                                                    <td>" . $rows['classArmName'] . "</td>
                                                    <td>" . $rows['date'] . "</td>
                                                    <td>" . $rows['title'] . "</td>
                                                    <td>" . $rows['timeFrom'] . "</td>
                                                    <td>" . $rows['timeTo'] . "</td>
                                                    <td><a href='scheduleDetail.php?Id=" . $rows['Id'] . "&link=" . $current_page . "' class='btn-primary p-1 text-decoration-none'>View</a></td>
                                                    <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i></a></td>
                                                    <td><a href='?action=delete&Id=" . $rows['Id'] . "&Doc=".$rows['Doc']."'><i class='fas fa-fw fa-trash'></i></a></td>
                                                  <td>";
                                                  // Check if the Doc file exists
                                                  if (file_exists($rows['Doc'])) {
                                                    // Output a download link for the file
                                                    echo "<a href='download.php?file_path=" . urlencode($rows['Doc']) . "'><i class='fas fa-fw fa-download'></i></a>";
                                                  }

                                                  echo "</td>
                                                                        </tr>";
                                  }
                                } else {
                                  echo
                                    "<div class='alert alert-danger' role='alert'>
                                                No Record Found!
                                              </div>";
                                }

                              }
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
