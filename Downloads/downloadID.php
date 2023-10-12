<!-- This file is important for downloading the uploaded files and it forces the browser to download the file -->
<?php
    require_once("../Includes/init.php");
    if(!empty($_GET['file_path'])){
        $filename = basename($_GET['file_path']);
        $filepath = '../ID Cards/' . $filename;
        if(!empty($filename) && file_exists($filepath)){
            header("Cache-Control:public");
            header("Content-Description:File Transfer");
            header("Content-Disposition: attachment; filename = $filename");
            header("Content-Type:application/zip");
            header("Content-Transfer-Emcoding: binary");
            readfile($filepath);
            $name = "";
            $email = "";
            if(isset($_GET['studentName'])&& isset($_GET['studentEmail'])){
                $name = $_GET['studentName'];
                $email = $_GET['studentEmail'];
                mailIdCard($filepath, $name, $email);
            }
            exit;
        }
        else{
        // Return an error message as a query parameter in the URL
        header("Location: createStudent.php?error_message=Error downloading student ID card file!");
        exit;
        }
    }

?>
