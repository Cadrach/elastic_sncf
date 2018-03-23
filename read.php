<?php
include 'clients.php';

echo '<pre>';

$params = [
    'index' => 'journeys',
    'type' => 'journeys',
    'id' => 'OCE:SN017625F02005',
];

$trip = $clientElastic->getSource($params);

$params = [
    'index' => 'journeys',
    'type' => 'journeys',
    'body' => [
        'query' => [
            'match' => [
                'stop_times.stop_point.name' => 'B'
            ]
        ]
    ]
];

$search = $clientElastic->search($params);

foreach($search['hits']['hits'] as $hit){
    $source = $hit['_source'];
    echo $source['name'] . "\t" . collect($source['stop_times'])->pluck('stop_point')->pluck('name')->implode(', ') . "\n";
//    collect($hit->getSource());
}
//print_r($search);
