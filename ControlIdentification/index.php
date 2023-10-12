<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';
require_once('../Includes/init.php');
require('../fpdf/fpdf.php');




function generateIdCard($addmission_number)
{
    global $conn;
    $rrw = getOrganizationInfo(); //organization information
    $addmission_number = input_cleaner($addmission_number);
    // Fetch the student record from the database
    // $query = mysqli_query($conn, "SELECT * FROM tblstudents WHERE Id = '$Id'");
    // $row = mysqli_fetch_array($query);
    $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,tblstudents.lastName,tblstudents.admissionNumber,tblstudents.dateCreated,tblstudents.stuProfile
      FROM tblstudents 
      INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
      INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId WHERE tblstudents.admissionNumber = '$addmission_number' ";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $font = "font/Roboto-Medium.TTF";
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

        //
        echo 'ID Generated';
        exit;
      }

    } else {
      echo 'No Data Found';
    }


}

?>