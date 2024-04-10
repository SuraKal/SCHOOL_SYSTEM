<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';
require('../fpdf/fpdf.php');




if (isset($_GET['Id'])) {
  $id = $_GET['Id'];

  // Fetch the student record from the database
  // $query = mysqli_query($conn, "SELECT * FROM tblstudents WHERE Id = '$Id'");
  // $row = mysqli_fetch_array($query);
  $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,tblstudents.lastName,tblstudents.admissionNumber,tblstudents.dateCreated,tblstudents.stuProfile
      FROM tblstudents 
      INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
      INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId WHERE tblstudents.Id = '$id' ";
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      $font = "font/Anton-Regular.ttf";
      $Coursefont = "font/Inter-Medium.ttf";
      $image = imagecreatefromjpeg('Img/Certeficate Templete.jpg');
      $color = imagecolorallocate($image, 34,38,75);

      //STUDENT NAME

      $name = $row['firstName'].' '.$row['lastName'];
      $textWidth = imagettfbbox(170, 0, $font, $name)[2] - imagettfbbox(170, 0, $font, $name)[0];
        // Calculate the x-coordinate for center alignment
        $centerX = (imagesx($image) - $textWidth) / 2;
        // Add the text with center alignment
        imagettftext($image, 170, 0, $centerX, 1550, $color, $font, $name);
        // 

      //ID
      
      $course = $row['className'];
      $unique = $name . '-' . $course;
      $textWidth = imagettfbbox(60, 0, $Coursefont, $course)[2] - imagettfbbox(60, 0, $Coursefont, $course)[0];
        // Calculate the x-coordinate for center alignment
        $centerX = (imagesx($image) - $textWidth) / 2;
        // Add the text with center alignment
        imagettftext($image, 60, 0, $centerX, 1985, $color, $Coursefont, $course);
// 1214
      //Date

      $Date = '2023-Aug-09';
    imagettftext($image, 59, 0, 1785, 2200, $color, $font, $Date);

      //JPEG
      imagejpeg($image, '../Certeficate/' . $unique .'.jpg');
      //PDF
      //PDF
$pdf = new FPDF('L', 'in', [11.7, 8.27]);
$pdf->AddPage();
$pdf->Image('../Certeficate/' . $unique . '.jpg',0,0,11.7,8.27);
      $pdf->Output('../Certeficate/' . $unique . '.pdf', 'F');

imagedestroy($image);
echo 'Certeficate Generated';
exit;
    }

  } else {
    echo 'No Data Found';
  }
}

?>