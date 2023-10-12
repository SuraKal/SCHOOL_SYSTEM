<!-- This file is important for downloading the uploaded files and it forces the browser to download the file -->
<?php
    if(!empty($_GET['file_path'])){
        $filename = basename($_GET['file_path']);
        $filepath = '../Certeficate/' . $filename;
        if(!empty($filename)&& file_exists($filepath)){
            header("Cache-Control:public");
            header("Content-Description:File Transfer");
            header("Content-Disposition: attachment; filename = $filename");
            header("Content-Type:application/zip");
            header("Content-Transfer-Emcoding: binary");
            readfile($filepath);
            exit;
        }
        else{
        echo "This file Does not exist";
        }

    }

?>
