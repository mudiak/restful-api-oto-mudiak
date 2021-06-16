<?php
include 'koneksi.php';

$username = $_POST['username'];
$oldPassword = md5($_POST['oldPassword']);
$newPassword = md5($_POST['newPassword']);

$sqlcek = mysqli_query($koneksi,"SELECT * FROM customers 
            WHERE `id_customer` ='$username' AND `password`='$oldPassword'");

$cek = mysqli_num_rows($sqlcek);
if($cek > 0){

    $sql = mysqli_query($koneksi,"UPDATE `customers` 
    SET `password` = '$newPassword' WHERE `customers`.`id_customer` = '$username'");

    if($sql){
        echo json_encode(array('response'=>'Change Password Successfully','kode'=> 1));
    }

}else{
    echo json_encode(array('response'=>'Your Password is Wrong','kode'=> 101));
}


?>