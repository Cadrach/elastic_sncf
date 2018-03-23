# elastic_sncf

Récupérer un token: https://www.digital.sncf.com/startup/api

Liste des retards: https://api.sncf.com/v1/coverage/sncf/disruptions

Liste des annulations: https://api.sncf.com/v1/coverage/sncf/traffic_reports

Détail d'un trip (n° de train): https://api.sncf.com/v1/coverage/sncf/trips/OCE:SN866741F01002

Détail des stations d'un trip: https://api.sncf.com/v1/coverage/sncf/trips/OCE:SN866741F01002/vehicle_journeys

# ElasticSearch docker launch
`docker run -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:6.2.3`
