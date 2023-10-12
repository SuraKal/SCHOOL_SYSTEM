
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once ('../Includes/init.php');

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $orgname=input_cleaner($_POST['orgName']);
    $phone=input_cleaner($_POST['phone']);
    $domain=input_cleaner($_POST['domain']);
    $supportEmail=input_cleaner($_POST['supportEmail']);
    //Organizations profile
    $name = $_FILES['img']['name'];
    $size = $_FILES['img']['size'];
    $type = $_FILES['img']['type'];

    $file_temp = $_FILES['img']['tmp_name'];
    $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($name, PATHINFO_EXTENSION);
    $file_path = '../Photo/' . $unique_name;
    move_uploaded_file($file_temp, $file_path);
    //Id templete
    $names = $_FILES['IdTem']['name'];
    $sizes = $_FILES['IdTem']['size'];
    $types = $_FILES['IdTem']['type'];
    $file_temps = $_FILES['IdTem']['tmp_name'];
    $unique_names = 'ID templete.' . pathinfo($names, PATHINFO_EXTENSION);
    $file_paths = '../Photo/' . $unique_names;
    if (move_uploaded_file($file_temps, $file_paths)) {
      $id_template_uploaded = true;
    }
    //Certeficate 
    $Certeficatename = $_FILES['Certeficate']['name'];
    $Certeficatesize = $_FILES['Certeficate']['size'];
    $Certeficatetype = $_FILES['Certeficate']['type'];
    $Certeficatefile_temp = $_FILES['Certeficate']['tmp_name'];
    $Certeficateunique_name = 'Certeficate templete.' . pathinfo($Certeficatename, PATHINFO_EXTENSION);
    $Certeficatefile_path = '../Photo/' . $Certeficateunique_name;
    if (move_uploaded_file($Certeficatefile_temp, $Certeficatefile_path)) {
      $id_template_uploaded = true;
    }

            $sql = "INSERT INTO orgtbl (name, orgProfile,IdTemplete,certefiTemplete,phone,domain,supportEmail)
                    VALUES ('$orgname', '$file_path', '$file_paths','$Certeficatefile_path','$phone','$domain','$supportEmail')";
                    if ($conn->query($sql) === TRUE) {
                    // Success message
    $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>";
                    
                    // echo "Profile saved successfully";
                } else {
                    // Error message
                    $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Error occur</div>";
                    
                }
}

//--------------------EDIT------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= input_cleaner($_GET['Id']);

        $query=mysqli_query($conn,"select * from orgtbl where Id ='$Id'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){

                $orgname=input_cleaner($_POST['orgName']);
                $phone=input_cleaner($_POST['phone']);
                $domain=input_cleaner($_POST['domain']);
                $supportEmail=input_cleaner($_POST['supportEmail']);

                // Organizations status
                $name = $_FILES['img']['name'];
                $size = $_FILES['img']['size'];
                $type = $_FILES['img']['type'];
                $file_temp = $_FILES['img']['tmp_name'];
                $unique_name = md5(uniqid(rand(), true)) . '.' . pathinfo($name, PATHINFO_EXTENSION);
                $file_path = '../Photo/' . $unique_name;
                move_uploaded_file($file_temp, $file_path);
                //
                //Id templete
                $names = $_FILES['IdTem']['name'];
                $sizes = $_FILES['IdTem']['size'];
                $types = $_FILES['IdTem']['type'];
                $file_temps = $_FILES['IdTem']['tmp_name'];
                $unique_names = 'ID templete.' . pathinfo($names, PATHINFO_EXTENSION);
                $file_paths = '../Photo/' . $unique_names;
                if (move_uploaded_file($file_temps, $file_paths)) {
                  $id_template_uploaded = true;
                }
                //Certeficate
                $Certeficatename = $_FILES['Certeficate']['name'];
                $Certeficatesize = $_FILES['Certeficate']['size'];
                $Certeficatetype = $_FILES['Certeficate']['type'];
                $Certeficatefile_temp = $_FILES['Certeficate']['tmp_name'];
                $Certeficateunique_name = 'Certeficate templete.' . pathinfo($Certeficatename, PATHINFO_EXTENSION);
                $Certeficatefile_path = '../Photo/' . $Certeficateunique_name;
                if (move_uploaded_file($Certeficatefile_temp, $Certeficatefile_path)) {
                  $id_template_uploaded = true;
                }


                //
                $query=mysqli_query($conn,"update orgtbl set name='$orgname',orgProfile='$file_path',IdTemplete='$file_paths',certefiTemplete='$Certeficatefile_path',phone = '$phone' ,domain='$domain',supportEmail='$supportEmail' 
                where Id='$Id'");
                if ($query) {
                    $statusMsg = "<div class='alert alert-sucess' style='margin-right:700px;'>Updated sucessfully</div>";
                    header('Location: organizationInfo.php');
                    exit;
                    
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
        $query = mysqli_query($conn,"SELECT Id,orgProfile FROM orgtbl WHERE Id='$Id'");
        // $query = "SELECT orgProfile FROM orgtbl WHERE Id = $Id";
        $row = mysqli_fetch_array($query);
        $profile_path = $row['orgProfile'];
        
          $query = mysqli_query($conn, "DELETE FROM orgtbl WHERE Id='$Id'");
          if ($query == TRUE) {
            header('Location: organizationInfo.php');
                    exit;
            
          } else {
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
            <h1 class="h3 mb-0 text-gray-800">Organization information</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Info</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Fill details</h6>
                      <div id="status_message"><?php echo $statusMsg; ?></div> 
                </div>
                <div class="card-body">
                  <!-- This is a form for collecting Organizations data, including name,and profile image. It also has two buttons - "Save" and "Update" - for creating new organization account and updating existing ones, respectively. -->
                  <form role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">Organization Name<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" required name="orgName" value="<?php echo $row['name'];?>" id="exampleInputFirstName">
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Organization Phone<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" required name="phone" value="<?php echo $row['phone'];?>" id="exampleInputFirstName">
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Organization Support email<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" required name="supportEmail" value="<?php echo $row['supportEmail'];?>" id="exampleInputFirstName">
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Organization Domain<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" required name="domain" value="<?php echo $row['domain'];?>" id="exampleInputFirstName">
                        </div>

                        <div class="col-xl-6">
                          <label class="form-control-label">Organization Logo<span class="text-danger ml-2">*</span> <span style='color:gray;opacity:0.5'>Only png,jpeg,jpg </span></label>
                          <input type="file" class="form-control"  name="img" id="exampleInputFirstName" accept=".jpg, .jpeg, .png" required>
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">ID Templete<span class="text-danger ml-2">*</span> <span style='color:gray;opacity:0.5'>Only jpg - 675/1125</span></label>
                          <input type="file" class="form-control"  name="IdTem"  id="exampleInputFirstName" accept=".jpg">
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Certeficate Templete<span class="text-danger ml-2">*</span> <span style='color:gray;opacity:0.5'>Only jpg- 3508/2480</span></label>
                          <input type="file" class="form-control"  name="Certeficate"  id="exampleInputFirstName" accept=".jpg">
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
                      <h6 class="m-0 font-weight-bold text-primary">Organization details</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Organization Name</th>
                            <th>Organization profile</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                      <?php
                          $query = "SELECT *
                          FROM orgtbl";
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
                                        <td>".$rows['name']."</td>
                                        <td style='width: 15%;'><img style='width:50px; height:50px;' class='img img-responsive' src='{$rows['orgProfile']}'></td> 
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