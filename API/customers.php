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
}elseif($page=='editwithfoto'){
    $return["error"] =false;
    $return["msg"] = "";
    //array to return
    
    if(isset($_POST["image"])){
        $id = $_POST['username'];
        
        $name = $_POST['name'];
        $base64_string = $_POST["image"];
        $outputfile = "uploads/$name".date('Y-m-d his').".jpg" ;
        //save as image.jpg in uploads/ folder
        $sqlcekfoto = mysqli_query($koneksi,"select path_picture as foto from customers where id_customer='$id'");
        $datafoto = mysqli_fetch_assoc($sqlcekfoto);
        if(unlink($datafoto['foto'])){
            $filehandler = fopen($outputfile, 'wb' ); 
            //file open with "w" mode treat as text file
            //file open with "wb" mode treat as binary file
            $cek =fwrite($filehandler, base64_decode($base64_string));
            // we could add validation here with ensuring count($data)>1
            if($cek){
            $email = $_POST['email'];
            $nama =$name;
            $foto = $outputfile;
            $sql = mysqli_query($koneksi,"UPDATE `customers` 
            SET `name` = '$nama',
             `email` = '$email',
              `path_picture` = '$foto' 
              WHERE `customers`.`id_customer` = '$id'");
              if($sql){
                  $sqldata = mysqli_query($koneksi,"select name,id_customer,email,wallet,path_picture as pathPicture from customers where id_customer='$id'");
                  $ambil = mysqli_fetch_assoc($sqldata);
                  $data = $ambil; 
                  $json = json_encode($data);
                  
                }
                
            }// clean up the file resource
            fclose($filehandler); 
        }
    
       
        
        
    }else{
        $return["error"] = true;
        $return["msg"] =  "No image is submited.";
        
    }
    
    header('Content-Type: application/json');
    // tell browser that its a json data
    echo ($json);

}elseif($page=='editwithoutfoto'){
    $id = $_POST['username'];
    $email = $_POST['email'];
    $nama =$_POST['name'];
    $sql = mysqli_query($koneksi,"UPDATE `customers` 
    SET `name` = '$nama',
     `email` = '$email'
      WHERE `customers`.`id_customer` = '$id'");
      if($sql){
        $sqldata = mysqli_query($koneksi,"select name,id_customer,email,wallet,path_picture as pathPicture from customers where id_customer='$id'");
        $ambil = mysqli_fetch_assoc($sqldata);
        $data = $ambil; 
      $json = json_encode($data);
        
        echo $json;
          
      }

}

?>