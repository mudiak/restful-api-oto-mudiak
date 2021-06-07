<?php
include 'koneksi.php';
$page = $_GET['page'];

if($page == '1'){
    $id_customer = $_GET['username'];
    $sql = mysqli_query($koneksi,"Select * from customers where id_customer='$id_customer'");
    if($data = mysqli_fetch_array($sql)){
        $response['response'] = 'welcome';
        $response['kode'] = 1;
        $response['email'] = $data['email'];
        $response['name'] = $data['name'];
        $response['username'] = $data['id_customer'];
        $response['pathPicture'] = $data['path_picture'];

        echo json_encode($response);
    }else{
        echo json_encode(array('response'=>'Username Tidak ditemukan ','kode'=> 101));
    }
}elseif($page=='wallet'){
    $id_customer = $_GET['username'];
    $sql = mysqli_query($koneksi,"Select id_customer as username,wallet from customers where id_customer='$id_customer'");
    $data = mysqli_fetch_array($sql);
    if($data){
        echo json_encode(array("balance"=>$data['wallet'],'username'=>"$data[username]"));
    }else{
        echo json_encode(array('response'=>'Username Tidak ditemukan ','kode'=> 101));
    }
    
}elseif($page=='nama'){
    $id_customer = $_GET['username'];
    $sql = mysqli_query($koneksi,"Select name  from customers where id_customer='$id_customer'");
    $data = mysqli_fetch_array($sql);
    if($data){
        echo json_encode(array("nama"=>$data['name']));
    }else{
        echo json_encode(array('response'=>'Username Tidak ditemukan ','kode'=> 101));
    }
}

?>