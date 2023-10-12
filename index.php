<?php 
ob_start();
include 'Includes/dbcon.php';
function input_cleaner($input){
        $input = trim($input); //eliminats any blank spaces
        $input = stripslashes($input); //eliminats back slash 
        $input = htmlspecialchars($input); //convert any special characters into html entities . see https://www.html.am/reference/html-special-characters.cfm
        return $input;
}
session_start();
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
    <title>Ennlite - Login</title>
    <!-- Link CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpe00g'); background-color: #29343f;">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <h5 align="center">ENNLITE SYSTEMS</h5>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 mt-3">Staff Login Panel</h1>
                                    </div>
                                    <!-- Select User  -->
                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                            <select required name="userType" class="form-control mb-3">
                                                <option value="">--Select User Roles--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="Sub-Administrator">Sub-Administrator</option>
                                                <option value="ClassTeacher">ClassTeacher</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
                                            <!-- <span class="eye-open">•</span> -->
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block" value="Login" name="login" />
                                        </div>
                                    </form>
                                    <?php
                                        if(isset($_POST['login'])){
                                            $userType = input_cleaner($_POST['userType']);
                                            $username = input_cleaner($_POST['username']);
                                            $password = $_POST['password'];
                                            // $password = hash('sha256', $password); //hash it later
                                            //If user is the admin
                                            if($userType == "Administrator"){
                                                $password = hash('sha256', $password);
                                                $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
                                                $rs = $conn->query($query);
                                                $num = $rs->num_rows;
                                                $rows = $rs->fetch_assoc();
                                                if($num > 0){
                                                    $_SESSION['userId'] = $rows['Id'];
                                                    $_SESSION['firstName'] = $rows['firstName'];
                                                    $_SESSION['lastName'] = $rows['lastName'];
                                                    $_SESSION['emailAddress'] = $rows['emailAddress'];
                                                    header('Location: Admin/index.php');
                                                    exit;
                                                    // echo "<script type = \"text/javascript\">
                                                    // window.location = (\"Admin/index.php\")
                                                    // </script>";
                                                }
                                                else{
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                    Invalid Username/Password!
                                                    </div>";
                                                }
                                            } //If user is sub-administrator
                                            else if($userType == "Sub-Administrator"){
                                                $password = hash('sha256', $password);
                                                $query = "SELECT * FROM tblsubadmin WHERE emailAddress = '$username' AND password = '$password'";
                                                $rs = $conn->query($query);
                                                $num = $rs->num_rows;
                                                $rows = $rs->fetch_assoc();
                                                if($num > 0){
                                                    $_SESSION['userId'] = $rows['Id'];
                                                    $_SESSION['firstName'] = $rows['firstName'];
                                                    $_SESSION['lastName'] = $rows['lastName'];
                                                    $_SESSION['emailAddress'] = $rows['emailAddress'];
                                                    header('Location: SubAdmin/index.php');
                                                    exit;
                                                    // echo "<script type = \"text/javascript\">
                                                    // window.location = (\"SubAdmin/index.php\")
                                                    // </script>";
                                                }
                                                else{
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                    Invalid Username/Password!
                                                    </div>";
                                                }
                                            } //If the user is a teacher
                                            else if($userType == "ClassTeacher"){
                                                $password = hash('sha256', $password);
                                                $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
                                                $rs = $conn->query($query);
                                                $num = $rs->num_rows;
                                                $rows = $rs->fetch_assoc();
                                                if($num > 0){
                                                    // Retrieve all classArmIds for the user from the database
                                                    $query = "SELECT classArmId FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
                                                    $rs = $conn->query($query);
                                                    // Initialize an empty array to store the classArmIds
                                                    $classArmIds = array();
                                                    // Loop through the result set and store the classArmIds in the array
                                                    while ($row = $rs->fetch_assoc()) {
                                                        $classArmIds[] = $row['classArmId'];
                                                    }
                                                    // Store the classArmIds array in a session variable with a dynamic key
                                                    $_SESSION['classArmIds_' . $rows['emailAddress'] . '_' . $rows['password']] = $classArmIds;
                                                    // Set other session variables for the user
                                                    $_SESSION['userId'] = $rows['Id'];
                                                    $_SESSION['firstName'] = $rows['firstName'];
                                                    $_SESSION['lastName'] = $rows['lastName'];
                                                    $_SESSION['emailAddress'] = $rows['emailAddress'];
                                                    $_SESSION['password'] = $rows['password'];
                                                    $_SESSION['classId'] = $rows['classId'];
                                                    $_SESSION['classArmId'] = $rows['classArmId'];
                                                    header('Location: ClassTeacher/index.php');
                                                    exit;
                                                }
                                                else{
                                                    // Display an error message if the login is unsuccessful
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                        Invalid Username/Password!
                                                        </div>";
                                                }
                                            }
                                            // else if($userType == "ClassTeacher"){
                                            //     $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
                                            //     $rs = $conn->query($query);
                                            //     $num = $rs->num_rows;
                                            //     $rows = $rs->fetch_assoc();
                                                
                                            //     if($num > 0){
                                            //         $_SESSION['userId'] = $rows['Id'];
                                            //         $_SESSION['firstName'] = $rows['firstName'];
                                            //         $_SESSION['lastName'] = $rows['lastName'];
                                            //         $_SESSION['emailAddress'] = $rows['emailAddress'];
                                            //         $_SESSION['password'] = $rows['password'];
                                            //         $_SESSION['classId'] = $rows['classId'];
                                            //         $_SESSION['classArmId'] = $rows['classArmId'];
                                            //         echo "<script type = \"text/javascript\">
                                            //         window.location = (\"ClassTeacher/index.php\")
                                            //         </script>";
                                            //     }
                                            //     else{
                                            //         echo "<div class='alert alert-danger' role='alert'>
                                            //         Invalid Username/Password!
                                            //         </div>";
                                            //     }
                                            // }
                                            
                                        }
                                    ?>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Student login -->
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Student Login Panel</h1>
                                    </div>
                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="username1" id="exampleInputEmail" placeholder="Enter Your Admission Number">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block " value="Login" name="Login" />
                                        </div>
                                    </form>
                                    <?php
                                        if(isset($_POST['Login'])){
                                            $username = input_cleaner($_POST['username1']);
                                            $query = "SELECT * FROM tblstudents WHERE admissionNumber = '$username'";
                                            $rs = $conn->query($query);
                                            $num = $rs->num_rows;
                                            $rows = $rs->fetch_assoc();
                                            if($num > 0){ //session is very important variable for the system 
                                                $_SESSION['userId'] = $rows['Id'];
                                                $_SESSION['firstName'] = $rows['firstName'];
                                                $_SESSION['lastName'] = $rows['lastName'];
                                                $_SESSION['classId'] = $rows['classId'];  
                                                $_SESSION['classArmId'] = $rows['classArmId'];
                                                header('Location: Student/index.php');
                                                exit;
                                                // echo "<script type = \"text/javascript\">
                                                //     window.location = (\"Student/index.php\")
                                                //     </script>";
                                            }
                                            else{
                                                echo "<div class='alert alert-danger' role='alert'>
                                                Unknown admission number!
                                                </div>";
                                            }
                                        }
                                        ob_end_flush();
                                    ?>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
</html>