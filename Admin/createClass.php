<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once ('../Includes/init.php');

  // Messages 
  if(isset($_SESSION['exists'])){
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Already Exists!</div>"; //No same class name 
    unset($_SESSION['exists']);
  }
  if(isset($_SESSION['success'])){
    $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
    unset($_SESSION['success']);
  }
  if(isset($_SESSION['error'])){
    $statusMsg = "<div class='alert alert-danger'  style='margin-right:700px;'>Regsiteration Not Successfull!</div>";
    unset($_SESSION['error']);
  }

  if(isset($_SESSION['sucessUpdate'])){
    $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Updated successfully!</div>";
    unset($_SESSION['sucessUpdate']);
  }
  if(isset($_SESSION['errorUpdate'])){
    // $statusMsg = $_SESSION['errorUpdate'];
    $statusMsg = "<div class='alert alert-danger'  style='margin-right:700px;'>Update not successfull!</div>";
    unset($_SESSION['errorUpdate']);
  }

  if(isset($_SESSION['sucessDelete'])){
    $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Deleted successfully!</div>";
    unset($_SESSION['sucessDelete']);
  }
  if(isset($_SESSION['errorDelete'])){
    // $statusMsg = $_SESSION['errorUpdate'];
    $statusMsg = "<div class='alert alert-danger'  style='margin-right:700px;'>Dlete not successfull!</div>";
    unset($_SESSION['errorDelete']);
  }





  //------------------------SAVE class--------------------------------------------------
  if(isset($_POST['save'])){

      if(isset($_POST['className'])){
        $className = $_POST['className'];
      }
      //Validate the calss name 
      if(!empty($className) && is_string($className)){
        registerClass($className);
      }else{
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Please provide the valid | specific name of the class.</div>"; //No same class name 
      }
    
  }
  //------------------------End SAVE--------------------------------------------------
  //--------------------EDIT class created ------------------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") 
{

  $Id = $_GET['Id'];
  $classInfo = classInfo($Id);
  // print("<pre>");
  // print_r($classInfo);
  // // ------------UPDATE--------------//
  if (isset($_POST['update'])) {
                if (isset($_POST['className'])) {
                  $className = $_POST['className'];
                }

                if (!empty($className)) { // Use "&&" instead of "||"
                    // Call the function or perform the necessary update logic here
                    editClass($Id, $className);
                    // echo "Got until here";
                }
  }
} 
  //-------------------------------End EDIT------------------------------------------------------------
  //--------------------------------DELETE class created ------------------------------------------------------------------
  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete"){
    $classId= input_cleaner($_GET['Id']);
    if(!empty($classId)){
      deleteClass($classId);
    }
  }
//--------------------------------END - DELETE------------------------------------------------------------------

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
            <h1 class="h3 mb-0 text-gray-800">Create Class</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Class</li>
            </ol>
          </div>
          <!-- This is a form for collecting class data, including name. It also has two buttons - "Save" and "Update" - for creating new class and updating existing ones, respectively. -->
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Class</h6>
                    <div id="status_message"><?php echo $statusMsg; ?></div> 
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <!-- Fill class info -->
                        <div class="col-xl-6">
                            <label class="form-control-label">Class Name<span class="text-danger ml-2">*</span></label>
                            <input type="text" class="form-control" name="className" value="<?php echo $classInfo['className'];?>" id="exampleInputFirstName" required>
                        </div>
                    </div>
                    <!-- The button will be ditermined if the user wants to update or save data -->
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
              <!-- List to show the class created -->
              <div class="row">
                  <div class="col-lg-12">
                    <div class="card mb-4">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Classes</h6>
                      </div>
                      <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                          <thead class="thead-light">
                            <tr>
                              <th>#</th>
                              <th>Class Name</th>
                              <th>Edit</th>
                              <th>Delete</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            //Query to show all class
                                $query = "SELECT * FROM tblclass";
                                $rs = $conn->query($query);
                                $num = $rs->num_rows;
                                $sn=0;
                                if($num > 0)
                                { 
                                  while ($rows = $rs->fetch_assoc())
                                    {
                                      $sn = $sn + 1;
                                      echo"
                                        <tr>
                                          <td>".$sn."</td>
                                          <td>".$rows['className']."</td>
                                          <td><a href='?action=edit&Id=".$rows['Id']."'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                                          <td><a href='?action=delete&Id=".$rows['Id']."'><i class='fas fa-fw fa-trash'></i>Delete</a></td>
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
  <!-- //Scripts -->
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