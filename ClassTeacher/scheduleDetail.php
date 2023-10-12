
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once('../Includes/init.php');
//Checking if the get has a value
if(isset($_GET['link'])){
      $link = $_GET['link'];
      $goLink = $link;
}else{
        $_SESSION['LINKnotFound'] = "link not found";
        header('Location: index.php');
                  exit;

}

$email = $_SESSION['emailAddress'];
$password = $_SESSION['password'];

if(isset($_GET['Id'])){
  $scheduleId = $_GET['Id'];
  $scheduleDetail = DetailSchedule($scheduleId); //Returns all the securtiy details 
  // print("<pre>");
  // print_r($scheduleDetail);
}




// Messages 
if(isset($_SESSION['reportHandle'])){
  $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Schedule handled Successfully!</div>";
  unset($_SESSION['reportHandle']);
}
if(isset($_SESSION['errorreportHandle'])){
  $statusMsg = "<div class='alert alert-danger'  style='margin-right:700px;'>Schedule not handled</div>";
  unset($_SESSION['errorreportHandle']);

}


// //Avaliablity 

// if($securityDetail["securityStatus"] == 1){ 
//   $avaliable = "<button class = 'btn-info ml-2'>Available for task</button>";
// }elseif($securityDetail["securityStatus"] == 0){ 
//   $avaliable = "<button class = 'btn-danger ml-2'>Un available for task</button>";
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
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <!-- Custom css -->
  <link rel="stylesheet" href="css/custom.css" type="text/css">


  <style>
    /* Style for inputs */
    .styleInput{
      border: 1px solid transparent;
      border-bottom-color: rgb(72, 145, 228) !important;
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
            <h1 class="h3 mb-0 text-gray-800">Report Information</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Report Info</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="container card mb-4" style="border: 1px solid silver; border-radius: 15px;">
                <div class="mt-2" id="status_message"><?php echo $statusMsg; ?></div>
                <div class="card-header mt-3 d-flex flex-row align-items-center justify-content-between" style="color: rgb(76, 62, 199)">
                  <h3 class="m-0 font-weight-bold ">Report Info</h3>
                </div>
                <div class="div">
                  
                  <form method="post">
                      <h5 class = "text-center">Report info</h5>
                      <hr>
                      
                    <div class="form-group row mb-2">
                        <!-- Report info  -->
                        <div class="col-xl-6 my-2 ">
                          <label class="form-control-label">Date Scheduled</label>
                            <input type="text" class="form-control styleInput" name="" value="<?php
                            echo $scheduleDetail['date'] ?>"  id="exampleInputFirstName" disabled>
                        </div>
                        <div class="col-xl-6 my-2">
                          <label class="form-control-label">Class</label>
                            <input type="text" class="form-control styleInput" name="Phone No" value="<?php echo $scheduleDetail['className'];?>" id="exampleInputFirstName" disabled>
                        </div>
                        <div class="col-xl-6 my-2">
                          <label class="form-control-label">Batch</label>
                            <input type="text" class="form-control styleInput" name="Phone No" value="<?php echo $scheduleDetail['classArmName'];?>" id="exampleInputFirstName" disabled>
                        </div>
                    </div>
                    <hr>
                    <h5 class = "text-center">Schedule Detail</h5>
                    <hr>
                    <div class="row">
                      <div class="col-xl-12 mb-2">
                          <label class="form-control-label">Tittle</label>
                          <input type="email" class="form-control styleInput" name="Registered" value="<?php echo $scheduleDetail['title'];?>" id="exampleInputFirstName" disabled>
                      </div>
                    <br>
                      <div class="col-xl-6 mb-2">
                          <label class="form-control-label">Class starts at:</label>
                          <input class="form-control" name="Registered" id="exampleInputFirstName" disabled value="<?php echo $scheduleDetail['timeFrom'];?>">
                      </div>
                      <div class="col-xl-6 mb-2">
                            <label class="form-control-label">Class ends at:</label>
                            <input class="form-control" name="Registered" id="exampleInputFirstName" disabled value="<?php echo $scheduleDetail['timeTo'];?>">
                      </div>
                      <div class="col-xl-6 mb-2">
                          <label class="form-control-label">Schedule Discription</label>
                          <textarea cols="1" rows="1" class="form-control" name="Registered" id="exampleInputFirstName" disabled>
                              <?php echo $scheduleDetail['description'];?>
                          </textarea>
                      </div>
                      <div class="col-xl-6 mb-2">
                            <label class="form-control-label">Reference Link</label>
                            <input class="form-control" name="Registered" id="exampleInputFirstName" disabled value="<?php echo $scheduleDetail['Reference'];?>"> 
                      </div>
                      <div class="col-xl-6 mb-2">
                            <label class="form-control-label">Supportive Note</label> <br>
                            <?php
                              if (file_exists($scheduleDetail['Doc'])) {
                                                      // Output a download link for the file
                                                      echo "<a href='download.php?file_path=".urlencode($scheduleDetail['Doc'])."'><i class='fas fa-fw fa-download'></i></a>";
                                                      
                                                  }else{
                                                    echo "<button class = 'btn-danger ml-2 disabled'>No note avaliable</button>";
                                                  }
                            
                            ?>
                      </div>
                    </div>
                    

                        <div class= "mr-4 row justify-content-between mt-3 ml-4">
                          <div>
                              <?php
                              echo "<a href= '$goLink' class = 'btn btn-danger mb-4 linkStyle text-end' id= '' >Close</a>"; 
                              ?>
                          </div>
                              
                        </div>
                      
                      
                      
                  </form>
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
    //Styling button link 
      
  </script>
</body>

</html>