<?php 
ob_start();
$file_name = basename($_GET['file_name']); // 
$file_path = realpath('/var/www/html/static/images/' . $file_name); 

$base_path = realpath('/var/www/html/static/images/');
if (strpos($file_path, $base_path) === 0 && file_exists($file_path)) {
    readfile($file_path);
} else { // Image file not found or invalid file path
    header('Location:404.php');
}