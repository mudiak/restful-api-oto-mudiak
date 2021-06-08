<?php

    include 'koneksi.php';
    $page = $_GET['page'];
    if($page=='list'){

    $skrg = date('Y-m-d');
    $sql = mysqli_query($koneksi,"SELECT 
        busagency.id_busagency as idagency,
        busagency.name_agency as nama, 
        busdetails.id_bus as id_bus, 
        busdetails.time as timestart, 
        busdetails.tgl as tgl, 
        timediff(busdetails.time_finish,busdetails.time) as lama,
        busdetails.start_address as startaddress,
        busdetails.destination_address as finishaddress,
        busdetails.price as price 
        from busdetails,busagency 
        WHERE busdetails.id_busagency = busagency.id_busagency and busdetails.tgl ='$skrg'");
    
    $cek = mysqli_num_rows($sql);
    if($cek >0){
      
        while($ambil = mysqli_fetch_assoc($sql)){
            // $bus["idagency"] = $ambil['idagency']; 
            // $bus["nama"] = $ambil['nama']; 
            // $bus["id_bus"] = $ambil['id_bus']; 
            // $mulai = strtotime($ambil['timestart']);
            // $selesai =strtotime($ambil['timefinish']);
            // $selisih = $selesai - $mulai;
            // $jam    =floor($selisih / (60 * 60));
            // $menit    =floor($selisih - $jam * (60 * 60))/60;
            // $lama = "".$jam."h ".$menit."m";
            // $bus["timestart"] = $ambil['timestart']; 
            // $bus["lama"] = $lama;
            // $bus["startaddress"] = $ambil['startaddress'];
            // $bus["finishaddress"] = $ambil['finishaddress'];
            // $bus["price"] = $ambil['price'];
            $data[] = $ambil;
            $json = json_encode($data);
           
        }
        
    }else{
        $data["idagency"]= "0";
        $data["nama"]= "0";
        $data["timestart"]= "0";
        $data["tgl"]= $skrg;
        $data["lama"]= "0";
        $data["startaddress"]= "0";
        $data["finishaddress"]= "0";
        $data["price"]= "0";
       
        // "nama": "Bahagia",
        // "id_bus": "B0101",
        // "timestart": "20:45:45",
        // "tgl": "2021-06-05",
        // "lama": "03:04:00",
        // "startaddress": "Limbanang",
        // "finishaddress": "Bukittinggi",
        // "price": "35000"
        $ambil[] = $data;
        $json = json_encode($ambil);
    }
    echo $json;
    

mysqli_close($koneksi);
    }elseif($page=='checkout'){
        $idorder=$_POST['idorder'];
        $idbus = $_POST['idbus'];
        $username = $_POST['username'];
        $seat = $_POST['seat'];
        $price = $_POST['price'];

        $sql = mysqli_query($koneksi,"INSERT INTO `orders` 
        (`idorder`,`id_bus`, `id_customer`, `seat_number`, `total_price`) 
        VALUES ('$idorder','$idbus', '$username', '$seat', '$price')");



        if($sql){
            $ambilsql = mysqli_query($koneksi,"select wallet from customers where id_customer='$username'");
            $ambil = mysqli_fetch_array($ambilsql);
            $wallet = 0;
            $wallet = (int)$ambil['wallet'];
          
                $updatewallet = $wallet - $price;

            
            $upwalletsql = mysqli_query($koneksi,"UPDATE `customers` SET `wallet` = '$updatewallet' WHERE `customers`.`id_customer` = '$username'");
            if($updatewallet){

                echo json_encode(array('response'=>'CheckOut Berhasil ','kode'=> 1));
            }
        }

        
    }elseif($page=='cekSeat'){
        $idbus = $_GET['idbus'];
        $sql = mysqli_query($koneksi,"select seat_number from orders where id_bus='$idbus'");
        $ceksql = mysqli_num_rows($sql);
        if($ceksql > 0){
            while($seat = mysqli_fetch_assoc($sql)){
                $data[] = $seat;
                $json = json_encode($data);
            }
        }else{
            $data["seat_number"]= "0";
            $json = json_encode($data);

        }
       
        echo $json;
    }elseif($page=='detail'){
        $idorder = $_GET['idorder'];
        $sql = mysqli_query($koneksi,"SELECT orders.idorder as idorder,
        busagency.name_agency as bus,
        busdetails.tgl as tgl,
        busdetails.time as time, 
        orders.seat_number as seat,
        orders.total_price as price,
        customers.name as nama,
        busdetails.start_address as start,
        busdetails.destination_address as finish 
        FROM orders,busdetails,busagency,customers 
        WHERE orders.id_bus = busdetails.id_bus and 
        orders.id_customer = customers.id_customer and 
        busdetails.id_busagency = busagency.id_busagency and 
        orders.idorder = '$idorder'");
        $ambil[] = mysqli_fetch_assoc($sql);
        $json = json_encode($ambil);
        echo $json;
        
    }
?>