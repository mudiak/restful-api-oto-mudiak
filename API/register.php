<?php

include 'koneksi.php';
$aksi = $_GET['aksi'];

if($aksi=='db'){
$id_customer = $_POST['id_customer'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$path_picture ="uploads/$id_customer.jpg";

if($id_customer == '' ||  $name == '' ||$email == '' ||$password == '' || $path_picture == ''){
    echo 'Tidak Boleh kosong';
}else{
    $sql = mysqli_query($koneksi,"INSERT INTO `customers` (`id_customer`, `name`, `email`, `password`, `path_picture`,`wallet`) 
                            VALUES ('$id_customer', '$name', '$email', MD5('$password'), '$path_picture',0);");
if($sql){
    // include 'mail.php';
    echo json_encode(array('response'=>'Sign up user berhasil ','kode'=> 1));
        }
        else{ 
            echo json_encode(array('response'=>'Sign up user Gagal ','kode'=> 100));

        }
       
}
}elseif($aksi='uploadpict'){
    $return["error"] = false;
    $return["msg"] = "";
    //array to return
    
    if(isset($_POST["image"])){
        $name = $_POST['name'];
        $base64_string = $_POST["image"];
        $outputfile = "uploads/$name.jpg" ;
        //save as image.jpg in uploads/ folder
    
        $filehandler = fopen($outputfile, 'wb' ); 
        //file open with "w" mode treat as text file
        //file open with "wb" mode treat as binary file
        
        fwrite($filehandler, base64_decode($base64_string));
        // we could add validation here with ensuring count($data)>1
    
        // clean up the file resource
        fclose($filehandler); 
    }else{
        $return["error"] = true;
        $return["msg"] =  "No image is submited.";
    }
    
    header('Content-Type: application/json');
    // tell browser that its a json data
    echo json_encode($return);
    //converting array to JSON string
}