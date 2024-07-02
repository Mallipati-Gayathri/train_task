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
$res = mysqli_query( $con, "select * from stations");
while($row= mysqli_fetch_assoc($res)){
    $stations[$row['station_code']] = $row;
}
$trains =[];

while($line = fgets($fp,2048)){

    $data = explode(",",$line);
    $trains[$data[0]] =[
        'name' => $data[1],
        'source' => $data[8],
        'dest' => $data[10]
    ];

}
foreach($trains as $train_code=>$details){

    $query = "INSERT  into trains set
            train_code ='".mysqli_escape_string($con,$train_code)."',
            train_name ='".mysqli_escape_string($con,$details['name'])."' 
            source_id = '" . mysqli_escape_string($con, $stations[ $details['source'] ]['id'] ) . "',
		    dest_id = '" . mysqli_escape_string($con, $stations[ $details['dest'] ]['id'] ) . "' ";
		echo $query . "\n"; 

}

?>