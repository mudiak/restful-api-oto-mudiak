<?php

include 'koneksi.php';

$username = $_POST['username'];
$password =md5($_POST['password']);

$sql = mysqli_query($koneksi,"select * from customers where  id_customer ='$username' and password='$password' ");
$cek = mysqli_num_rows($sql);
if($cek > 0){
    $data = mysqli_fetch_Array($sql);
    $response['response'] = 'welcome';
    $response['kode'] = 1;
    $response['email'] = $data['email'];
    $response['name'] = $data['name'];
    $response['username'] = $data['id_customer'];
    $response['wallet'] = $data['wallet'];
    $response['pathPicture'] = $data['path_picture'];

    echo json_encode($response);
}else{
    echo json_encode(array('response'=>'Email/Username atau Password Anda Salah ','kode'=> 101));
}


