<?php
// Check if the file path parameter is set
if (!isset($_GET['file_path'])) {
    die("File path parameter missing.");
}

// Get the file path from the URL query string
$file_path = $_GET['file_path'];

// Check if the file exists
if (!file_exists($file_path)) {
    die("File not found.");
}

// Set the headers to force a file download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');

// Output the file content
readfile($file_path);
?>