<pre>
    <?php

$con = mysqli_connect("localhost","root","","train_list");

    if(mysqli_connect_error()){
        echo mysqli_connect_error();
    }



$fn="Train_details_22122017.csv";
$fp = fopen($fn,"r");
$line = fgets($fp,2048);

$stations =[];
$trains =[];

while($line = fgets($fp,2048)){

    $data = explode(",",$line);
    $stations[$data[3]] = $data[4];
    $trains[$data[0]] =  $data[1];
}

foreach($stations as $station_code => $station_name){

    $query = "INSERT  into stations set
              station_code '".mysqli_escape_string($con,$station_code)."',
              station_name '".mysqli_escape_string($con,$station_name)."' ";
    echo $query;

}

?>