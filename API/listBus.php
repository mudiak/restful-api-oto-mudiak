<?php

    include 'koneksi.php';

    $sql = mysqli_query($koneksi,"SELECT 
        busagency.id_busagency as idagency,
        busagency.name_agency as nama, 
        busdetails.id_bus as id_bus, 
        busdetails.time as timestart, 
        timediff(busdetails.time_finish,busdetails.time) as lama,
        busdetails.start_address as startaddress,
        busdetails.destination_address as finishaddress,
        busdetails.price as price 
        from busdetails,busagency 
        WHERE busdetails.id_busagency = busagency.id_busagency");
    
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
    }
    echo $json;
    

mysqli_close($koneksi);

?>