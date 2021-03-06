<?php 
require 'dbhandler.php';
session_start();
define('KB',  1024);
define('MB', 1048576);

if (isset($POST['prof-submit'])){

$uname = $_SESSION['uname'];
$file = $_FILES['prof-images'];
$file_name = ['uname'];
$file_tmp_name = $file['tmp_name'];
$file_error = $file['error'];
$file_size = $file['size'];


$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
$allowed = array('jpg', 'jpeg', 'png', 'svg');

if ($file_error  !==0) {
    header("Location: ../profile.php?error=UploadError");
exit();
}
if (!in_array($ext, $allowed)){
    header("Location: ../profile.php?error=InvalidType");
    exit();
}

if ($file_size >4*MB){
    header("Location: ../profile.php?error=FileSizeExceeded");
    exit();
}
else{
    $new_name = uniqid('' , true)."." .$ext;
    $destination = '../profiles/' .$new_name;
    $sql = "UPDATE profiles SET profpic='$destination' WHERE uname = '$uname'";
    mysqli_query($conn, $sqlImg);
    move_uploaded_file($file_tmp_name, $destination);
    header("Location: ../pofile.php?success=Uploadwin");
    exit();
}

}else{
    header("Location:../profile.php");
    exit();
}
