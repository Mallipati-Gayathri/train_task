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
$res = mysqli_query( $con, "select * from trains");
while($row= mysqli_fetch_assoc($res)){
    $trains[$row['train_code']] = $row;
}

$cnt = 0;
	$line = fgets($fp,2048);
	while( $line = fgets($fp,2048) ){
		//echo $line;
		//if( $cnt > 100 ){break;}
		$cnt++;
		$data = explode(",", $line);
		//print_r( $data );
		//exit;
		$query = "insert into timetable set 
		train_id = '" . mysqli_escape_string($con, $trains[ $data[0] ]['id'] ) . "', 
		station_id = '" . mysqli_escape_string($con, $stations[ $data[3] ]['id'] ) . "',
		seq = '" . mysqli_escape_string($con, $data[2] ) . "',
		arrival = '" . mysqli_escape_string($con, $data[5] ) . "',
		departure = '" . mysqli_escape_string($con, $data[6] ) . "',
		distance = '" . mysqli_escape_string($con, $data[7] ) . "' ";
		echo $query . "\n"; 
		//exit;
	
	}

?>