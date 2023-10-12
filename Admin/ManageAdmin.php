
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once ('../Includes/init.php');

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $firstName=input_cleaner($_POST['firstName']);
    $lastName=input_cleaner($_POST['lastName']);
    $emailAddress=input_cleaner($_POST['emailAddress']);
    $password=input_cleaner($_POST['password']);
    $password = hash('sha256', $password); //Hash it later
    $dateCreated = date("Y-m-d");
    $query=mysqli_query($conn,"select * from tblsubadmin where emailAddress ='$emailAddress'");
    $ret=mysqli_fetch_array($query);
    $sampPass = " ";
    $sampPass_2 = $sampPass;
    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
    }
    else{
    $query=mysqli_query($conn,"INSERT into tblsubadmin(firstName,lastName,emailAddress,password) 
    value('$firstName','$lastName','$emailAddress','$password')");
    }
}

//--------------------EDIT------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= input_cleaner($_GET['Id']);

        $query=mysqli_query($conn,"select * from tblsubadmin where Id ='$Id'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){

                $firstName=input_cleaner($_POST['firstName']);
                $lastName=input_cleaner($_POST['lastName']);
                $emailAddress=input_cleaner($_POST['emailAddress']);
                $password=input_cleaner($_POST['password']);

                if($password != $row['password']){ 
                    $password = hash('sha256', $password); //Change password if the password is changed , if not reserve the old one 
                }
                
                $query=mysqli_query($conn,"update tblsubadmin set firstName='$firstName', lastName='$lastName',
                emailAddress='$emailAddress', password='$password'
                where Id='$Id'");
                if ($query) {
                    echo "<script type = \"text/javascript\">
                    window.location = (\"ManageAdmin.php\")
                    </script>"; 
                }
                else
                {
                    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
                }
        }
  }
//--------------------------------DELETE------------------------------------------------------------------
  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= input_cleaner($_GET['Id']);
        $query = mysqli_query($conn,"DELETE FROM tblsubadmin WHERE Id='$Id'");
        if ($query == TRUE) {
          header('Location: ManageAdmin.php');
          exit;

        }
        else{
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
          }
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
            <h1 class="h3 mb-0 text-gray-800">Create Sub-Admin</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Sub-Admin</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Sub-admin</h6>
                            <div id="status_message"><?php echo $statusMsg; ?></div> 
                </div>
                <div class="card-body">
                  <!-- This is a form for collecting admin data, including first name, last name, email address, and password. It also has two buttons - "Save" and "Update" - for creating new user accounts and updating existing ones, respectively. -->
                  <form method="post">
                    <div class="form-group row mb-3">
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
                        <label class="form-control-label">Password<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" required name="password" value="<?php echo $row['password'];?>" id="exampleInputFirstName" >
                        </div>
                    </div>
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
                  </form>
                </div>
              </div>
              <!-- Input Group -->
              <!-- The follwing code simply provides some list of Sub-admins -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Sub-Admins list</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Password</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                      <?php
                          $query = "SELECT *
                          FROM tblsubadmin";
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
                                        <td>".$rows['firstName']."</td>
                                        <td>".$rows['lastName']."</td>
                                        <td>".$rows['emailAddress']."</td>
                                        <td>".$rows['password']."</td>
                                        <td><a href='?action=edit&Id=".$rows['Id']."'><i class='fas fa-fw fa-edit'></i></a></td>
                                        <td><a href='?action=delete&Id=".$rows['Id']."'><i class='fas fa-fw fa-trash'></i></a></td>
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