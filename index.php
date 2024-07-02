<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <title>trains_search</title>
</head>
<body>
<div class="row g-2">
    <div class="col-md">
        <div class="form-floating">
            <input type="text" class="form-control" id="source" placeholder="source_station" onkeyup="source_station(event)">
            <label for="source_station">source_station</label>
        </div>
    </div>
    <div class="col-md">
        <div class="form-floating">
            <input type="text" class="form-control" id="destination" placeholder="destination_station" onkeyup="source_station(event)">
            <label for="destination_station">Destination_station</label>
        </div>
    </div>
    <div>
        <input type="button" id="search_trains" onclick="search_trains()" value=" search_trains"   class="btn btn-dark">
    </div>
    <table id="trains_table" class="table table-bordered table-hovered table-striped table-sm">
            <thead class="table-danger">
                <tr>
                    <th onclick="sortData(event)" id="train_name">Train Name</th>
                    <th  onclick="sortData(event)" id="train_code">Train Code</th>
                    <th  onclick="sortData(event)" id="train_arrival">Arrival Time</th>
                    <th  onclick="sortData(event)" id="train_departure">Departure Time</th>
                    <th  onclick="sortData(event)" id="distance">Distance</th>
                    
                </tr>
            </thead>
            <tbody class="table-warning" id="trains_list">
            </tbody>
        </table>
    <script>
         var source_sta;
         var destination_sta;
        function source_station(event){
           
            $.ajax({
                url:"getdata.php",
                method:"POST",
                data:{
                    keyword:event.target.value,
                    action:"getstations"
                },
                success:function(response){
                    console.log(response);
                    var stations_List =[];
                    var stations = JSON.parse(response);
                    
                    for(i=0;i<stations.length;i++){
                        stations_List.push({
                            label:`${stations[i]['station_code']} ${stations[i]['station_name']}`,
                            value:stations[i]['station_name'],
                            id:stations[i]['id'],
                        });
                        
                    }
                    console.log(stations_List);
                    var e=event.target.id;
                    
                    $('#' + e).autocomplete({  
                        source: stations_List,
                        select: function (event, ui) {
                            if (e == "source") {
                                source_sta = ui.item.id;
                                console.log('Source Station ID:', source_sta);
                            } else if (e == "destination") {
                                destination_sta = ui.item.id;
                                console.log('Destination Station ID:', destination_sta);
                            }
                        }
                    });
                }
            });
        }

        function search_trains(){
            console.log(source_sta);
            console.log(destination_sta);
            $.ajax({
                url:"getdata.php",
                type:"POST",
                data:{
                    action:"get_trains",
                    source_stations:source_sta,
                    destination_stations:destination_sta
                },
                success: function(response) {
                console.log(response);
                trains = JSON.parse(response);
                var tableBody = $('#trains_table tbody');
                tableBody.empty();
                if (trains.length > 0) {
                    trains.forEach(function(train) {
                        var row = `<tr>
                            <td>${train.train_name}</td>
                            <td>${train.train_code}</td>
                            <td>${train.arrival}</td>
                            <td>${train.departure}</td>
                            <td>${train.distance}</td>
                        </tr>`;
                        tableBody.append(row);
                    });
                } else {
                    var row = `<tr><td colspan="5">No trains found</td></tr>`;
                    tableBody.html(row);
                }
            }
            });
        }

        function generate_list(){

        }
       
    </script>
</body>
</html>