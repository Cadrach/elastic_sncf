<?php
include 'clients.php';
use Carbon\Carbon;

$since = Carbon::now()->subMonth(3);

try{
    $clientElastic->indices()->create([
        'index' => 'journeys'
    ]);
}catch(\Elasticsearch\Common\Exceptions\BadRequest400Exception $e){

}

echo '<pre>';
$response = $clientSncf->get('traffic_reports/?since=' . $since->toIso8601String());
$result = json_decode($response->getBody(), true);

foreach($result['disruptions'] as $line){
    $integration = $clientElastic->index([
        'index' => 'traffic_reports',
        'type' => 'traffic_reports',
        'id' => $line['disruption_id'],
        'body' => $line,
    ]);

//    print_r($integration);

//    print_r($line);

    foreach($line['impacted_objects'] as $o){
        $tripId = $o['pt_object']['id'];

        //Look for the journey
        try{
            $trip = $clientElastic->getSource([
                'index' => 'journeys',
                'type' => 'journeys',
                'id' => $tripId,
            ]);
        }
        catch(\Elasticsearch\Common\Exceptions\Missing404Exception $e){
            echo "CREATE TRIP $tripId\n";

            $response = $clientSncf->get('trips/' . $tripId . '/vehicle_journeys');
            $journey = json_decode($response->getBody(), true);

            $clientElastic->index([
                'index' => 'journeys',
                'type' => 'journeys',
                'id' => $tripId,
                'body' => $journey['vehicle_journeys'][0],
            ]);

//            print_r($journey);

//            $integration = $clientElastic->index([
//                'index' => 'journeys',
//                'type' => 'journeys',
//                'id' => $line['disruption_id'],
//                'body' => $line,
//            ]);
        }
    }

//    die();
}


//print_r($result);