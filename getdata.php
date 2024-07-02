<?php

$con = mysqli_connect("localhost","root","","train_list");

    if(mysqli_connect_error()){
        echo mysqli_connect_error();
    }

    if(isset($_POST['action']) && $_POST['action']=='getstations'){
        // echo $_POST['keyword'];
        $stations=[];
        $keyword = $_POST['keyword'];
        $res = mysqli_query($con, "select * from stations where 
        station_code like '%".$keyword."%' 
        or station_name like '%".$keyword."%' limit 10");
        $stations = mysqli_fetch_all($res, MYSQLI_ASSOC);
        // print_r($stations);
        echo json_encode($stations);
    }

    if(isset($_POST['action']) && $_POST['action'] == 'get_trains'){

        $source_id = $_POST['source_stations'];
       
        $destination_id = $_POST['destination_stations'];

        $query = "
        SELECT t.train_name,t.train_code,t.id,ts.arrival,ts.departure,ts.distance
        FROM trains t
        JOIN timetable ts ON t.id = ts.train_id
        JOIN timetable td ON t.id = td.train_id
        WHERE ts.station_id = $source_id
        AND td.station_id = $destination_id
        AND ts.seq < td.seq
    ";

         $result = mysqli_query($con, $query);
         // print_r($result);
         $trains = [];
         while ($row = mysqli_fetch_assoc($result)) {
             $trains[] = $row;
        echo json_encode($trains);

         }
    }
?>