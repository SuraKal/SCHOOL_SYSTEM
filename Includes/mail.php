<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';


function mailTeacher($user,$firstName,$lastName,$emailAddress,$password,$phoneNo,$className,$classArmName,$dateCreated){
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('en','phpmailer/language/');
    $mail->isHTML(true);
 
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'testmailsystem@gmail.com'; //Your gmail
    $mail->Password = ''; //ypur gmail app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('testmailsystem@gmail.com'); //Your gmail
    $mail->addAddress($emailAddress);
    $mail->Subject = "Form Submittion[]";


    $body = '
        <head>
            <style>
                body{
                    color: white;
                    font_size:19px;
                }
                #section{
                    background-color: rgb(68, 65, 65); 
                    border:1px solid rgb(148, 144, 144); padding:50px;
                }
                h2{
                    max-width:550px; 
                    border:1px solid transparent; 
                    background-color: rgb(116, 113, 113); 
                    color: white;
                    font-size: 16px;
                    padding: 10px;
                    text-transform: uppercase;

                }
                p{
                    padding-left: 10px;
                    color:white;
                    font-size:20px;
                    /* text-transform: uppercase; */
                }
                .link{
                    font_size:20px;
                }
                
            </style>
        </head>
        <body>
            <section id="section">
                <div>
                    <h2>Your Information</h2>
                </div>
                <div>
                    <h2>User</h2>
                    <p>'. $user .'</p>
                </div>
                <div>
                    <h2>Name</h2>
                    <p>'. $firstName .' '. $lastName.'</p>
                </div>
                <div>
                    <h2>Phone</h2>
                    <p>'. $phoneNo .'</p>
                </div>
                <div>
                    <h2>Email</h2>
                    <p>'. $emailAddress .'</p>
                </div>
                <div>
                    <h2>Password</h2>
                    <p>'. $password .'</p>
                </div>
                <div>
                    <h2>Your Class</h2>
                    <p>'. $className .'</p>
                </div>
                <div>
                    <h2>Your Batch</h2>
                    <p>'. $classArmName .'</p>
                </div>
                <div>
                    <h2>Assigned Date:</h2>
                    <p>'. $dateCreated .'</p>
                </div>
                
                <div>
                    <p class="link">Please go to the following link to have access: <a href="system.everlinkers.com">system.everlinkers.com</a></p>
                </div>
            </section>
        </body>
        </html>
        ';

    //Add file
    $mail->Body = $body;
    $mail->send();
    $mail->smtpClose();
}

function mailStudent($user,$firstName,$lastName,$admissionNumber,$className,$classArmName,$instructor,$file_path,$dateCreated,$email){
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('en','phpmailer/language/');
    $mail->isHTML(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'testmailsystem@gmail.com'; //Your gmail
    $mail->Password = ''; //ypur gmail app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('testmailsystem@gmail.com'); //Your gmail
    $mail->addAddress($email);
    $mail->Subject = "Form Submittion[]";


    $body = '
        <html>
        <head>
            <style>
                body{
                    color: white;
                }
                #section{
                    background-color: rgb(68, 65, 65); 
                    border:1px solid rgb(148, 144, 144); padding:50px;
                }
                h2{
                    max-width:550px; 
                    border:1px solid transparent; 
                    background-color: rgb(116, 113, 113); 
                    color: white;
                    font-size: 16px;
                    padding: 10px;
                    text-transform: uppercase;

                }
                p{
                    padding-left: 10px;
                    color:white;
                    font-size:20px;
                    /* text-transform: uppercase; */
                }
                .color{
                    color:#086ba5;
                    font-size:20px;
                }
                .color_white{
                    color:white;
                    font-size:20px;
                }
            </style>
        </head>
        <body>
            <section id="section">
                <div>
                    <h2>Your Information</h2>
                </div>
                <div>
                    <h2>User</h2>
                    <p>'. $user .'</p>
                </div>
                <div>
                    <h2>Name</h2>
                    <p>'. $firstName ." ". $lastName.'</p>
                </div>
                <div>
                    <h2>Addmission number</h2>
                    <p>'. $admissionNumber .'</p>
                </div>
                <div>
                    <h2>Email</h2>
                    <p class="color_white">'. $email .'</p>
                </div>

                <div>
                    <h2>Course </h2>
                    <p>'. $className .'</p>
                </div>
                <div>
                    <h2>Batch</h2>
                    <p>'. $classArmName .'</p>
                </div>
                <div>
                    <h2>Instructor Assgined</h2>
                    <p>'. $instructor .'</p>
                </div>
                <div>
                    <h2>Registration Date:</h2>
                    <p>'. $dateCreated .'</p>
                </div>

                <div class= "color">
                    Please go to the following link to have access: <a href="system.everlinkers.com">system.everlinkers.com</a>
                </div>
            </section>
        </body>
        </html>
        ';
    $mail->addAttachment($file_path, 'profile.jpg');
    //Add file
    $mail->Body = $body;
    $mail->send();
    $mail->smtpClose();

 
    // $mail = new PHPMailer(true);
    // $mail->CharSet = 'UTF-8';
    // $mail->setLanguage('en','phpmailer/language/');
    // $mail->isHTML(true);
 
    // $mail->isSMTP();
    // $mail->Host = 'smtp.gmail.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'testmailsystem@gmail.com'; //Your gmail
    // $mail->Password = ''; //ypur gmail app password
    // $mail->SMTPSecure = 'ssl';
    // $mail->Port = 465;
    // $mail->setFrom('testmailsystem@gmail.com'); //Your gmail
    // $mail->addAddress($email);
    // $mail->Subject = "Form Submission[]";


    // $body = '
    //     <html>
    //     <head>
    //         <style>
    //             body{
    //                 color: white;
    //             }
    //             #section{
    //                 background-color: rgb(68, 65, 65); 
    //                 border:1px solid rgb(148, 144, 144); padding:50px;
    //             }
    //             h2{
    //                 max-width:550px; 
    //                 border:1px solid transparent; 
    //                 background-color: rgb(116, 113, 113); 
    //                 color: white;
    //                 font-size: 16px;
    //                 padding: 10px;
    //                 text-transform: uppercase;

    //             }
    //             p{
    //                 padding-left: 10px;
    //                 color:white;
    //                 font-size:20px;
    //                 /* text-transform: uppercase; */
    //             }
    //             .color{
    //                 color:#086ba5;
    //                 font-size:20px;
    //             }
    //             .color_white{
    //                 color:white;
    //                 font-size:20px;
    //             }
    //         </style>
    //     </head>
    //     <body>
    //         <section id="section">
    //             <div>
    //                 <h2>Your Information</h2>
    //             </div>
    //             <div>
    //                 <h2>User</h2>
    //                 <p>'. $user .'</p>
    //             </div>
    //             <div>
    //                 <h2>Name</h2>
    //                 <p>'. $firstName ." ". $lastName.'</p>
    //             </div>
    //             <div>
    //                 <h2>Addmission number</h2>
    //                 <p>'. $admissionNumber .'</p>
    //             </div>
    //             <div>
    //                 <h2>Email</h2>
    //                 <p class="color_white">'. $email .'</p>
    //             </div>

    //             <div>
    //                 <h2>Course </h2>
    //                 <p>'. $className .'</p>
    //             </div>
    //             <div>
    //                 <h2>Batch</h2>
    //                 <p>'. $classArmName .'</p>
    //             </div>
    //             <div>
    //                 <h2>Instructor Assgined</h2>
    //                 <p>'. $instructor .'</p>
    //             </div>
    //             <div>
    //                 <h2>Registration Date:</h2>
    //                 <p>'. $dateCreated .'</p>
    //             </div>

    //             <div class= "color">
    //                 Please go to the following link to have access: <a href="system.everlinkers.com">system.everlinkers.com</a>
    //             </div>
    //         </section>
    //     </body>
    //     </html>
    //     ';
    // $mail->addAttachment($file_path, 'Profile.jpg'); //send the id card generated 
    // //Add file
    // $mail->Body = $body;
    // $mail->send();
    // $mail->smtpClose();













// $to = $email;
// $subject = " FORM SUBMISSION[]";

// $message = "
// <html>
//         <head>
//             <style>
//                 body{
//                     color: white;
//                 }
//                 #section{
//                     background-color: rgb(68, 65, 65); 
//                     border:1px solid rgb(148, 144, 144); padding:50px;
//                 }
//                 h2{
//                     max-width:550px; 
//                     border:1px solid transparent; 
//                     background-color: rgb(116, 113, 113); 
//                     color: white;
//                     font-size: 16px;
//                     padding: 10px;
//                     text-transform: uppercase;

//                 }
//                 p{
//                     padding-left: 10px;
//                     color:white;
//                     font-size:20px;
//                     /* text-transform: uppercase; */
//                 }
//                 .color{
//                     color:#086ba5;
//                     font-size:20px;
//                 }
//                 .color_white{
//                     color:white;
//                     font-size:20px;
//                 }
//             </style>
//         </head>
//         <body>
//             <section id='section'>
//                 <div>
//                     <h2>Your Information</h2>
//                 </div>
//                 <div>
//                     <h2>User</h2>
//                     <p>'. $user .'</p>
//                 </div>
//                 <div>
//                     <h2>Name</h2>
//                     <p>'. $firstName .' '. $lastName.'</p>
//                 </div>
//                 <div>
//                     <h2>Addmission number</h2>
//                     <p>'. $admissionNumber .'</p>
//                 </div>
//                 <div>
//                     <h2>Email</h2>
//                     <p class='color_white'>'. $email .'</p>
//                 </div>

//                 <div>
//                     <h2>Course </h2>
//                     <p>'. $className .'</p>
//                 </div>
//                 <div>
//                     <h2>Batch</h2>
//                     <p>'. $classArmName .'</p>
//                 </div>
//                 <div>
//                     <h2>Instructor Assgined</h2>
//                     <p>'. $instructor .'</p>
//                 </div>
//                 <div>
//                     <h2>Registration Date:</h2>
//                     <p>'. $dateCreated .'</p>
//                 </div>

//                 <div class= 'color'>
//                     Please go to the following link to have access: <a href='system.everlinkers.com'>system.everlinkers.com</a>
//                 </div>
//             </section>
//         </body>
//         </html>
// ";

// // Always set content-type when sending HTML email
// $headers = "MIME-Version: 1.0" . "\r\n";
// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// // More headers
// $headers .= 'From: <testmailsystem00@gmail.com>' . "\r\n";
// // $headers .= 'Cc: surafelkaleab68@gmail.com' . "\r\n";

// mail($to,$subject,$message,$headers);



}
function mailIdCard($filepath,$name,$email){
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('en','phpmailer/language/');
    $mail->isHTML(true);
 //made change
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'testmailsystem@gmail.com'; //Your gmail
    $mail->Password = ''; //ypur gmail app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('testmailsystem@gmail.com'); //Your gmail
    $mail->addAddress($email);
    $mail->Subject = "Acadamy[]";


    $body = '
        <head>
            <style>
                body{
                    color: white;
                }
                #section{
                    background-color: rgb(68, 65, 65); 
                    border:1px solid rgb(148, 144, 144); padding:50px;
                }
                h2{
                    max-width:550px; 
                    border:1px solid transparent; 
                    background-color: rgb(116, 113, 113); 
                    color: white;
                    font-size: 16px;
                    padding: 10px;
                }
            </style>
        </head>
        <body>
            <section id="section">
                <div>
                    <h2>Hello ' .$name. ' ,Here is your ID card. Please always have them when you come to our Acadamy.</h2>
                </div>
            </section>
        </body>
        </html>
        ';
    $mail->addAttachment($filepath, 'ID card.pdf'); //send the id card generated 
    //Add file
    $mail->Body = $body;
    $mail->send();
    $mail->smtpClose();
}
?>