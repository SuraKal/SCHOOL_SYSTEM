
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once ('../Includes/init.php');
  //
// $adminInfo = $_SESSION['userId'];




  if(isset($_SESSION['error'])){
    $statusMsg_2 = "<div class='alert alert-success'  style='margin-right:700px;'>Registered but Email not sent to teacher</div>";
    unset($_SESSION['error']);
  }
  if(isset($_SESSION['userExists'])){
    $statusMsg = "<div class='alert alert-danger'  style='margin-right:700px;'>Already registered teacher | Change email!</div>";
    unset($_SESSION['userExists']);
  }
  if(isset($_SESSION['sucess'])){
    $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Registration sucessfull</div>";
    unset($_SESSION['sucess']);
  }
  if(isset($_SESSION['error'])){
    $statusMsg = "<div class='alert alert-danger'  style='margin-right:700px;'>Registeration not sucessfull</div>";
    unset($_SESSION['error']);
  }
  if(isset($_SESSION['sucessAdding'])){
    $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Added Successfully!</div>";
    unset($_SESSION['sucessAdding']);
  }
  if(isset($_SESSION['errorAdding'])){
    $statusMsg = "<div class='alert alert-danger'  style='margin-right:700px;'>Registeration not sucessfull</div>";
    unset($_SESSION['errorAdding']);
  }









if(isset($_POST['save'])){
    $firstName=input_cleaner($_POST['firstName']);
    $lastName=input_cleaner($_POST['lastName']);
    $emailAddress=input_cleaner($_POST['emailAddress']);

    $password=input_cleaner($_POST['password']);
    $InsertedPassword = hash('sha256', $password);

    $phoneNo=input_cleaner($_POST['phoneNo']);
    $classId=input_cleaner($_POST['classId']);
    $classArmId=input_cleaner($_POST['classArmId']);

    // $classArmIdInserted = implode(',', $classArmId);

    //for mail
    $classInfo = getClass($classId);
    $className = $classInfo['className'];

    $classArmInfo = getClassArm($classArmId);
    $classArmName = $classArmInfo['classArmName'];

    $sampPass = " ";
    $sampPass_2 = $sampPass;

    if(!empty($firstName) &&!empty($lastName) &&!empty($emailAddress) &&!empty($InsertedPassword) &&!empty($password) &&!empty($phoneNo) &&!empty($classId) &&!empty($classArmId)){
      registerTeacher($firstName,$lastName,$emailAddress,$InsertedPassword,$password,$phoneNo,$classId,$classArmId);
    }else{
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>There is an empty value</div>";

        header('Location: createClassTeacher.php');
        exit;

    }

    
}
  //
  //---------------------------------------EDIT-------------------------------------------------------------
  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
    {
          $Id= input_cleaner($_GET['Id']);
          $row= teacherInfo($Id);
          //------------UPDATE-----------------------------
          if(isset($_POST['update'])){


                $firstName=input_cleaner($_POST['firstName']);
                $lastName=input_cleaner($_POST['lastName']);
                $emailAddress=input_cleaner($_POST['emailAddress']);
                $phoneNo=input_cleaner($_POST['phoneNo']);
                $classId=input_cleaner($_POST['classId']);
                $classArmId=input_cleaner($_POST['classArmId']);
                
                $password=input_cleaner($_POST['password']);

                // $newPASS = md5($password);
                if($password != $row['password']){ 
                    $password = hash('sha256', $password); //Change password if the password is changed , if not reserve the old one 
                }
                
                $dateCreated = date("Y-m-d");
                $query=mysqli_query($conn,"update tblclassteacher set firstName='$firstName', lastName='$lastName',
                emailAddress='$emailAddress', password='$password',phoneNo='$phoneNo', classId='$classId',classArmId='$classArmId'
                where Id='$Id'");
                        if ($query) {
                            // updateTeacherMail($emailAddress,$firstName); //mail teacher that there is an update on his information 
                            $qu=mysqli_query($conn,"update tblclassarms set isAssigned='1',teacherId='$Id' where Id ='$classArmId'");
                              if ($qu) {

                                  if($row['classArmId'] != $classArmId){ //If the teacher converted his batch , the old batch must be set to unassigned 
                                    $oldBatch = $row['classArmId'];
                                    $qu=mysqli_query($conn,"update tblclassarms set isAssigned='0' where Id ='$oldBatch'");
                                  }

                                  $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Updated Successfully!</div>";
                              }
                              else
                              {
                                  $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
                              }
                            header('Location: createClassTeacher.php');
                            exit;
                        }
                        else
                        {
                            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
                        }
          }
    }
//--------------------------------End Edit------------------------------------------------------------------

//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['classArmId']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= input_cleaner($_GET['Id']);
        $classArmId= $_GET['classArmId'];
        $query = mysqli_query($conn,"DELETE FROM tblclassteacher WHERE Id='$Id'");
          if ($query == TRUE) {
              $qu=mysqli_query($conn,"update tblclassarms set isAssigned='0' where teacherId ='$Id'");
              if ($qu) {
                header('Location: createClassTeacher.php');
                exit;

              }
              else
              {
                  $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
              }
          }
          else{
              $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
          }
  }


  if (isset($_GET['Id']) &&  isset($_GET['action']) && $_GET['action'] == "add")
	{
        $selected_Teacher = input_cleaner($_GET['Id']);
        $row=teacherInfo($selected_Teacher);
          //------------Assign-----------------------------
          if(isset($_POST['assign'])){

                $firstName=input_cleaner($_POST['firstName']);
                $lastName=input_cleaner($_POST['lastName']);
                $emailAddress=input_cleaner($_POST['emailAddress']);
                $phoneNo=input_cleaner($_POST['phoneNo']);

                $classId=input_cleaner($_POST['classId']);
                $classArmId=input_cleaner($_POST['classArmId']);

                // Here
                $updatedListClassArms = $row['classArmId'] . ',' . $classArmId; //Add the new class arm to the old one 

                // $newPASS = md5($password);
                $password=input_cleaner($_POST['password']);
                if($password != $row['password']){
                    $password = hash('sha256', $password); //Change password if the password is changed , if not reserve the old one 
                }

                if(!empty($firstName) &&!empty($lastName) &&!empty($emailAddress) && !empty($password) &&!empty($phoneNo) &&!empty($classId) &&!empty($classArmId)){
                  addBatch($selected_Teacher,$firstName,$lastName,$emailAddress,$password,$phoneNo,$classId,$classArmId,$updatedListClassArms);
                }else{
                  $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>There is an empty value</div>";
                  header('Location: createClassTeacher.php');
                  exit;
                }
          }
  }
  
  // if (isset($_GET['Id']) &&  isset($_GET['action']) && $_GET['action'] == "add")
	// {
  //       $Teacher = input_cleaner($_GET['Id']);
  //       $row=teacherInfo($Teacher);




  //       // $classArmId = $row['classArmId'];
  //       // $delimiter = ",";
  //       // $classArm = explode($delimiter, $classArmId);
  //       // print "<pre>";
  //       // print_r($classArm); 
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
          xmlhttp.open("GET","ajaxClassArms.php?cid="+str,true);
          xmlhttp.send();
      }
    }

  </script>
  <style>
    .popup-modal {
      /* /* max-width: 550px; */
      /* background: #FFFFFF; */
      /* position: relative;
      margin: 0 auto;
      font-size: 20px;
      padding:50px;
      height: 20px; */
        padding: 40px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #model_3{
      display: none;
      width: 50%;
    }

  </style>
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
            <h1 class="h3 mb-0 text-gray-800">Create Class Teachers</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Class Teachers</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Create Class Teachers</h6>
                    <div id="status_message"><?php echo $statusMsg; ?></div> 
                    <div id="status_message_2"><?php echo $statusMsg_2; ?></div> 
                </div>
                <div class="card-body">
                  <!-- This is a form where teachers/instractors are registered and assigned to already exisiting class and batchs -->
                  <form method="post">
                    <div class="form-group row mb-3">
                        <!-- Fill the teacher info  -->
                        <div class="col-xl-6">
                          <label class="form-control-label">Firstname<span class="text-danger ml-2">*</span></label>
                            <input type="text" class="form-control" required name="firstName" value="<?php echo $row['firstName'];?>" id="exampleInputFirstName">
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Lastname<span class="text-danger ml-2">*</span></label>
                            <input type="text" class="form-control" required name="lastName" value="<?php echo $row['lastName'];?>" id="exampleInputFirstName" >
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">Email Address<span class="text-danger ml-2">*</span></label>
                          <input type="email" class="form-control" required name="emailAddress" value="<?php echo $row['emailAddress'];?>" id="exampleInputFirstName" >
                        </div>
                        <div class="col-xl-6">
                            <label class="form-control-label">Phone No<span class="text-danger ml-2">*</span></label>
                              <input type="text" class="form-control" name="phoneNo" value="<?php echo $row['phoneNo'];?>" id="exampleInputFirstName" >
                        </div>
                        <div class="col-xl-6">
                            <label class="form-control-label">Password<span class="text-danger ml-2">*</span></label>
                              <input type="text" class="form-control" name="password" value="<?php echo $row['password'];?>" id="exampleInputFirstName" >
                        </div>
                    </div>
                    <!-- Select the class the teacher teaches -->
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

                                  // if($_GET['action'] == 'edit' && $row['classId'] == $rows['Id']){
                                  //   echo'<option value="'.$rows['Id'].'" selected>'.$rows['className'].'</option>';
                                  // }

                                  echo'<option value="'.$rows['Id'].'" >'.$rows['className'].'</option>';
                                      }
                                          echo '</select>';
                                      }
                                  ?>  
                              </div>
                        <!-- Select the batch the teacher teaches -->
                        <div class="col-xl-6">
                            <label class="form-control-label">Batch<span class="text-danger ml-2">*</span></label>
                              <?php
                                echo"<div id='txtHint'></div>";
                              ?>
                        </div>
                    </div>
                      <?php
                        if (isset($Id))
                        {
                      ?>
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php
                        } else if(isset($selected_Teacher)){ //For alredy existing teacher to assign new class          
                      ?>
                        <button type="submit" name="assign" class="btn btn-primary">Set</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                      <?php
                        }else{         
                      ?>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                      <h6 class="m-0 font-weight-bold text-primary">All Class Teachers</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <!-- <th>#</th> -->
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Phone No</th>
                            <!-- <th>Class</th> -->
                            <!-- <th>Add</th> -->
                            <!-- <th >Date registered</th> -->
                            <th>Date registered</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <!-- <div id="model_3" class="popup-modal slider mfp-hide">Hello</div> -->
                        <tbody> 
                          <!-- Query to list all teachers -->
                          <?php
                              $query = "SELECT *
                              FROM tblclassteacher
                              ";
                              $rs = $conn->query($query);
                              $num = $rs->num_rows;
                              $sn=0;
                              $status="";
                              if($num > 0)
                              { 
                                while ($rows = $rs->fetch_assoc())
                                  {

                                    $get_batch = teacherAssign($rows['Id']); //check if any of batch is assigned to that teacher
                                    if(empty($get_batch)){
                                      //If the teacher has no class we will show it a button to add class 
                                      $batch = "<a href='?action=add&Id=".$rows['Id']."' class='btn-primary text-white p-1 px-2 d-none'>Add</a>";
                                    }else{
                                      $batch = "<a href='#model_3' class='btn-primary text-white p-1 px-2 link d-none'>View</a>";
                                      // print("<pre>");
                                      // print_r($batch);
                                      // To display the batch 
                                      $class = '<div id="model_3" class="popup-modal slider mfp-hide d-none">
                                                  <p class="close"><i class="fa fa-window-close text-danger" aria-hidden="true"></i></p>
                                                  <div class="media">
                                                    <!-- <img src="./images/portfolio/Apple Bootstrap1.jpg" alt="" /> -->
                                                  </div>      	

                                                  <table>
                                                  <tbody> 

                                                    <tr>
                                                      <th>No</th>
                                                      <th>Class</th>
                                                      <th class="d-none">Batch</th>
                                                    </tr>';
                                    $classArm = $rows['classArmId'];
                                $delimiter = ',';
                                $classArmId = explode($delimiter, $classArm);
                                $sn = 0;
                                foreach($classArmId as $classArm){
                                  
                                  if(!empty(getClassArm($classArm))){
                                    
                                      $sn = $sn + 1;
                                      $batchInfo = getClassArm($classArm);
                                      $batchName = $batchInfo['classArmName']; //get class arm name 
                                      $classId = $batchInfo['classId']; //get class Id of that class 
                                      $classInfo = getClass($classId); //get class info based on the Id 
                                      $className = $classInfo['className']; 
                                      $class .= '<tr>
                                                          <td>' . $sn . '</td>
                                                          <td>' . $className . '</td>
                                                          <td>' . $batchName . '</td>
                                                        </tr>';
                                  }
                                }
                                    // for ($sn = 1; $sn <= 10; $sn++) {
                                    //     $class .= '<tr>
                                    //                   <td>' . $sn . '</td>
                                    //                   <td>' . $sn . '</td>
                                    //                 </tr>';
                                    // }

                                    $class .= '</tbody></table></div>';
                                    }
                                    
                                    // End displaying batch 
                                    $sn = $sn + 1;
                                    echo"
                                      <tr>
                                        <td>".$rows['firstName']."</td>
                                        <td>".$rows['lastName']."</td>
                                        <td>".$rows['emailAddress']."</td>
                                        <td>".$rows['phoneNo']."</td>
                                        <td class='d-none'>".$batch. $class."</td>
                                        

                                        <td>".$rows['dateCreated']."</td>
                                        <td><a href='?action=edit&Id=".$rows['Id']."'><i class='fas fa-fw fa-edit'></i></a></td>
                                        <td><a href='?action=delete&Id=".$rows['Id']."&classArmId=".$rows['classArmId']."'><i class='fas fa-fw fa-trash'></i></a></td>

                                      </tr>";
                                  }
                              }
                              // <td><a href='?action=add&Id=".$rows['Id']."'><i class='fa fa-plus-square' aria-hidden='true'></i></a></td>
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



      $('#model_3').addClass('card');

      function show(e){
        e.preventDefault();
        $('#model_3').slideToggle("slow");
      }
      $('.link').on('click',show); //for the view btn 

      $('.close').on('click',hideContainer); //For close btn 

      function hideContainer(){ //For closebtn 
        $(this).parent().slideUp("slow");
        // $.magnificPopup.close();
      }



    });

  </script>
</body>

</html>