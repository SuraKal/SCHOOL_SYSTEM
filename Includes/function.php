<?php
require_once('init.php');
    //Function that is ging to clean very data that is passed to it 
function input_cleaner($input)
{
        $input = trim($input); //eliminats any blank spaces
        $input = stripslashes($input); //eliminats back slash 
        $input = htmlspecialchars($input); //convert any special characters into html entities . see https://www.html.am/reference/html-special-characters.cfm
        return $input;
}

// --------------------------------------Teacher-----------------------------------------------------------------------------//
// Email integration 

// Include Composer autoload file to load Resend SDK classes...
// Assign a new Resend Client instance to $resend variable, which is automatically autoloaded...
require __DIR__ . '/../vendor/autoload.php';

// Resend.com for email
function emailTeacher($emailAddress, $password,$firstName,$className,$classArmName,$checkTeacherExixts)
{
    $resend = Resend::client('');
    $adminInfo = getOrganizationInfo();
    // $checkTeacherExixts = checkTeacher($emailAddress); //this checks if teacher alredy exist in the acadamy
    if($checkTeacherExixts == 'Yes'){
        try {
        $result = $resend->emails->send([
            'from' => 'Acme <onboarding@resend.dev>',
            'to' => [$emailAddress],
            'subject' => 'Your New Class Assignment at Academy',
            'html' => '
            <html>
            <head>
            <style>
                body{
                    color: white;
                    font_size:19px;
                }

                
                
            </style>
        </head>
        <body>
            <section id="section">
                <h3>
                    Dear '.$firstName.', <br>

                    We hope this email finds you well. We are writing to inform you that a new class assignment has been allocated to you at Academy. We greatly appreciate your dedication and expertise, and we are confident that you will excel in this new teaching opportunity. <br> <br>

                    Here are the details of your new class assignment: <br>

                    Class: '.$className.' <br>
                    Batch: '.$classArmName.' <br> <br>

                    To access your updated instructor account and view your newly assigned class, please log in to the Academy Instructor Portal using your existing credentials. If you have forgotten your password or need any assistance, please click on the "Forgot Password" link on the login page. <br>

                    We encourage you to log in as soon as possible to familiarize yourself with the class details, review the syllabus, and begin preparing for your teaching responsibilities. Your knowledge and guidance will undoubtedly make a positive impact on the students in your care. <br>

                    Should you have any questions or require further support, please do not hesitate to contact our dedicated support team <a target="_black" href="mailto:'.$adminInfo['supportEmail'].'">here</a>. We are here to assist you throughout your teaching journey. <br> <br>

                    Thank you for your continued commitment to delivering high-quality education at Academy. We appreciate your valuable contributions and look forward to witnessing your success in this new class. <br> <br>

                    Best regards, <br>
                    Academy Administration
                </h3>
                
            </section>
        </body>
        </html>',
        ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            header('Location: createClassTeacher.php');
            exit;
        }
    }
    if($checkTeacherExixts == "No"){ //if teacher is not in the program we will send him/her a welcome message 
        try {
        $result = $resend->emails->send([
            'from' => 'Acme <onboarding@resend.dev>',
            'to' => [$emailAddress],
            'subject' => 'Welcome to Academy Instructor Portal!',
            'html' => '
            <html>
            <head>
            <style>
                body{
                    color: white;
                    font_size:19px;
                }

                
                
            </style>
        </head>
        <body>
            <section id="section">
                <h3>
                    Dear '.$firstName.', <br>

                    We are thrilled to welcome you to the Academy Instructor Portal! Your registration as an instructor has been successfully processed, and we are excited to have you on board. As an esteemed member of our teaching faculty, you will play a vital role in shaping the minds of our students. <br> <br>

                    Here are the details of your assignment: <br>

                    Class: '.$className.' <br>
                    Batch: '.$classArmName.' <br>
                    Email: '.$emailAddress.' <br>
                    Password: '.$password.' <br> <br>

                    To access your instructor account, please visit the following link: <a href = "'.$adminInfo['domain'].'">security.everlinkers.com</a>. This link will take you directly to your personalized dashboard where you can manage your classes, upload course materials, manage reports and engage with your students. <br>

                    We kindly request that you keep your login credentials confidential and not share them with anyone. Your account security is of utmost importance to us, and we want to ensure that only you have access to your instructor profile. <br>

                    If you have any questions or require assistance, please do not hesitate to reach out to our support team <a target="_black" href="mailto:'.$adminInfo['supportEmail'].'">here</a>. We are here to support you throughout your teaching journey at Academy. <br>

                    Once again, welcome to the Academy Instructor Portal! We look forward to witnessing your expertise and passion in action. <br>

                    Best regards, <br>
                    Academy Administration
                </h3>
                
            </section>
        </body>
        </html>',
        ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            header('Location: createClassTeacher.php');
            exit;
        }
    }
    
}

function updateTeacherMail($emailAddress,$firstName){
    $resend = Resend::client(''); //Your Clident ID
    $adminInfo = getOrganizationInfo();
    try {
        $result = $resend->emails->send([
            'from' => 'Acme <onboarding@resend.dev>',
            'to' => [$emailAddress],
            'subject' => 'Profile Update Alert',
            'html' => '
            <html>
            <head>
            <style>
                body{
                    color: white;
                    font_size:19px;
                }

                
                
            </style>
        </head>
        <body>
            <section id="section">
                <h3>
                    Dear '.$firstName.', <br>

                    We wanted to inform you that there have been updates to your information in the Academy system. <br>

                    Please review the above details and notify us promptly if any corrections or further updates are required. Contact our support team at <a target="_black" href="mailto:'.$adminInfo['supportEmail'].'">here</a> for assistance. Please visit the following link: <a href = "'.$adminInfo['domain'].'">security.everlinkers.com</a>.<br> <br>

                    Thank you for your cooperation. <br>

                    Best regards, <br>

                    Academy Administration
                </h3>
                
            </section>
        </body>
        </html>',
        ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            header('Location: createClassTeacher.php');
            exit;
        }
}


function checkTeacher($emailAddress){
    global $conn;
    $checkQuery = 'SELECT * FROM tblclassteacher WHERE emailAddress = ?';
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('s', $emailAddress);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) { //new to the system  
        return "No"; //Yes he is new to the system
    }else{
        return "Yes"; //already existing user 
    }
    // if ($result->num_rows = 1) { //this means the teacher alredy is in the program | 
    //     return "Yes"; //Yes he is on the system
    // }else{
    //     return "No"; //No he/she is not registered in the system
    // }
}

function teacherAssign($Id){ //Check if teacher is assigned to any class
    global $conn;
    $fetch_data = array();
    $select_check = "SELECT teacherId FROM tblclassarms WHERE teacherId=?";
    $stmt = $conn->prepare($select_check);
    $stmt->bind_param('s', $Id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $fetch_data = $row;
    }
        // $conn->close();
    $stmt->close();
    return $fetch_data;
}

// function deleteTeacherFromBatch($classArmId,$teacherId){
//     global $conn;
//     $teacherInfo = teacherInfo($teacherId);
//     $classArmIdOfTeacher = $teacherInfo['classArmId'];
//     $delimiter = ',';
//     $classArmIdCollection = 
//     //Explode the teachers classarmid and loop through and if $classArmId is equal to any of them exchange that into 0 EASY
//     $query = "SELECT Id,classArmId FROM tblclassteacher WHERE Id = ";
//                               $rs = $conn->query($query);
//                               $num = $rs->num_rows;
//                               $sn=0;
//                               $status="";
//                               if($num > 0)
//                               { 
//                                 while ($rows = $rs->fetch_assoc())
//                                   {

//                                   }
//                                 }
//                                 && $stmt_3->execute()
// }

// ------------------------------------------------Teacher------------------------------------------------------------------//
function getTeacher($classId, $classArmId){
    global $conn;
    $classArmId = input_cleaner($classArmId);
    $classId = input_cleaner($classId);
    $fetch_data = array();
    $select_detail = "SELECT * 
        FROM tblclassteacher
        Where tblclassteacher.classId = ? AND tblclassteacher.classArmId = ?";
    $stmt = $conn->prepare($select_detail);
    $stmt->bind_param("ss", $classId,$classArmId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fetch_data = $result->fetch_assoc();
    }
    
    $stmt->close();
    
    return $fetch_data;
    
}

function teacherInfo($Id){
    global $conn;
    $Id = input_cleaner($Id);
    $fetch_data = array();
    $select_detail = "SELECT * FROM tblclassteacher Where tblclassteacher.Id = ?";

    $stmt = $conn->prepare($select_detail);
    $stmt->bind_param("s", $Id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fetch_data = $result->fetch_assoc();
    }
    
    $stmt->close();
    
    return $fetch_data;
}
function teacherInfoByEmail($emailAddress){
    global $conn;
    $emailAddress = input_cleaner($emailAddress);
    $fetch_data = array();
    $select_id = "SELECT Id FROM tblclassteacher Where tblclassteacher.emailAddress = ?";

    $stmt = $conn->prepare($select_id);
    $stmt->bind_param("s", $emailAddress);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fetch_data = $result->fetch_assoc();
    }
    
    $stmt->close();
    
    return $fetch_data;
}
function registerTeacher($firstName,$lastName,$emailAddress,$InsertedPassword,$password,$phoneNo,$classId,$classArmId){
    //Alredy cleaned and passed to this function 
    global $conn;

    $dateCreated = date('y-m-d');

    $queryCheck = "SELECT emailAddress FROM tblclassteacher WHERE emailAddress = ?"; //Check if there is a teacher with this email
    $stmt = $conn->prepare($queryCheck);
    $stmt->bind_param('s', $emailAddress);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the class name already exists
  if ($result->num_rows > 0) {
            $_SESSION['userExists'] = 'Teacher alredy exists';
            header('Location: createClassTeacher.php');
            exit;
  } else {

    $queryInsert = mysqli_query($conn, "INSERT into tblclassteacher(firstName,lastName,emailAddress,password,phoneNo,classId,classArmId,dateCreated) 
    value('$firstName','$lastName','$emailAddress','$InsertedPassword','$phoneNo','$classId','$classArmId','$dateCreated')");

    if ($queryInsert) {

        $queryTeacher = teacherInfoByEmail($emailAddress); //Get teacher Id
        $selected_Teacher = $queryTeacher['Id'];
      // Update the tblclassarms table to indicate that the class arm has been assigned to a teacher
        $queryUpdate = mysqli_query($conn, "update tblclassarms set isAssigned='1',teacherId='$selected_Teacher' where Id ='$classArmId'");
        $user = "Instructor";

      // $checkTeacherExixts = checkTeacher($emailAddress);
      // emailTeacher($emailAddress, $password,$firstName,$className,$classArmName,$checkTeacherExixts);

      // mailTeacher($user,$firstName,$lastName,$emailAddress,$password,$phoneNo,$className,$classArmName,$dateCreated);
      if ($queryUpdate) {
        // // Retrieve the current classArmIds for the user from the session variable
        // $classArmIds = $_SESSION['classArmIds_' . $emailAddress . '_' . $password];
        // // Add the new classArmId value to the array
        // $classArmIds[] = $classArmId;

        // // Store the updated classArmIds array in the session variable
        // $_SESSION['classArmIds_' . $emailAddress . '_' . $password] = $classArmIds;

        $_SESSION['sucess'] = 'Request sucessfull';
            header('Location: createClassTeacher.php');
            exit;
      } else {
        $_SESSION['error'] = 'Registeration not sucessfull';
            header('Location: createClassTeacher.php');
            exit;
      }
    } else {
        $_SESSION['error'] = 'Registeration not sucessfull';
        header('Location: createClassTeacher.php');
        exit;
    }
  }
}

function addBatch($selected_Teacher,$firstName,$lastName,$emailAddress,$password,$phoneNo,$classId,$classArmId,$updatedListClassArms)
{
    global $conn;
    try {
        $queryCheck = "SELECT Id,emailAddress FROM tblclassteacher WHERE emailAddress = ? AND Id <>$selected_Teacher"; //Check if there is a teacher with this email, note that the selected teacher not in to consideration 
        $stmt = $conn->prepare($queryCheck);
        $stmt->bind_param('s', $emailAddress);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the class name already exists
        if ($result->num_rows > 0) {
            $_SESSION['userExists'] = 'Teacher alredy exists';
            header('Location: createClassTeacher.php');
            exit;
        } else {
            $queryAdd = "update tblclassteacher set firstName=?, lastName=?,
                emailAddress=?, password=?,phoneNo=?, classId=?,classArmId=?
                where Id=?";
            $stmt_2 = $conn->prepare($queryAdd);
            $stmt_2->bind_param('ssssssss', $firstName, $lastName, $emailAddress, $password, $phoneNo, $classId, $updatedListClassArms, $selected_Teacher);

            if ($stmt_2->execute()) {
                // updateTeacherMail($emailAddress,$firstName); //mail teacher that there is an update on his information 
                $qu = mysqli_query($conn, "update tblclassarms set isAssigned='1',teacherId='$selected_Teacher' where Id ='$classArmId'");
                if ($qu) {
                    $_SESSION['sucessAdding'] = 'Batch|classArm added sucessfully';
                    header('Location: createClassTeacher.php');
                    exit;
                } else {
                    $_SESSION['errorAdding'] = 'Batch|classArm not added';
                    header('Location: createClassTeacher.php');
                    exit;
                }
            } else {
                $_SESSION['errorAdding'] = 'Batch|classArm not added';
                header('Location: createClassTeacher.php');
                exit;
            }
        }
    }catch (\Exception $e) {
            // $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $_SESSION['errorAdding'] = 'Batch|classArm not added';
                header('Location: createClassTeacher.php');
                exit;
        }
}

// -------------------------------------------------------Class ----------------------------------------------------------------------------//
// Register class 
function classInfo($classId){
    global $conn;
    $classId = input_cleaner($classId);
    $fetch_data = array();
    $select_detail = "SELECT * FROM tblclass WHERE Id = '$classId'";
    $query = mysqli_query($conn, $select_detail);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
            $fetch_data= $row; //This will return as an assocative array
        }
    }
    return $fetch_data;
}
function classInfoName($classId){
    global $conn;
    $classId = input_cleaner($classId);
    $fetch_data = array();
    $select_detail = "SELECT className FROM tblclass WHERE Id = '$classId'";
    $query = mysqli_query($conn, $select_detail);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
            $fetch_data= $row; //This will return as an assocative array
        }
    }
    return $fetch_data;
}

function registerClass($className)
{
    global $conn;
    $className = input_cleaner($className);
    // Prepare the SELECT query
    $selectQuery = 'SELECT Id FROM tblclass WHERE className = ?';
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param('s', $className);
    $stmt->execute();
    $result = $stmt->get_result();
    // Check if the class name already exists
    if ($result->num_rows > 0) {
        $_SESSION['exists'] = 'Class alredy exists';
        header('Location: createClass.php');
        exit;
    }else{
        // Prepare the INSERT query
        $insertQuery = 'INSERT INTO tblclass (className) VALUES (?)';
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('s', $className);
        $stmt->execute();
        // Check if the class was successfully registered
        if ($stmt->affected_rows === 1) {
            $_SESSION['success'] = 'Class successfully registered';
            header('Location: createClass.php');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to register class';
            header('Location: createClass.php');
            exit;
        }
    }
    
}


function editClass($Id, $className){

    global $conn;
    $className = input_cleaner($className);
    $Id = input_cleaner($Id);
    try {
        $checkQuery = "SELECT Id from tblclass where className = ? AND Id <> ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('ss', $className, $Id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the class name already exists
        if ($result->num_rows > 0) {
            $_SESSION['exists'] = 'Class alredy exists';
            header('Location: createClass.php');
            exit;
        } else {

            $queryUpdate = "update tblclass set className=? where Id=?"; //Updates the class by there id 
            $stmt = $conn->prepare($queryUpdate);
            $stmt->bind_param('ss', $className, $Id);
            
            if ($stmt->execute()) {
                $_SESSION['sucessUpdate'] = 'Updated';
                header('Location: createClass.php');
                exit;
            } else {
                $_SESSION['errorUpdate'] = 'not Updated';
                header('Location: createClass.php');
                exit;
            }

        }
    }catch (Exception $e) { //If there is any error 
        // Handle the exception/error here
        $_SESSION['errorUpdate'] = "Error: " . $e->getMessage(); //shows error effectivly 
        header('Location: createClass.php');
        exit;
    } 
}

function deleteClass($Id)
{
    global $conn;
    $Id = input_cleaner($Id);
    $queryDelete = "DELETE FROM tblclass WHERE Id=?"; // Deleting class based on the Id selected(row selected)
    $stmt = $conn->prepare($queryDelete);
    $stmt->bind_param('s', $Id);

    if ($stmt->execute()) { //If class is deleted no need for the students information 
        $queryDeleteBatch = "DELETE FROM tblclassarms WHERE classId=?"; // Deleting Students that are in that class
            $stmt_4 = $conn->prepare($queryDeleteBatch);
            $stmt_4->bind_param('s', $Id);

        if ($stmt_4->execute()) { //If deleting class arm is sucessfull
            $queryDeleteStudent = "DELETE FROM tblstudents WHERE classId=?"; // Deleting Students that are in that class
            $stmt_2 = $conn->prepare($queryDeleteStudent);
            $stmt_2->bind_param('s', $Id);

            // Delete attendance record
            $queryDeleteAttendanceRecord = "DELETE FROM tblattendance WHERE classId=?"; // Deleting Attendance record of that class
            $stmt_3 = $conn->prepare($queryDeleteAttendanceRecord);
            $stmt_3->bind_param('s', $Id);

            // // Befor deleting the student record ,Below is deleting students profile, ID card and Certeficate from the system
            // $queryDeleteStudentInfo = "SELECT tblstudents.Id,tblstudents.classId,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
            //                     tblstudents.lastName,tblstudents.admissionNumber,tblstudents.dateCreated,tblstudents.email
            //                     FROM tblstudents
            //                     INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
            //                     INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId WHERE tblstudents.classId = '$Id'"; // Deleting Students in that class
            // $rs = $conn->query($queryDeleteStudentInfo);
            // $num = $rs->num_rows;
            // // $row = $rs->fetch_assoc();
            // if ($num > 0) {
            //     while ($row = $rs->fetch_assoc()) {
            //             $firstName = $row['firstName'];
            //             $lastName = $row['lastName'];
            //             $className = $row['className'];
            //             $profile = $row['stuProfile'];


            //             $y = '../ID Cards/'.$firstName.' '.$lastName.'_'.$className.'.pdf';
            //             $z = '../Certeficate/'.$firstName.' '.$lastName.'-'.$className.'.pdf';
            //             $a = '../ID Cards/'.$firstName.' '.$lastName.'_'.$className.'.jpg';
            //             $b = '../Certeficate/'.$firstName.' '.$lastName.'-'.$className.'.jpg';

            //             if(file_exists($y) && file_exists($a)){
            //                 unlink($y);
            //                 unlink($a);
            //             }
            //             if(file_exists($z) && file_exists($b)){
            //                 unlink($z);
            //                 unlink($b);
            //             }

            //             if(file_exists($profile)){
            //                 unlink($profile);
            //             }
            //     }
            // }else{
            //     echo "Here";
            // }
            $query = "SELECT Id,classId,teacherId FROM tblclassarms WHERE classId = '$Id'";
            $rs = $conn->query($query);
            $num = $rs->num_rows;
            if ($num > 0) {
                while ($rows = $rs->fetch_assoc()) {
                    $teacherId = $rows['teacherId'];
                    $Id = $rows['Id'];
                    removeClassArmId($teacherId, $Id); //Remove Id form the list of teachers class arm Id 
                }
            }

            


            if($stmt_2->execute() && $stmt_3->execute()){ //Delete students and set the teacher to be assigned to another class
                $_SESSION['sucessDelete'] = 'Deleted';
                header('Location: createClass.php');
                exit;
            }else{
                $_SESSION['errorDelete'] = 'Deleted';
                header('Location: createClass.php');
                exit;
            }
        }
            

    } else {
            $_SESSION['errorDelete'] = 'Deleted error';
            header('Location: createClass.php');
            exit;
    }
    
}

//Get class 
function getClass($classId){
    global $conn;
    $classId = input_cleaner($classId);
    $fetch_data = array();
    $select_detail = "SELECT * FROM tblclass WHERE Id =?";
    $stmt = $conn->prepare($select_detail);
    $stmt->bind_param('s', $classId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $fetch_data = $row;
    }
        // $conn->close();
    $stmt->close();
    return $fetch_data;
}



// ----------------------------------Class arm| batch------------------------------------------------//
//Get class arm
function getClassArm($classArmId){
    global $conn;
    $classArmId = input_cleaner($classArmId);
    $fetch_data = array();
    $select_detail = "SELECT * FROM tblclassarms WHERE Id=?";
    $stmt = $conn->prepare($select_detail);
    $stmt->bind_param('s', $classArmId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $fetch_data = $row;
    }
        // $conn->close();
    $stmt->close();
    return $fetch_data;
}

function registerClassArm($classId, $classArmName){
    global $conn;
    $isAssigned = '0';
    $classId = input_cleaner($classId);
    $classArmName = input_cleaner($classArmName);

    $checkQuery="select * from tblclassarms where classArmName =? and classId = ?"; //Check if the class arm alredy exists
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('ss', $classArmName,$classId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the class name already exists
    if ($result->num_rows > 0) {
        $_SESSION['exists'] = 'Class alredy exists';
        header('Location: createClassArms.php');
        exit;
    }else{
        $queryInsert="insert into tblclassarms(classId,classArmName,isAssigned) value(?,?,?)";
        $stmt = $conn->prepare($queryInsert);
        $stmt->bind_param('sss', $classId,$classArmName,$isAssigned);
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Batch successfully registered';
            header('Location: createClassArms.php');
            exit;
        }else{
            $_SESSION['error'] = 'Batch registeration not sucessfull';
            header('Location: createClassArms.php');
            exit;
        }
    }
}

function updateClassArm($Id, $classId, $classArmName){
    global $conn;
    $classId = input_cleaner($classId);
    $classArmName = input_cleaner($classArmName);

                $checkQuery="select * from tblclassarms where classArmName =? and classId = ?"; //Check if the class arm alredy exists
                $stmt = $conn->prepare($checkQuery);
                $stmt->bind_param('ss', $classArmName,$classId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if the class name already exists
                if ($result->num_rows > 0) {
                    $_SESSION['existsBatch'] = 'Batch alredy exists';
                    header('Location: createClassArms.php');
                    exit;
                }else{
                    $query = mysqli_query($conn, "update tblclassarms set classId = '$classId', classArmName='$classArmName' where Id='$Id'");
                    if ($query) {
                        $_SESSION['successUpdate'] = 'Batch successfully updated';
                        header('Location: createClassArms.php');
                        exit;
                    } else {
                        $_SESSION['error'] = 'Update not sucessfull!!';
                        header('Location: createClassArms.php');
                        exit;
                    }
                }
}

function removeClassArmId($teacherId,$Id){ //Id ia the class arms Id 
    global $conn;
    $teacherInfo = teacherInfo($teacherId); //get teachers info
            $classArmTeacher = $teacherInfo['classArmId']; //select list of class arm ids the teacher teachs
            $updatedList = implode(',', array_diff(explode(',', $classArmTeacher), [$Id])); //Delete the batch from the list of classArms of the teachers classArmId coloumn .
            
            // New list of class arm ids of the teacher is added to that teacher 
            $queryUpdateTeacher = mysqli_query($conn, "UPDATE tblclassteacher SET classArmId = '$updatedList' WHERE Id = '$teacherId'");
}
function deleteBatch($classArmId,$teacherId){
    global $conn;
    $Id = input_cleaner($classArmId); //batchs class arm Id 
    $queryDelete = "DELETE FROM tblclassarms WHERE Id=?"; // Deleting class based on the Id selected(row selected)
    $stmt = $conn->prepare($queryDelete);
    $stmt->bind_param('s', $Id);

    if ($stmt->execute()) { //If class is deleted no need for the students information 
            $queryDeleteStudent = "DELETE FROM tblstudents WHERE classArmId=?"; // Deleting Students that are in that batch
            $stmt_2 = $conn->prepare($queryDeleteStudent);
            $stmt_2->bind_param('s', $Id);

                        // Delete attendance record
            $queryDeleteAttendanceRecord = "DELETE FROM tblattendance WHERE classArmId=?"; // Deleting Attendance record of that class
            $stmt_3 = $conn->prepare($queryDeleteAttendanceRecord);
            $stmt_3->bind_param('s', $Id);

            // // Befor deleting the student record ,Below is deleting students profile, ID card and Certeficate from the system
            // $queryDeleteStudentInfo = "SELECT tblstudents.Id,tblstudents.classId,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
            //                     tblstudents.lastName,tblstudents.admissionNumber,tblstudents.dateCreated,tblstudents.email
            //                     FROM tblstudents
            //                     INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
            //                     INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId WHERE tblstudents.classId = '$Id'"; // Deleting Students in that class
            // $rs = $conn->query($queryDeleteStudentInfo);
            // $num = $rs->num_rows;
            // // $row = $rs->fetch_assoc();
            // if ($num > 0) {
            //     while ($row = $rs->fetch_assoc()) {
            //             $firstName = $row['firstName'];
            //             $lastName = $row['lastName'];
            //             $className = $row['className'];
            //             $profile = $row['stuProfile'];


            //             $y = '../ID Cards/'.$firstName.' '.$lastName.'_'.$className.'.pdf';
            //             $z = '../Certeficate/'.$firstName.' '.$lastName.'-'.$className.'.pdf';
            //             $a = '../ID Cards/'.$firstName.' '.$lastName.'_'.$className.'.jpg';
            //             $b = '../Certeficate/'.$firstName.' '.$lastName.'-'.$className.'.jpg';

            //             if(file_exists($y) && file_exists($a)){
            //                 unlink($y);
            //                 unlink($a);
            //             }
            //             if(file_exists($z) && file_exists($b)){
            //                 unlink($z);
            //                 unlink($b);
            //             }

            //             if(file_exists($profile)){
            //                 unlink($profile);
            //             }
            //     }
            // }else{
            //     echo "Here";
            // }

            removeClassArmId($teacherId, $Id);
            if($stmt_2->execute() && $stmt_3->execute()){ //Delete students
                // Select from teachers with the teacher id is there Id and loop through it to make that specifc classarmId to 0 
                // deleteTeacherFromBatch($classArmId,$teacherId);
                $_SESSION['sucessDelete'] = 'Deleted';
                header('Location: createClassArms.php');
                exit;
            }else{
                $_SESSION['errorDelete'] = 'Deleted';
                header('Location: createClassArms.php');
                exit;
            }

    } else {
            $_SESSION['errorDelete'] = 'Deleted error';
            header('Location: createClassArms.php');
            exit;
    }
}




// -------------------------------Organization info---------------------------------------------------------------------------//
function getOrganizationInfo(){
    global $conn;
    $fetch_data = array();
    $selectQuery = "SELECT *
                FROM orgtbl";
    $query = mysqli_query($conn, $selectQuery);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
            $fetch_data = $row; //This will return as an assocative array
        }
    }
    return $fetch_data;
}

// ----------------------------------------------view Report Admin ------------------------------------------------------------------//
function reportDetailAdmin($reportId){
    global $conn;
    $reportId = input_cleaner($reportId);
    $fetch_data = array();
    $select_detail = "SELECT *,tblreport.Id,tblclass.className,tblclassarms.classArmName,tblclassteacher.Id,tblclassteacher.firstName,tblclassteacher.lastName
                                FROM tblreport
                                INNER JOIN tblclassteacher ON tblclassteacher.Id = tblreport.teacherId
                                INNER JOIN tblclass ON tblclass.Id = tblreport.classId
                                INNER JOIN tblclassarms ON tblclassarms.Id = tblreport.classArmId
                                WHERE tblreport.staff = '3' AND tblreport.Id = '$reportId'";
                            
    $query = mysqli_query($conn, $select_detail);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
            $fetch_data = $row; //This will return as an assocative array
        }
    }
    return $fetch_data;
}


// -----User - Teacher side 

// -----------------------------------------Take attandance -------------------------------------------------------------------------//

function getStudentsByClassArmId($classArmId){ //Select all students that are in that class arm 
    global $conn;
    $classArmId = input_cleaner($classArmId);

    $fetch_students = array();
    $query_select = "SELECT admissionNumber,classArmId,classId FROM tblstudents WHERE classArmId = ?";
    $stmt = $conn->prepare($query_select);
    $stmt->bind_param('s', $classArmId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $fetch_students[] = $row;
    }
        // $conn->close();
    $stmt->close();
    return $fetch_students;







}

function takeAttendance($studentAddmission_Number, $classId, $classArmId, $status, $currentDate){
    global $conn;
    try {
        // // Prepare the SELECT query
        // $lastDateTaken = substr($currentDate, 0, -16); //The last day the attendance was taken 
        $time = date('h:m:s');
        $selectQuery = 'SELECT Id,admissionNo FROM tblattendance WHERE admissionNo = ? AND classArmId = ? and dateTimeTaken=?';
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param('sss' ,$studentAddmission_Number,$classArmId,$currentDate);
        $stmt->execute();
        $result = $stmt->get_result();

        // // Check if the class name already exists
        if ($result->num_rows != 0) {
            $_SESSION['alredyTaken'] = 'Attendance taken for the day';
            header('Location: takeAttendance.php');
            // exit;
        } else {

            // Prepare the INSERT query
            $qqueryInsert = "INSERT INTO tblattendance (admissionNo,classId,classArmId,status,time,dateTimeTaken) VALUES (?,?,?,?,?,?)";

            $stmt = $conn->prepare($qqueryInsert);
            $stmt->bind_param('ssssss', $studentAddmission_Number, $classId, $classArmId, $status,$time,$currentDate);

            // Check if the class was successfully registered
            if ($stmt->execute()) {
                $_SESSION['sucess'] = 'Added sucessfully';
                header('Location: takeAttendance.php');
                // exit;
            } else {
                $_SESSION['tryAgain'] = 'Failed to add';
                header('Location: createClass.php');
                // exit;
            }
        }
        }
    catch (Exception $e) { //If there is any error 
                // Handle the exception/error here
                    // $_SESSION['fail'] = "Error";
                    $_SESSION['fail'] = $e->getMessage();
                    header('Location: takeAttendance.php');
                    // exit;
            }


}




function handleReport($reportId,$goLink){ //reportid for changeing status and goLink for close btn on detail
    global $conn;
    $reportId = input_cleaner($reportId);
    $query=mysqli_query($conn,"update tblreport set status='1'
                where Id='$reportId'");
                        if ($query) {
                            $_SESSION['reportHandle'] = "report Hanled";
                            echo "<script type = \"text/javascript\">
                            window.location = (\"viewReport.php?Id=$reportId &link=$goLink\");
                            </script>"; 
                        }
                        else
                        {
                            $_SESSION['errorreportHandle'] = "report failed";
                            echo "<script type = \"text/javascript\">
                            window.location = (\"viewReport.php?Id = $reportId&link=$goLink\");
                            </script>";
                        }

}
// ----------------------------------------------view Report teacher ------------------------------------------------------------------//

function reportDetailTeacher($reportId){ //going to get the report information about the report that was sent to the teacher
    global $conn;
    $reportId = input_cleaner($reportId);
    $fetch_data = array();
    $select_detail = "SELECT *,tblclass.className,tblclassarms.classArmName
                                FROM tblreport
                                INNER JOIN tblclass ON tblclass.Id = tblreport.classId
                                INNER JOIN tblclassarms ON tblclassarms.Id = tblreport.classArmId
                                WHERE tblreport.staff = '2' AND tblreport.Id = '$reportId'";
                            
    $query = mysqli_query($conn, $select_detail);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
            $fetch_data = $row; //This will return as an assocative array
        }
    }
    return $fetch_data;
}

function getTeacherId($studentClassArm){
    global $conn;
    $fetch_data = array();
    $select_detail = "SELECT Id, classArmId FROM tblclassteacher";
    $stmt = $conn->prepare($select_detail);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fetch_data[] = $row;
        }
    }
        //     print "<pre>";
        // print_r($fetch_data);
    $specific_batch_of_teacher = '';
    // fetch data contains all teachers information 
    foreach($fetch_data as $teacher){ //for each teachers data name them as teacher
        $classArmIdCollection = $teacher['classArmId'];  //Assign teachers class arm Id
        $Id = $teacher['Id']; //assign teachers Id
        $delimiter = ',';
        $classArmId = explode($delimiter, $classArmIdCollection); //Convert the teachers classArmId collection into an array 
        // print "<pre>";
        // print_r($classArmId);
        if (in_array($studentClassArm, $classArmId, true)) { //check if the students class arm Id is found we will send teachers Id 
                return $Id;
        }
        // for($i=0;$i<count($classArmId);$i++){ //loop through the array of class arm Ids
        //     $specific_batch_of_teacher = $classArmId[$i]; //Assign the class arm Id to specific batch
        //     if($specific_batch_of_teacher == $studentClassArm){ //if the teachers class arm is equal to the students session class arm we will return the teachers Id 
        //         // echo $Id;
        //     }

        // }

    }
    // print "<pre>";
    // print_r($fetch_data);
    // $stmt->close();
    // return $fetch_data;
}


// ----------------------------------------------View schedule--------------------------------------------------------------------------//
function DetailSchedule($scheduleId){
    global $conn;
    $fetch_data = array();
    $select_detail = "SELECT *,tblschedules.Id,tblclassarms.classArmName,tblclass.className
                                        FROM tblschedules
                                        INNER JOIN tblclass ON tblclass.Id = tblschedules.classId
                                        INNER JOIN tblclassarms ON tblclassarms.Id = tblschedules.classarmId WHERE tblschedules.Id = ?";
    $stmt = $conn->prepare($select_detail);
    $stmt->bind_param('s', $scheduleId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $fetch_data = $row;
    }
    $stmt->close();
    return $fetch_data;
}

function generateIdCard($addmission_number)
{
    //gd library is needed to sucessfully generate id card 
    global $conn;

    $rrw = getOrganizationInfo(); //organization information
    
    $addmission_number = input_cleaner($addmission_number);
      $query = "SELECT *,tblclass.Id,tblclassarms.Id,tblclass.className,tblclassarms.classArmName
                FROM tblstudents
                INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId WHERE tblstudents.admissionNumber = '$addmission_number'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

        $font = "../ControlIdentification/font/Roboto-Medium.TTF";
        $image = imagecreatefromjpeg('../Photo/ID templete.jpg');
        $color = imagecolorallocate($image, 255, 255, 255);
        $Stucolor = imagecolorallocate($image, 51, 49, 50);
        $IDcolor = imagecolorallocate($image, 69, 67, 68);

        //Tittle

        $Acaname = $rrw['name']; //Ennlite 
// imagettftext($image, 30, 0, 175, 260, $color, $font, $Acaname);
        $textWidth = imagettfbbox(30, 0, $font, $Acaname)[2] - imagettfbbox(30, 0, $font, $Acaname)[0];
        // Calculate the x-coordinate for center alignment
        $centerX = (imagesx($image) - $textWidth) / 2;
        // Add the text with center alignment
        imagettftext($image, 30, 0, $centerX, 260, $color, $font, $Acaname);

        //STUDENT NAME

        $name = $row['firstName'] . ' ' . $row['lastName'];
        imagettftext($image, 25, 0, 225, 829, $Stucolor, $font, $name);

        //ID number

        $IDname = $row['admissionNumber'];
        imagettftext($image, 18, 0, 225, 862, $IDcolor, $font, $IDname);

        //ID

        $course = $row['className'];
        imagettftext($image, 22, 0, 285, 949, $Stucolor, $font, $course);
        $Unique = $name . '_' . $row['className'];
        //Batch

        $Batch = $row['classArmName'];
        imagettftext($image, 22, 0, 290, 999, $Stucolor, $font, $Batch);

        //Date

        $Date = $row['dateCreated'];
        imagettftext($image, 22, 0, 390, 1050, $Stucolor, $font, $Date);


        //Logo
        $str = null;
        if (strtolower(pathinfo($rrw['orgProfile'], PATHINFO_EXTENSION)) == 'jpeg' || strtolower(pathinfo($rrw['orgProfile'], PATHINFO_EXTENSION)) == 'jpg') {
            $str = imagecreatefromjpeg($rrw['orgProfile']);
        } elseif (strtolower(pathinfo($rrw['orgProfile'], PATHINFO_EXTENSION)) == 'png') {
            $str = imagecreatefrompng($rrw['orgProfile']);
        }
        // $str = imagecreatefromjpeg($rrw['orgProfile']);
        // Get the dimensions of the logo image
        if ($str !== null) {
            $str_width = imagesx($str);
            $str_height = imagesy($str);
            // Calculate the maximum and minimum width for the logo image
            $max_width = 200; // Maximum width
            $min_width = 100; // Minimum width
            // Calculate the new dimensions of the logo image to fit within the height of 100
            $new_width = round($str_width * (100 / $str_height));
            $new_height = 100;
            // Adjust the width to meet the minimum and maximum width requirements
            if ($new_width < $min_width) {
                $new_width = $min_width;
            } else if ($new_width > $max_width) {
                $new_width = $max_width;
                $new_height = round($str_height * ($max_width / $str_width));
            }
            // Adjust the height to be 100 if it is less than 100
            if ($new_height < 100) {
                $new_height = 100;
                $new_width = round($str_width * (100 / $str_height));
            }
            // Resize the logo image to the new dimensions
            $new_str = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_str, $str, 0, 0, 0, 0, $new_width, $new_height, $str_width, $str_height);
            // Copy the resized logo image to the destination image, centered horizontally and at y-coordinate 100
            $x = (imagesx($image) - $new_width) / 2; // calculate the x-coordinate for centering
            imagecopy($image, $new_str, $x, 100, 0, 0, $new_width, $new_height);


        }

        //Student profile
        // Load the student profile image
        $stuProfile = null;
        if (strtolower(pathinfo($row['stuProfile'], PATHINFO_EXTENSION)) == 'jpeg' || strtolower(pathinfo($row['stuProfile'], PATHINFO_EXTENSION)) == 'jpg') {
                $stuProfile = imagecreatefromjpeg($row['stuProfile']);
            } elseif (strtolower(pathinfo($row['stuProfile'], PATHINFO_EXTENSION)) == 'png') {
                $stuProfile = imagecreatefrompng($row['stuProfile']);
            }
            if ($stuProfile !== null) {
            // Resize the student profile image to 300x300
                $new_stuProfile = imagecreatetruecolor(300, 300);
                imagecopyresampled($new_stuProfile, $stuProfile, 0, 0, 0, 0, 300, 300, imagesx($stuProfile), imagesy($stuProfile));
                // Calculate the x-coordinate for centering the student profile image
                $x = (imagesx($image) - 300) / 2;
                // Copy the resized student profile image to the destination image at position (x, 450)
                imagecopy($image, $new_stuProfile, $x, 450, 0, 0, 300, 300);
            }

        //
        //JPEG
        imagejpeg($image, '../ID Cards/' . $Unique . '.jpg');
        //PDF
        //PDF
        $pdf = new FPDF('p', 'in', [8.27, 11.7]);
        $pdf->AddPage();

        $pdf->Image('../ID Cards/' . $Unique . '.jpg', 0, 0, 8.27, 11.7);
        $pdf->Output('../ID Cards/' . $Unique . '.pdf', 'F');


        //
        $pdffile = '../ID Cards/' . $Unique . '.pdf';


        imagedestroy($image);
        //

        
        echo "<script type = \"text/javascript\">
                            window.location = (\"createStudents.php\");
                            </script>"; 
        exit;
      }

    } else {
      echo 'No Data Found';
    }

    return "Generated";

}







?>