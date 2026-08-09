<?php

class DistanceService
{
    private string $apiKey;
    private string $originAddress = '12 rue de la liberté, 33200, Bordeaux, France';

    public function __construct()
    {
        $this->apiKey = $_ENV['ORS_API_KEY'];
    }

    public function getDistance(string $address): ?float
    {
        //Géocoder l'adresse de livraison
        $deliveryCoords = $this->geocode($address);
        $originCoords = $this->geocode($this->originAddress);

        if ($deliveryCoords === null || $deliveryCoords === null){
            return null;
        }

        //Calculer la distance
        return $this->calculateDistance($originCoords, $deliveryCoords);
    }

    private function geocode(string $address): ?array
    {
        $url = 'https://api-adresse.data.gouv.fr/search?'
            . http_build_query([
                'q'     => $address,
                'limit' => 1
            ]); 

        $response = file_get_contents($url);
        if ($response === false) return null;   

        $data = json_decode($response, true);
        if (empty($data['features'])) return null;  

        $coords = $data['features'][0]['geometry']['coordinates'];
        return ['lng' => (float) $coords[0], 'lat' => (float) $coords[1]];
    }

    private function calculateDistance(array $origin, array $destination): ?float
    {
        $url = 'https://api.openrouteservice.org/v2/directions/driving-car?' 
        .http_build_query(['api_key'=> $this->apiKey]);

        $body = json_encode([
            'coordinates' => [
                [$origin['lng'], $origin['lat']],
                [$destination['lng'], $destination['lat']]
            ]
        ]);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => $body
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        if ($response === false) return null;

        $data = json_decode($response, true);
        if (empty($data['routes'])) return null;

        //Distance en mètres -> conversion en km
        return $data['routes'][0]['summary']['distance']/1000;
    }
}